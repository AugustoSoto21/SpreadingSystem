<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Alert;
use Datatables;
use App\Models\Imagenes;
use App\Models\Inventario;
use App\Models\Almacen;
use App\Models\Categorias;
use App\Models\Agencias;
use App\Models\CarritoPedido;
class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $categorias=Categorias::all();
        if(request()->ajax()) {
            $productos=\DB::table('productos')
            ->join('categorias','categorias.id','=','productos.id_categoria')
            ->select('productos.*','categorias.categoria')
            ->get();
            return datatables()->of($productos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="productos/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editProducto"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteProducto('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
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

        return view('productos.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categorias::all();
        $agencias=Agencias::where('almacen','Si')->get();
        return view('productos.create',compact('categorias','agencias'));
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
            'detalles.required' => 'El campo nombres es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'id_categoria.required' => 'La Categoría es obligatoria',
            'status.required' => 'El campo status es obligatorio',
            //'imagenes.required' => 'El campo imagenes es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'detalles' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'id_categoria' => 'required',
            'status' => 'required',
            //'imagenes' => 'required',
        ],$message);



        /*if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }*/

        $buscar=Productos::where('detalles',$request->detalles)->where('marca',$request->marca)->where('modelo',$request->modelo)->where('color',$request->color)->count();
        
        if($buscar > 0){
            Alert::error('Alerta', 'Ya existe un producto con los mismos detalles, modelo y color.')->persistent(true);
            return redirect()->back();
        }else{
            //validando arreglo de almacen
            if(count($request->id_agencia) > 0 && count($request->stock) < count($request->id_agencia)){
                Alert::error('Alerta', 'Los campos de stock son obligatorios.')->persistent(true);
                return redirect()->back();
            }else{

                /*$validacion=$this->validar_imagen($request->file('imagenes'));
                if($validacion['valida'] > 0){
                    return response()->json(['message'=>"Error a enviar imágenes",'icono'=>'warning','titulo'=>'Alerta']);
                }*/
                //GENERANDO CODIGO DEL PRODUCTO
                    //fecha de primero
                    //$fecha=date('Ymd');
                    //3 primeras letras de la categoria
                    $categoria=Categorias::find($request->id_categoria);
                    $cat=substr($categoria->categoria, 0,3);
                    //codigo aleatorio de 4 digitos
                    $cod=$this->generarCodigo();
                    //$codigo=$fecha.$cat.$cod;
                    $codigo=$cat.$cod;
                //------------------------------
                $producto= new Productos();
                $producto->codigo=$codigo;
                $producto->detalles=$request->detalles;
                $producto->marca=$request->marca;
                $producto->modelo=$request->modelo;
                $producto->color=$request->color;
                $producto->id_categoria=$request->id_categoria;
                $producto->status=$request->status;
                $producto->save();
                
                //agregando inventario
                $inventario= new Inventario();
                $inventario->id_producto=$producto->id;
                $inventario->stock=$request->stock_s;
                $inventario->stock_disponible=$request->stock_s;
                $inventario->stock_min=$request->stock_min_s;
                $inventario->save();
                //----------------
                //-----------agregando almacén-----------
                $stock_min=array();
                if(count($request->stock_min)==0){
                    for ($i=0; $i < count($request->stock); $i++) { 
                        $stock_min[$i]=0;
                    }
                }else{
                    for ($i=0; $i < count($request->stock); $i++) { 
                        $stock_min[$i]=$request->stock_min[$i];
                    }
                }
                for ($i=0; $i < count($request->id_agencia); $i++) { 
                    $almacen= new Almacen();
                    $almacen->id_agencia=$request->id_agencia[$i];
                    $almacen->id_producto=$producto->id;
                    $almacen->stock=$request->stock[$i];
                    $almacen->stock_disponible=$request->stock[$i];
                    $almacen->stock_min=$stock_min[$i];
                    $almacen->save();
                }
                //-----------------------------------
                //cargando imagenes
                $imagenes=$request->file('imagenes');
                foreach($imagenes as $imagen){
                    $codigo=$this->generarCodigo();
                    /*
                    $validatedData = $request->validate([
                        'imagenes' => 'mimes:jpeg,png'
                    ]);*/
                    
                    $name=$codigo."_".$imagen->getClientOriginalName();
                    $imagen->move(public_path().'/img_productos', $name);  
                    $url ='img_productos/'.$name;
                    $img=new Imagenes();
                    $img->id_producto=$producto->id;
                    $img->nombre=$name;
                    $img->url=$url;
                    $img->save();

                    //$producto->imagenes()->attach($img);
                    
                }
                Alert::success('Muy bien', 'Producto registrado con éxito.')->persistent(true);
                return redirect()->to('productos');                
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=Productos::where('id',$id)->get();

        return $producto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $almacen=array();
        $productos=Productos::where('id',$id)->first();
        $categorias=Categorias::all();
        $agencias=Agencias::where('almacen','Si')->get();
        return view('productos.edit', compact('productos','categorias','agencias','almacen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_producto)
    {
        dd($request->all());
        $message =[
            'detalles.required' => 'El campo detalles es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'id_categoria.required' => 'La Categoría es obligatoria',
            'status.required' => 'El campo status es obligatorio',
            //'imagenes.required' => 'El campo imagenes es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'detalles' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'id_categoria' => 'required',
            'status' => 'required',
            //'imagenes' => 'required',
        ],$message);



        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Productos::where('detalles',$request->detalles)->where('marca',$request->marca)->where('modelo',$request->modelo)->where('color',$request->color)->where('id','<>',$request->id_producto)->count();

        if($buscar > 0){
            return response()->json(['message'=>"Ya existe un producto con los mismos detalles, marca, modelo y color",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            if(count($request->id_agencia) > 0 && count($request->stock) < count($request->id_agencia)){
                return response()->json(['message'=>"Los campos de stock son obligatorios",'icono'=>'warning','titulo'=>'Alerta']);
            }else{
                if($request->imagenes!=null){
                        $validacion=$this->validar_imagen($request->file('imagenes'));
                        if($validacion['valida'] > 0){
                            toastr()->warning('intente otra vez!!', $validacion['mensaje'].'');
                            return redirect()->back();
                        }  
                    }
                    $producto= Productos::find($request->id_producto);
                    $producto->detalles=$request->detalles;
                    $producto->marca=$request->marca;   
                    $producto->id_categoria=$request->id_categoria;
                    $producto->status=$request->status;

                    $producto->save();

                            //-----------agregando almacén-----------
                    $stock_min=array();
                    if(count($request->stock_min)==0){
                        for ($i=0; $i < count($stock); $i++) { 
                            $stock_min[$i]=0;
                        }
                    }else{
                        for ($i=0; $i < count($stock); $i++) { 
                            $stock_min[$i]=$request->stock_min[$i];
                        }
                    }
                    //ELEIMINANDO REGISTROS DEL ALMACÉN DEL PRODUCTO
                        \DB::table('almacen')->where('id_producto',$producto->id)->delete();
                    //-------
                    for ($i=0; $i < count($request->id_agencia); $i++) { 
                        $almacen= new Almacen();
                        $almacen->id_agencia=$request->id_agencia[$i];
                        $almacen->id_producto=$producto->id;
                        $almacen->stock=$request->stock[$i];
                        $almacen->stock_min=$stock_min[$i];
                        $almacen->save();
                    }
                    //-----------------------------------
                    if($request->imagenes!=null){
                        //cargando imagenes
                    $imagenes=$request->file('imagenes');
                        foreach($imagenes as $imagen){
                            $codigo=$this->generarCodigo();
                            /*
                            $validatedData = $request->validate([
                                'imagenes' => 'mimes:jpeg,png'
                            ]);*/
                            $name=$codigo."_".$imagen->getClientOriginalName();
                            $imagen->move(public_path().'/img_productos', $name);  
                            $url ='img_productos/'.$name;
                            $img=new Imagenes();
                            $img->id_producto=$producto->id;
                            $img->nombre=$name;
                            $img->url=$url;
                            $img->save();

                            $producto->imagenes()->attach($img);
                        }

                    }
                     return response()->json(['message'=>"Producto ".$producto->codigo." - ".$request->detalles." actualizado con éxito",'icono'=>'success','titulo'=>'Éxito']);
                }
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$buscar=Pedidos::where('id_producto',$id)->count();
        if($buscar > 0){
            
            return response()->json(['message'=>"El Cliente que intenta eliminar se encuentra relacionado con algún pedido",'icono'=>'warning','titulo'=>'Alerta']);
        }else{*/
            $inventario=\DB::table('inventario')->where('id_producto',$id)->delete();
            $almacen=\DB::table('almacen')->where('id_producto',$id)->delete();
            //esperando relacion con inventario
            $producto=Productos::find($id);
            if($producto->delete()){
              return response()->json(['message'=>"El producto fue eliminado con éxito",'icono'=>'success','titulo'=>'Éxito']); 
            }else{
                return response()->json(['message'=>"El producto no pudo ser eliminado",'icono'=>'warning','titulo'=>'Alerta']);
            }
        //}
        return redirect()->back();
    }
    protected function validar_imagen($imagenes)
    {
        //dd($imagenes);
        $mensaje="";
        $valida=0;
        foreach($imagenes as $imagen){
            //dd('asasas');
            $img=getimagesize($imagen);
            $size=$imagen->getClientSize();
            $width=$img[0];
            $higth=$img[1];
        }

        //dd($size."-".$width."-".$higth);

        if ($size>819200) {
            $mensaje="Alguna imagen excede el límite de tamaño de 800 KB ";
            $valida++;
        }

        if ($width>1024) {
            $mensaje.=" | Alguna imagen excede el límite de ancho de 1024 KB ";
            $valida++;
        }

        if ($higth>800) {
            $mensaje.=" | ALguna imagen excede el límite de altura de 800 KB ";
            $valida++;
        }

        $respuesta=['mensaje' => $mensaje,'valida' => $valida];

        return $respuesta;
    }

    protected function generarCodigo() {
     $key = '';
     $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $max = strlen($pattern)-1;
     for($i=0;$i < 4;$i++){
        $key .= $pattern=mt_rand(0,$max);
    }
     return $key;
    }

    public function eliminar_imagen(Request $request){

        $imagen=Imagenes::find($request->id_imagen);
        $url=$imagen->url;
        if($imagen->delete()){
            unlink($url);
            toastr()->success('Éxito!!', 'Imagen Eliminada');
                return redirect()->back();
        }else{
            toastr()->error('Error!!', 'La Imagen no pudo ser Eliminada');
                return redirect()->back();
        }
    }

    public function imagenes(){
        //dd('asasas');
        $productos=Productos::where('existencia','>',0)->get();
        $i=1;
        return view('productos.imagenes',compact('productos','i'));
    }

    public function welcome(){
        $productos=Productos::where('disponible','>',0)->get();
        $imagenes=array();
        $i=0;
        $j=0;
        foreach($productos as $key){
            foreach($key->imagenes as $key2){
                if($key2->pivot->mostrar=="Si" and $i<3){
                    $imagenes[$i]=$key2->url;
                    $i++;
                }
            }
        }
        return view('welcome',compact('productos','imagenes','j'));
    }

    public function mostrar(Request $request){
        //dd($request->all());
        $productos=\DB::table('productos')
        ->join('inventario','inventario.id_producto','=','productos.id')
        ->where('inventario.existencia','>',0)
        ->select('productos.*')->get();
        $contar=0;
        foreach($productos as $key){
            foreach($key->imagenes as $key2){
                if($key2->pivot->mostrar=="Si"){
                    $contar++;
                }
            }
        }
        if($contar==9 && $request->status=="No"){
            toastr()->error('Error!!', 'Ya se alcanzó el límite para mostrar imágenes');
            return redirect()->back();
        }else{
            foreach($productos as $key){
                foreach($key->imagenes as $key2){
                    if($key2->id==$request->id_imagen){
                        if($key2->pivot->mostrar=="No"){
                            $key2->pivot->mostrar="Si";
                        }else{
                            $key2->pivot->mostrar="No";    
                        }
                        $key2->pivot->save();
                    }
                }
            }

            toastr()->success('Éxito!!', 'La Imagen será mostrada en el portal');
            return redirect()->back();
        }
    }
    public function buscar_categorias()
    {
        $categorias=Categorias::all();
        return Response()->json($categorias);
    }
    public function buscar_productos()
    {
        $productos=Productos::where('status','Activo')->get();
        //$productos=Productos::all();
        //$productos=Productos::where('id',2)->get();
        return Response()->json($productos);
    }

    public function buscar_stock_producto($id_producto,$opcion)
    {
        $productos=Productos::find($id_producto);
        $en_carrito=CarritoPedido::where('id_producto',$id_producto)->where('id_user',\Auth::getUser()->id)->count();
        if($en_carrito == 0 && $opcion==1){
            if (count($productos->inventario) > 0 && count($productos->almacen) > 0) {
               $producto=\DB::table('productos')
                ->join('inventarios','inventarios.id_producto','=','productos.id')
                ->join('almacens','almacens.id_producto','=','productos.id')
                ->where('productos.id',$id_producto)
                ->select('productos.*','almacens.stock AS stock_a','inventarios.stock AS stock_i','almacens.stock_disponible AS disponible_a','inventarios.stock_disponible AS disponible_i',\DB::raw('(inventarios.stock + almacens.stock) AS total_stock'),\DB::raw('(inventarios.stock_disponible + almacens.stock_disponible) AS total_disponible'))->get();
            }else{
                 if(count($productos->inventario) > 0 && count($productos->almacen) == 0){
                $producto=\DB::table('productos')
                ->join('inventarios','inventarios.id_producto','=','productos.id')
                ->where('productos.id',$id_producto)
                ->select('productos.*','inventarios.stock AS total_stock','inventarios.stock_disponible AS total_disponible')->get();
                
                }else{
                     if (count($productos->inventario) == 0 && count($productos->almacen) > 0) {
                        $producto=\DB::table('productos')
                        ->join('almacens','almacens.id_producto','=','productos.id')
                        ->where('productos.id',$id_producto)
                        ->select('productos.*','almacens.stock AS total_stock','almacens.stock_disponible AS total_disponible')->get();
                    }else{
                        $producto=Productos::where('id',$id_producto)->get();
                    }
                }
            }
        }else{
            if($en_carrito > 0 and $opcion==1){
                 $producto=Productos::where('id',$id_producto)->get();
            }
        }
        //en caso de estar en el carrito
        if($en_carrito > 0 && $opcion==2){
                if (count($productos->inventario) > 0 && count($productos->almacen) > 0) {
               $producto=\DB::table('productos')
                ->join('inventarios','inventarios.id_producto','=','productos.id')
                ->join('almacens','almacens.id_producto','=','productos.id')
                ->where('productos.id',$id_producto)
                ->select('productos.*',\DB::raw('(inventarios.stock + almacens.stock) AS total_stock'),\DB::raw('(inventarios.stock_disponible + almacens.stock_disponible) AS total_disponible'))->get();
                }else{
                     if(count($productos->inventario) > 0 && count($productos->almacen) == 0){
                    $producto=\DB::table('productos')
                    ->join('inventarios','inventarios.id_producto','=','productos.id')
                    ->where('productos.id',$id_producto)
                    ->select('productos.*','inventarios.stock AS total_stock','inventarios.stock_disponible AS total_disponible')->get();
                    
                        }else{
                            if (count($productos->inventario) == 0 && count($productos->almacen) > 0) {
                            $producto=\DB::table('productos')
                            ->join('almacens','almacens.id_producto','=','productos.id')
                            ->where('productos.id',$id_producto)
                            ->select('productos.*','almacens.stock AS total_stock','almacens.stock_disponible AS total_disponible')->get();
                            }else{
                            $producto=Productos::where('id',$id_producto)->get();
                            }
                        }
                    }
                }else{
                    if($en_carrito ==0 && $opcion==2){
                        $producto=Productos::where('id',$id_producto)->get();
                    }
                }

        //$producto=Productos::where('id',$id_producto)->get();

        return Response()->json($producto);
    }
public function exit_product($id_producto){

    $cart_all=App\Models\CarritoPedido::join('productos','productos.id','=','carrito_pedido.id_product')
        ->where('carrito_pedido.id_user',\Auth::getUser()->id)
        ->select('products.*')->get();
        $i=0;
        foreach($cart_all as $key){
            if($key->id==$id_producto) $i++;
        }

        return $i;
}
    public function registrar(Request $request)
    {
        $message =[
            'detalles.required' => 'El campo nombres es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'id_categoria.required' => 'La Categoría es obligatoria',
            'status.required' => 'El campo status es obligatorio',
            //'imagenes.required' => 'El campo imagenes es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'detalles' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'id_categoria' => 'required'
            //'imagenes' => 'required',
        ],$message);

        $buscar=Productos::where('detalles',$request->detalles)->where('marca',$request->marca)->where('modelo',$request->modelo)->where('color',$request->color)->count();
        
        if($buscar > 0){
            return response()->json(['message'=>"Los detalles, modelo, marca y color ya han sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{

            //GENERANDO CODIGO DEL PRODUCTO
                //fecha de primero
                //$fecha=date('Ymd');
                //3 primeras letras de la categoria
                $categoria=Categorias::find($request->id_categoria);
                $cat=substr($categoria->categoria, 0,3);
                //codigo aleatorio de 4 digitos
                $cod=$this->generarCodigo();
                //$codigo=$fecha.$cat.$cod;
                $codigo=$cat.$cod;
            //------------------------------
                $producto= new Productos();
                $producto->codigo=$codigo;
                $producto->detalles=$request->detalles;
                $producto->marca=$request->marca;
                $producto->modelo=$request->modelo;
                $producto->color=$request->color;
                $producto->id_categoria=$request->id_categoria;
                $producto->save();

            $productos=Productos::where('status','Activo')->get();
            return response()->json(['message'=>"Producto registrado con éxito",'icono'=>'success','titulo'=>'Éxito','productos' => $productos]); 
        }

    }
}
