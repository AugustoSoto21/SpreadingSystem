<?php

namespace App\Http\Controllers;

use App\Models\Agencias;
use Illuminate\Http\Request;
use App\Models\Tarifas;
use Alert;
use Datatables;

class AgenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $agencias=Agencias::all();
            return datatables()->of($agencias)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editAngencia"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteAngencia('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('agencias.index');
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
            'agencia.required' => 'El campo agencia es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'agencia' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Agencias::where('nombre',$request->agencia)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El nombre de la Agencia ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
           
            $agencia= new Agencias();
            $agencia->nombre=$request->agencia;
            $agencia->save();

             return response()->json(['message'=>"Agencia ".$request->nombre." registrada con éxito",'icono'=>'success','titulo'=>'Éxito']); 
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agencias  $agencias
     * @return \Illuminate\Http\Response
     */
    public function show(Agencias $agencias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agencias  $agencias
     * @return \Illuminate\Http\Response
     */
    public function edit(Agencias $agencias)
    {
        $agencias = Agencias::where('id',$id)->first();
        return Response()->json($agencias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agencias  $agencias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agencias $agencias)
    {
        $message =[
            'nombre.required' => 'El campo nombre es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'nombre' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Agencias::where('nombre',$request->agencia)->where('id','<>',$request->id_agencia)->count();

        if($buscar > 0){
           return response()->json(['message'=>"El nombre de la ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
            $agencia=  Agencias::find($request->id_agencia);
            $agencia->nombre=$request->agencia;
            $agencia->save();

            return response()->json(['message'=>"Agencia ".$request->nombre." modificada con éxito",'icono'=>'success','titulo'=>'Éxito']); 
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agencias  $agencias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agencias $agencias)
    {
        $buscar=Tarifas::where('id_agencia',$request->id_agencia)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La Agencia que intenta eliminar se encuentra asignada a una tarifa.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $agencia=Agencias::find($request->id_agencia);
            if($agencia->delete()){
              return response()->json(['message'=>"La Agencia fue eliminada con éxito.",'icono'=>'success','titulo'=>'Éxito']);  
            }else{
                return response()->json(['message'=>"El estado no pudo ser eliminado.",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        
    }
}
