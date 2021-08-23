<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Almacen;
use App\Models\Agencias;
use App\Models\HistorialStocks;
date_default_timezone_set("America/Araguaina");
class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categorias::all();
        $agencias=Agencias::where('nombre','<>','SPREADING')->where('almacen','Si')->get();
        if(request()->ajax()) {
            $productos=\DB::table('productos')
            ->join('categorias','categorias.id','=','productos.id_categoria')
            ->join('inventarios','inventarios.id_producto','=','productos.id')
            ->select('productos.*','categorias.categoria','inventarios.stock','inventarios.stock_disponible','inventarios.stock_min','inventarios.stock_probar','inventarios.stock_fallas','inventarios.stock_devueltos')
            ->get();
            return datatables()->of($productos)
                ->editColumn('detalles',function($row){
                    $d=$row->detalles;
                    $ma=$row->marca;
                    $mo=$row->modelo;
                    $c=$row->color;
                    return $d.' '.$ma.' '.$mo.' '.$c;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('stocks.index',compact('categorias','agencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message =[
            'fecha.required' => 'Debe seleccionar la fecha',
            'id_agencia.required' => 'Debe seleccionar una agencia',
            'locker.required' => 'Debe seleccionar un locker',
            'id_producto.required' => 'Debe seleccionar un producto',
            'cantidad.required' => 'Debe ingresar una cantidad',
        ];
        $validator = \Validator::make($request->all(), [
            'fecha' => 'required',
            'id_agencia' => 'required',
            'locker' => 'required',
            'id_producto' => 'required',
            'cantidad' => 'required'

        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        //CUANDO ES LA AGENCIA SPREADING
        if($request->id_agencia==1){
            $buscar=Inventario::where('id_producto',$request->id_producto)->count();
            if($buscar > 0){
                //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA ES SPREADING
                $inventario=Inventario::where('id_producto',$request->id_producto)->first();
                switch ($request->locker) {
                    case 'SIN PROBAR':
                        $inventario->stock_probar=$inventario->stock_probar+$request->cantidad;
                        break;
                    case 'STOCK':
                        $inventario->stock=$inventario->stock+$request->cantidad;
                        $inventario->stock_disponible=$inventario->stock_disponible+$request->cantidad;
                        break;
                    case 'FALLA':
                        $inventario->stock_fallas=$inventario->stock_fallas+$request->cantidad;
                        break;
                    case 'RECLAMO':
                        $inventario->stock_reclamos=$inventario->stock_reclamos+$request->cantidad;
                        break;
                    case 'DEVUELTO':
                        $inventario->stock_devueltos=$inventario->stock_devueltos+$request->cantidad;
                        $inventario->stock=$inventario->stock+$request->cantidad;
                        $inventario->stock_disponible=$inventario->stock_disponible+$request->cantidad;
                        break;
                }
                $inventario->save();
                $historial= HistorialStocks::find($request->id_historial);
                $historial->fecha=$request->fecha;
                $historial->id_agencia=$request->id_agencia;
                $historial->locker=$request->locker;
                $historial->id_producto=$request->id_producto;
                $historial->cantidad=$request->cantidad;
                $historial->save();
                return response()->json(['message'=>"Historial registrado con éxito 1",'icono'=>'success','titulo'=>'Éxito']);  
            }else{
                //CUANDO NO EXISTE EL PRODUCTO EN INVENTARIO Y ES LA AGENCIA SPREADING
                $inventario=new Inventario();
                $inventario->id_producto=$request->id_producto;
                switch ($request->locker) {
                    case 'SIN PROBAR':
                        $inventario->stock_probar=$request->cantidad;
                        break;
                    case 'STOCK':
                        $inventario->stock=$request->cantidad;
                        $inventario->stock_disponible=$request->cantidad;
                        break;
                    case 'FALLA':
                        $inventario->stock_fallas=$request->cantidad;
                        break;
                    case 'RECLAMO':
                        $inventario->stock_reclamos=$request->cantidad;
                        break;
                    case 'DEVUELTO':
                        $inventario->stock_devueltos=$request->cantidad;
                        $inventario->stock=$request->cantidad;
                        $inventario->stock_disponible=$request->cantidad;
                        break;
                }//CIERRE DE SWITCH
                $inventario->save();
                $historial=HistorialStocks::find($request->id_historial);
                $historial->fecha=$request->fecha;
                $historial->id_agencia=$request->id_agencia;
                $historial->locker=$request->locker;
                $historial->id_producto=$request->id_producto;
                $historial->cantidad=$request->cantidad;
                $historial->save();
                return response()->json(['message'=>"Historial registrado con éxito 2",'icono'=>'success','titulo'=>'Éxito']);  
            }//CIERRE DE CONDICION DE EXISTENCIA DE PRODUCTO
        }else{
            //CUANDO LA AGENCIA NO ES SPREADING
            if($request->id_agencia!=1 && $request->locker=="SIN PROBAR"){
                //SI LA AGENCIA NO ES SPREADING Y EL LOCKER ES SIN PROBAR
                return response()->json(['message'=>"Historial no registrado ya que solo la agencia SPREADING agrega productos a probar",'icono'=>'warning','titulo'=>'Alerta']);  
            }else{
                //BUSCANDO SI LA AGENCIA TIENE ALMACÉN
                $agencia=Agencias::find($request->id_agencia);
                if($agencia->almacen=="No"){
                    return response()->json(['message'=>"Historial no registrado ya que la agencia ".$agencia->nombre." No posee Almacén",'icono'=>'warning','titulo'=>'Alerta']);
                }else{
                    $buscar=Almacen::where('id_producto',$request->id_producto)->where('id_agencia',$request->id_agencia)->count();
                    if($buscar > 0){
                        //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA NO ES SPREADING
                        $almacen=Almacen::where('id_producto',$request->id_producto)->where('id_agencia',$request->id_agencia)->first();
                        switch ($request->locker) {
                            case 'STOCK':
                                $almacen->stock=$almacen->stock+$request->cantidad;
                                $almacen->stock_disponible=$almacen->stock_disponible+$request->cantidad;
                                break;
                            case 'FALLA':
                                $almacen->stock_fallas=$almacen->stock_fallas+$request->cantidad;
                                break;
                            case 'RECLAMO':
                                $almacen->stock_reclamos=$almacen->stock_reclamos+$request->cantidad;
                                break;
                            case 'DEVUELTO':
                                $almacen->stock_devueltos=$almacen->stock_devueltos+$request->cantidad;
                                $almacen->stock=$almacen->stock+$request->cantidad;
                                $almacen->stock_disponible=$almacen->stock_disponible+$request->cantidad;
                                break;
                        }//CIERRE DEL SWITCH
                        $almacen->save();
                        $historial=HistorialStocks::find($request->id_historial);
                        $historial->fecha=$request->fecha;
                        $historial->id_agencia=$request->id_agencia;
                        $historial->locker=$request->locker;
                        $historial->id_producto=$request->id_producto;
                        $historial->cantidad=$request->cantidad;
                        $historial->save();
                        return response()->json(['message'=>"Historial registrado con éxito 3",'icono'=>'success','titulo'=>'Éxito']);  
                    }else{
                        //CUANDO NO EXISTE EL PRODUCTO EN INVENTARIO Y NO ES LA AGENCIA SPREADING
                        $almacen=new Almacen();
                        $almacen->id_agencia=$request->id_agencia;
                        $almacen->id_producto=$request->id_producto;
                        switch ($request->locker) {
                            case 'STOCK':
                                $almacen->stock=$request->cantidad;
                                $almacen->stock_disponible=$request->cantidad;
                                break;
                            case 'FALLA':
                                $almacen->stock_fallas=$request->cantidad;
                                break;
                            case 'RECLAMO':
                                $almacen->stock_reclamos=$request->cantidad;
                                break;
                            case 'DEVUELTO':
                                $almacen->stock_devueltos=$request->cantidad;
                                $almacen->stock=$request->cantidad;
                                $almacen->stock_disponible=$request->cantidad;
                                break;
                        }//CIERRE DE SWITCH
                        $almacen->save();
                        $historial=HistorialStocks::find($request->id_historial);
                        $historial->fecha=$request->fecha;
                        $historial->id_agencia=$request->id_agencia;
                        $historial->locker=$request->locker;
                        $historial->id_producto=$request->id_producto;
                        $historial->cantidad=$request->cantidad;
                        $historial->save();
                    }//CIERRE DE CONDICION DE EXISTENCIA DE PRODUCTO
                    return response()->json(['message'=>"Historial registrado con éxito 4",'icono'=>'success','titulo'=>'Éxito']);  
                }//FIN DE LA CONDICION SI LA AGENCIA NO TIENE ALMACEN

            }//FIN DE CONDICION SI LA AGENCIA NO ES SPREADING Y ELY EL LOCKER ES SIN PROBAR

        }//FIN DEL ELSE DE CUANDO ES UNA AGENCIA DISTINTA A SPREADING 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_historial)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $historial=HistorialStocks::find($id);
        //CUANDO ES LA AGENCIA SPREADING
        if($historial->id_agencia==1){
            
            //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA ES SPREADING
            $inventario=Inventario::where('id_producto',$historial->id_producto)->first();
            switch ($historial->locker) {
                case 'SIN PROBAR':
                    $inventario->stock_probar=$inventario->stock_probar-$historial->cantidad;
                    break;
                case 'STOCK':
                    $inventario->stock=$inventario->stock-$historial->cantidad;
                    $inventario->stock_disponible=$inventario->stock_disponible-$historial->cantidad;
                    break;
                case 'FALLA':
                    $inventario->stock_fallas=$inventario->stock_fallas-$historial->cantidad;
                    break;
                case 'RECLAMO':
                    $inventario->stock_reclamos=$inventario->stock_reclamos-$historial->cantidad;
                    break;
                case 'DEVUELTO':
                    $inventario->stock_devueltos=$inventario->stock_devueltos-$historial->cantidad;
                    $inventario->stock=$inventario->stock-$historial->cantidad;
                    $inventario->stock_disponible=$inventario->stock_disponible-$historial->cantidad;
                    break;
            }
            $inventario->save();
            $historial->delete();
            return response()->json(['message'=>"Historial eliminado con éxito 1",'icono'=>'success','titulo'=>'Éxito']);  
            
        }else{
            
            $buscar=Almacen::where('id_producto',$historial->id_producto)->where('id_agencia',$historial->id_agencia)->count();
            if($buscar > 0){
                //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA NO ES SPREADING
                $almacen=Almacen::where('id_producto',$historial->id_producto)->where('id_agencia',$historial->id_agencia)->first();
                switch ($historial->locker) {
                    case 'STOCK':
                        $almacen->stock=$almacen->stock-$historial->cantidad;
                        $almacen->stock_disponible=$almacen->stock_disponible-$historial->cantidad;
                        break;
                    case 'FALLA':
                        $almacen->stock_fallas=$almacen->stock_fallas-$historial->cantidad;
                        break;
                    case 'RECLAMO':
                        $almacen->stock_reclamos=$almacen->stock_reclamos-$historial->cantidad;
                        break;
                    case 'DEVUELTO':
                        $almacen->stock_devueltos=$almacen->stock_devueltos-$historial->cantidad;
                        $almacen->stock=$almacen->stock-$historial->cantidad;
                        $almacen->stock_disponible=$almacen->stock_disponible-$historial->cantidad;
                        break;
                }//CIERRE DEL SWITCH
                $almacen->save();
                $historial->delete();
                return response()->json(['message'=>"Historial eliminado con éxito 2",'icono'=>'success','titulo'=>'Éxito']);  
            }//FIN DE LA CONDICIÓN SI TIENE ALMACEN REGISTRADO  
                
        }//FIN DEL ELSE DE CUANDO ES UNA AGENCIA DISTINTA A SPREADING 
    }//FIN DE LA FUNCION DESTROY

    public function historial(){

        $agencias=Agencias::all();
        $productos=Productos::all();
        $categorias=Categorias::all();
        if(request()->ajax()) {
            $productos=\DB::table('historial_stocks')
            /*->join('productos','productos.id','=','historial_stocks.id_producto')
            ->join('agencias','agencias.id','=','historial_stocks.id_agencia')
            ->select('historial_stocks.*')*/
            ->get();
            return datatables()->of($productos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editHistorials"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteHistorials('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action','fecha','id_agencia','locker','id_producto','cantidad'])
                ->editColumn('fecha',function($row){
                    $hoy=date('Y-m-d');
                    $fecha="<div class='form-group'> <input type='date' name='fecha' required='required' value='".$row->fecha."' class='form-control form-control-sm' id='fecha".$row->id."' max='".$hoy."' />
                        </div>";
                    return $fecha;
                })
                ->editColumn('id_agencia',function($row){
                    $agencias=Agencias::all();
                    $a=Agencias::find($row->id_agencia);
                    $select="<div class='form-group'>
                                <select class='form-control form-control-sm' name='id_agencia' id='id_agencia".$row->id."'>";
                                foreach ($agencias as $k) {
                                    $select.="<option value='".$k->id."'";
                                    if($k->id==$row->id_agencia){ 
                                        $select.=" selected='selected' ";
                                     }
                                    $select.=" >".$k->nombre."</option>";
                                }
                            $select.="</select>
                            ";
                    return $select;
                })
                ->editColumn('locker',function($row){
                    $select2="<div class='form-group'>
                                <select class='form-control form-control-sm' name='locker' id='locker".$row->id."' onchange='cambiar_locker(this,".$row->id.")'>";
                            $select2.="<option value='SIN PROBAR'";
                            if($row->locker=="SIN PROBAR"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >SIN PROBAR</option>";
                            $select2.="<option value='STOCK'";
                            if($row->locker=="STOCK"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >STOCK</option>";
                            $select2.="<option value='FALLA'";
                            if($row->locker=="FALLA"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >FALLA</option>";
                            $select2.="<option value='RECLAMO'";
                            if($row->locker=="RECLAMO"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >RECLAMO</option>";
                    $select2.="</select>
                            </div>";
                    return $select2;
                })->editColumn('id_producto',function($row){
                    $productos=Productos::all();
                    $p=Productos::find($row->id_producto);
                    $select3="<div class='form-group'>
                                <select class='form-control form-control-sm' name='id_producto' id='id_producto".$row->id."' onchange='producto(this,".$row->id.")'>";
                        foreach ($productos as $k) {
                            $select3.="<option value='".$k->id."'";
                            if($k->id==$row->id_producto){ 
                                $select3.=" selected='selected' ";
                             }
                            $select3.=" >".$k->detalles." ".$k->marca." ".$k->modelo." ".$k->color."</option>";
                        }
                    $select3.="</select>
                    </div>";
                    return $select3;
                })
                ->editColumn('cantidad',function($row){
                    $campo="<div class='form-group'>
                    <input type='number' name='cantidad' id='cantidad".$row->id."' class='form-control form-control-sm' onkeyup='cambiar_cantidad(this,".$row->id.")' value='".$row->cantidad."'  />
                    </div>";
                    return $campo;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('stocks.historial',compact('agencias','productos','categorias'));
    }

    public function registrar(Request $request)
    {
        $message =[
            'fecha.required' => 'Debe seleccionar la fecha',
            'id_agencia.required' => 'Debe seleccionar una agencia',
            'locker.required' => 'Debe seleccionar un locker',
            'id_producto.required' => 'Debe seleccionar un producto',
            'cantidad.required' => 'Debe ingresar una cantidad',
            'id_categoria.required' => 'Debe seleccionar una categoría'
        ];
        $validator = \Validator::make($request->all(), [
            'fecha' => 'required',
            'id_agencia' => 'required',
            'locker' => 'required',
            'id_producto' => 'required',
            'cantidad' => 'required'

        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }


        //CUANDO ES LA AGENCIA SPREADING
        if($request->id_agencia==1){
            $buscar=Inventario::where('id_producto',$request->id_producto)->count();
            if($buscar > 0){
                //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA ES SPREADING
                $inventario=Inventario::where('id_producto',$request->id_producto)->first();
                switch ($request->locker) {
                    case 'SIN PROBAR':
                        $inventario->stock_probar=$inventario->stock_probar+$request->cantidad;
                        break;
                    case 'STOCK':
                        $inventario->stock=$inventario->stock+$request->cantidad;
                        $inventario->stock_disponible=$inventario->stock_disponible+$request->cantidad;
                        break;
                    case 'FALLA':
                        $inventario->stock_fallas=$inventario->stock_fallas+$request->cantidad;
                        break;
                    case 'RECLAMO':
                        $inventario->stock_reclamos=$inventario->stock_reclamos+$request->cantidad;
                        break;
                    case 'DEVUELTO':
                        $inventario->stock_devueltos=$inventario->stock_devueltos+$request->cantidad;
                        $inventario->stock=$inventario->stock+$request->cantidad;
                        $inventario->stock_disponible=$inventario->stock_disponible+$request->cantidad;
                        break;
                }
                $inventario->save();
                $historial=new HistorialStocks();
                $historial->fecha=$request->fecha;
                $historial->id_agencia=$request->id_agencia;
                $historial->locker=$request->locker;
                $historial->id_producto=$request->id_producto;
                $historial->cantidad=$request->cantidad;
                $historial->save();
                return response()->json(['message'=>"Historial registrado con éxito 1",'icono'=>'success','titulo'=>'Éxito']);  
            }else{
                //CUANDO NO EXISTE EL PRODUCTO EN INVENTARIO Y ES LA AGENCIA SPREADING
                $inventario=new Inventario();
                $inventario->id_producto=$request->id_producto;
                switch ($request->locker) {
                    case 'SIN PROBAR':
                        $inventario->stock_probar=$request->cantidad;
                        break;
                    case 'STOCK':
                        $inventario->stock=$request->cantidad;
                        $inventario->stock_disponible=$request->cantidad;
                        break;
                    case 'FALLA':
                        $inventario->stock_fallas=$request->cantidad;
                        break;
                    case 'RECLAMO':
                        $inventario->stock_reclamos=$request->cantidad;
                        break;
                    case 'DEVUELTO':
                        $inventario->stock_devueltos=$request->cantidad;
                        $inventario->stock=$request->cantidad;
                        $inventario->stock_disponible=$request->cantidad;
                        break;
                }//CIERRE DE SWITCH
                $inventario->save();
                $historial=new HistorialStocks();
                $historial->fecha=$request->fecha;
                $historial->id_agencia=$request->id_agencia;
                $historial->locker=$request->locker;
                $historial->id_producto=$request->id_producto;
                $historial->cantidad=$request->cantidad;
                $historial->save();
                return response()->json(['message'=>"Historial registrado con éxito 2",'icono'=>'success','titulo'=>'Éxito']);  
            }//CIERRE DE CONDICION DE EXISTENCIA DE PRODUCTO
        }else{
            //CUANDO LA AGENCIA NO ES SPREADING
            if($request->id_agencia!=1 && $request->locker=="SIN PROBAR"){
                //SI LA AGENCIA NO ES SPREADING Y EL LOCKER ES SIN PROBAR
                return response()->json(['message'=>"Historial no registrado ya que solo la agencia SPREADING agrega productos a probar",'icono'=>'warning','titulo'=>'Alerta']);  
            }else{
                //BUSCANDO SI LA AGENCIA TIENE ALMACÉN
                $agencia=Agencias::find($request->id_agencia);
                if($agencia->almacen=="No"){
                    return response()->json(['message'=>"Historial no registrado ya que la agencia ".$agencia->nombre." No posee Almacén",'icono'=>'warning','titulo'=>'Alerta']);
                }else{
                    $buscar=Almacen::where('id_producto',$request->id_producto)->where('id_agencia',$request->id_agencia)->count();
                    if($buscar > 0){
                        //CUANDO EXISTE EL PRODUCTO REGISTRADO EN INVENTARIO Y LA AGENCIA NO ES SPREADING
                        $almacen=Almacen::where('id_producto',$request->id_producto)->where('id_agencia',$request->id_agencia)->first();
                        switch ($request->locker) {
                            case 'STOCK':
                                $almacen->stock=$almacen->stock+$request->cantidad;
                                $almacen->stock_disponible=$almacen->stock_disponible+$request->cantidad;
                                break;
                            case 'FALLA':
                                $almacen->stock_fallas=$almacen->stock_fallas+$request->cantidad;
                                break;
                            case 'RECLAMO':
                                $almacen->stock_reclamos=$almacen->stock_reclamos+$request->cantidad;
                                break;
                            case 'DEVUELTO':
                                $almacen->stock_devueltos=$almacen->stock_devueltos+$request->cantidad;
                                $almacen->stock=$almacen->stock+$request->cantidad;
                                $almacen->stock_disponible=$almacen->stock_disponible+$request->cantidad;
                                break;
                        }//CIERRE DEL SWITCH
                        $almacen->save();
                        $historial=new HistorialStocks();
                        $historial->fecha=$request->fecha;
                        $historial->id_agencia=$request->id_agencia;
                        $historial->locker=$request->locker;
                        $historial->id_producto=$request->id_producto;
                        $historial->cantidad=$request->cantidad;
                        $historial->save();
                        return response()->json(['message'=>"Historial registrado con éxito 3",'icono'=>'success','titulo'=>'Éxito']);  
                    }else{
                        //CUANDO NO EXISTE EL PRODUCTO EN INVENTARIO Y NO ES LA AGENCIA SPREADING
                        $almacen=new Almacen();
                        $almacen->id_agencia=$request->id_agencia;
                        $almacen->id_producto=$request->id_producto;
                        switch ($request->locker) {
                            case 'STOCK':
                                $almacen->stock=$request->cantidad;
                                $almacen->stock_disponible=$request->cantidad;
                                break;
                            case 'FALLA':
                                $almacen->stock_fallas=$request->cantidad;
                                break;
                            case 'RECLAMO':
                                $almacen->stock_reclamos=$request->cantidad;
                                break;
                            case 'DEVUELTO':
                                $almacen->stock_devueltos=$request->cantidad;
                                $almacen->stock=$request->cantidad;
                                $almacen->stock_disponible=$request->cantidad;
                                break;
                        }//CIERRE DE SWITCH
                        $almacen->save();
                        $historial=new HistorialStocks();
                        $historial->fecha=$request->fecha;
                        $historial->id_agencia=$request->id_agencia;
                        $historial->locker=$request->locker;
                        $historial->id_producto=$request->id_producto;
                        $historial->cantidad=$request->cantidad;
                        $historial->save();
                    }//CIERRE DE CONDICION DE EXISTENCIA DE PRODUCTO
                    return response()->json(['message'=>"Historial registrado con éxito 4",'icono'=>'success','titulo'=>'Éxito']);  
                }//FIN DE LA CONDICION SI LA AGENCIA NO TIENE ALMACEN

            }//FIN DE CONDICION SI LA AGENCIA NO ES SPREADING Y EL LOCKER ES SIN PROBAR

        }//FIN DEL ELSE DE CUANDO ES UNA AGENCIA DISTINTA A SPREADING
        
    }//FIN DE LA FUNCION REGISTRAR

    public function editar($id){
        $historial=HistorialStocks::where('id',$id)->get();
        return Response()->json($historial);
    }

    public function buscar_stock_agencias($id_agencia)
    {
        
        
            $productos=\DB::table('productos')
            ->join('categorias','categorias.id','=','productos.id_categoria')
            ->join('almacens','almacens.id_producto','=','productos.id')
            ->where('almacens.id_agencia',$id_agencia)
            ->select('productos.*','categorias.categoria','almacens.stock','almacens.stock_disponible','almacens.stock_min','almacens.stock_reclamos','almacens.stock_fallas','almacens.stock_devueltos')
            ->get();
            return datatables()->of($productos)
                ->editColumn('detalles',function($row){
                    $d=$row->detalles;
                    $ma=$row->marca;
                    $mo=$row->modelo;
                    $c=$row->color;
                    return $d.' '.$ma.' '.$mo.' '.$c;
                })
                ->addIndexColumn()
                ->make(true);
        
    }
}
