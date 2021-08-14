<?php

namespace App\Http\Controllers;

use App\Models\Iva;
use App\Models\Medio;
use App\Models\Cuotas;
use Illuminate\Http\Request;
use Alert;
use Datatables;
class IvaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $iva=Iva::all();
            return datatables()->of($iva)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editIva"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-iva" onClick="deleteIva('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('iva.index');
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
            'iva.required' => 'El campo iva es obligatorio',
            'iva.numeric' => 'El campo iva solo debe contener números',
        ];
        $validator = \Validator::make($request->all(), [
            'iva' => 'required|numeric',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Iva::where('iva',$request->iva)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El iva con dicho monto ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
                $buscar2=Iva::where('status','Activo')->count();
                if($buscar2 > 0){
                    //colocando inactivo al iva que se encuentra Activo
                    $b=Iva::where('status','Activo')->first();
                    $b->status='Inactivo';
                    $b->save();
                    //BUSCANDO MEDIOS DE MERCADO PARA CAMBIAR POR EL NUEVO IVA
                    $buscar_m=Medio::where('id_iva',$b->id)->count();
                }
                $iva= new Iva();
                $iva->iva=$request->iva;
                $iva->save();
                
                //ACTUALIZANDO MEDIOS DE PAGO EN CASO DE EXISTIR UN IVA ANTERIOR
                if($buscar2 > 0 && $buscar_m > 0){
                    $medios=Medio::where('id_iva',$b->id)->get();
                    foreach ($medios as $key) {
                        //REGISTRANDO EL MEDIO CON NUEVO IVA
                        $nuevo= new Medio();
                        $nuevo->medio=$key->medio;
                        $nuevo->porcentaje=$key->porcentaje;
                        $nuevo->id_iva=$iva->id;
                        $nuevo->save();
                        //----------------------------
                        //ACTUALIZANDO STATUS DEL MEDIO ANTERIOR
                        $key->status='Inactivo';
                        $key->save();
                        foreach ($key->cuotas as $key2) {
                            $nueva=new Cuotas();
                            $nueva->id_medio=$nuevo->id;
                            $nueva->cant_cuota=$key2->cant_cuota;
                            $nueva->interes=$key2->interes;
                            $nueva->save();
                        }
                    }
                }

                $ivas=Iva::all();
               return response()->json(['message' => "Iva con valor ".$request->iva." registrado con éxito",'icono' => 'success', 'titulo' => 'Éxito','iva' => $ivas]);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Iva  $iva
     * @return \Illuminate\Http\Response
     */
    public function show(Iva $iva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Iva  $iva
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $iva=Iva::where('id',$id)->first();

        return Response()->json($iva);    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Iva  $iva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_iva)
    {
        $message =[
            'iva.required' => 'El campo iva es obligatorio',
            'iva.numeric' => 'El campo iva solo debe contener números',
        ];
        $validator = \Validator::make($request->all(), [
            'iva' => 'required|numeric',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Iva::where('iva',$request->iva)->where('id','<>',$request->id_iva)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El iva con dicho monto ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
                
                $iva= Iva::find($request->id_iva);
                $iva->iva=$request->iva;
                $iva->save();

                $ivas=Iva::all();
               return response()->json(['message' => "Iva con valor ".$request->iva." actualizado con éxito",'icono' => 'success', 'titulo' => 'Éxito','iva' => $ivas]);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Iva  $iva
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$buscar=Pedidos::where('id_iva',$id)->count();
        if($buscar > 0){
            return response()->json(['message' => 'La categoría se encuentra registrada a algún producto','icono' => 'warning', 'titulo' => 'Alerta']);
        }else{*/
            $iva=Iva::find($id);
            if($iva->delete()){
                //ACTIVANDO EL ULTIMO IVA REGISTRADO
                $b=Iva::orderBy('id','DESC')->first();
                if($b!=NULL){
                    $b->status='Activo';
                    $b->save();
                }
              return response()->json(['message' => 'El Iva fue eliminado con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'El Iva no pudo ser eliminado','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        //}
    }
}
