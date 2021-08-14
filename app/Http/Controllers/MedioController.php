<?php

namespace App\Http\Controllers;

use App\Models\Medio;
use App\Models\Cuotas;
use App\Models\Iva;
use Illuminate\Http\Request;
use Alert;
use Datatables;
class MedioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iva_activo=Iva::where('status','Activo')->count();
        if(request()->ajax()) {
            $medios=\DB::table('medios')->join('ivas','ivas.id','=','medios.id_iva')->select('medios.*','ivas.iva')->get();
            return datatables()->of($medios)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editMedio"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-medio" onClick="deleteMedio('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    $show = ' <a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-info btn-xs" id="showMedio"><i class="fa fa-eye"></i></a>';
                    if ($row->status=='Inactivo') {
                        $edit="";
                        $delete="";
                    }
                    
                    return $edit . $delete . $show;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('medios.index',compact('iva_activo'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
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
            'medio.required' => 'El campo medio es obligatorio',
            'porcentaje.required' => 'El campo porcentaje es obligatorio',
            'porcentaje.numeric' => 'El campo porcentaje solo debe contener números',
        ];
        $validator = \Validator::make($request->all(), [
            'medio' => 'required',
            'porcentaje' => 'required|numeric',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $iva=Iva::where('status','Activo')->first();
        $buscar=Medio::where('medio',$request->medio)->where('id_iva',$iva->id)->count();
        if ($buscar > 0) {
            return response()->json(['message'=>"El Medio ya se encuentra registrado para el iva activo",'icono'=>'warning','titulo'=>'Alerta']);
        } else {
            if (count($request->interes) == 0 || count($request->interes) < 5) {
                return response()->json(['message'=>"Faltaron montos de intereses en cuotas, debe registrarlos todos",'icono'=>'warning','titulo'=>'Alerta']);
            } else {
                $medio= new Medio();
                $medio->medio=$request->medio;
                $medio->porcentaje=$request->porcentaje;
                $medio->id_iva=$iva->id;
                $medio->save();

                //registrando cuotas
                $j=1;
                for ($i=0; $i <count($request->interes); $i++) {

                    $cuotas= new Cuotas();
                    $cuotas->id_medio=$medio->id;
                    $cuotas->cant_cuota=$j;
                    $cuotas->interes=$request->interes[$i];
                    $cuotas->save();
                    if($j==1){
                        $j+=2;
                    }else{
                        $j+=3;
                    }
                    
                }
                 return response()->json(['message'=>"Medio de Mercado Pago registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);   
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function show(Medio $medio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function edit($id_medio)
    {
        $medio=Medio::where('id',$id_medio)->get();

        return response()->json($medio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_medio)
    {
        $message =[
            'medio.required' => 'El campo medio es obligatorio',
            'porcentaje.required' => 'El campo porcentaje es obligatorio',
            'porcentaje.numeric' => 'El campo porcentaje solo debe contener números',
        ];
        $validator = \Validator::make($request->all(), [
            'medio' => 'required',
            'porcentaje' => 'required|numeric',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $iva=Iva::where('status','Activo')->first();
        $buscar=Medio::where('medio',$request->medio)->where('id_iva',$iva->id)->where('id','<>',$request->id_medio)->count();
        if ($buscar > 0) {
            return response()->json(['message'=>"El Medio ya se encuentra registrado para el iva activo",'icono'=>'warning','titulo'=>'Alerta']);
        } else {
            if (count($request->interes) == 0 || count($request->interes) < 5) {
                return response()->json(['message'=>"Faltaron montos de intereses en cuotas, debe registrarlos todos",'icono'=>'warning','titulo'=>'Alerta']);
            } else {
                $medio= Medio::find($request->id_medio);
                $medio->medio=$request->medio;
                $medio->porcentaje=$request->porcentaje;
                $medio->save();

                //registrando cuotas
                $i=0;
                foreach ($medio->cuotas as $key) {
                    $key->interes=$request->interes[$i];
                    $key->save();
                    $i++;
                }
                
                 return response()->json(['message'=>"Medio de Mercado Pago actualizado con éxito",'icono'=>'success','titulo'=>'Éxito']);   
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=\DB::table('pedidos')->join('pedidos_has_medios','pedidos_has_medios.id_pedido','=','pedidos.id')->join('cuotas','cuotas.id','=','pedidos_has_medios.id_cuota')->join('medios','medios.id','=','cuotas.id_medio')->where('medios.id',$id)->select('medios.*')->count();
         $buscar2=\DB::table('carrito_pedido')->join('carrito_pedidos_has_medios','carrito_pedidos_has_medios.id_carrito','=','carrito_pedido.id')->join('cuotas','cuotas.id','=','carrito_pedidos_has_medios.id_cuota')->join('medios','medios.id','=','cuotas.id_medio')->where('medios.id',$id)->select('medios.*')->count();
        if ($buscar > 0 || $buscar2 > 0) {
               return response()->json(['message'=>"No se puede eliminar ya que existen pedidos registrados con dicho medio",'icono'=>'warning','titulo'=>'Alerta']);
           } else {
               $medio=Medio::find($id);
               if ($medio->delete()) {
                   return response()->json(['message'=>"Medio de mercado pago eliminado con éxito",'icono'=>'success','titulo'=>'Éxito']);
               } else {
                   return response()->json(['message'=>"No se puede eliminar el medio de mercado pago",'icono'=>'warning','titulo'=>'Alerta']);
               }
               
           }
              
    }

    public function buscar_cuotas($id_medio)
    {
        $cuotas=Cuotas::where('id_medio',$id_medio)->get();
        return response()->json($cuotas);
    }
}
