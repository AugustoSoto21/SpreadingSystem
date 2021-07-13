<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Alert;
use Datatables;

class EstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $estados=Estados::all();
            return datatables()->of($estados)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editEstado"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteEstado('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('estados.index');
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
        //dd($request->all());
        $message =[
            'estado.required' => 'El campo estado es obligatorio',
            'color.required' => 'El campo color es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'estado' => 'required',
            'color' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Estados::where('estado',$request->estado)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El nombre del estado ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $buscar=Estados::where('color',$request->color)->count();
            if($buscar > 0 ){
                return response()->json(['message'=>"El color del estado ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
            }else{
                $estado= new Estados();
                $estado->estado=$request->estado;
                $estado->color=$request->color;
                $estado->save();

                 return response()->json(['message'=>"Estado ".$request->estado." registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);  
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function show(Estados $estados)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estados = Estados::where('id',$id)->first();
        return Response()->json($estados);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message =[
            'estado.required' => 'El campo estado es obligatorio',
            'color.required' => 'El campo color es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'estado' => 'required',
            'color' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $buscar=Estados::where('estado',$request->estado)->where('id','<>',$request->id_estado)->count();

        if($buscar > 0){
            return response()->json(['message'=>"El nombre del estado ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $buscar=Estados::where('color',$request->color)->where('id','<>',$request->id_estado)->count();
            if($buscar > 0 ){
                return response()->json(['message'=>"El color del estado ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
            }else{
                $estado=  Estados::find($request->id_estado);
                $estado->estado=$request->estado;
                $estado->color=$request->color;
                $estado->save();

                return response()->json(['message'=>"Estado ".$request->estado." modificado con éxito",'icono'=>'success','titulo'=>'Éxito']);     
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Pedidos::where('id_estado',$id)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El estado que intenta eliminar se encuentra asignado a un pedido.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $estado=Estados::find($id);
            if($estado->delete()){
                return response()->json(['message'=>"El estado fue eliminado con éxito.",'icono'=>'success','titulo'=>'Éxito']);
            }else{
                return response()->json(['message'=>"El estado no pudo ser eliminado.",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
    }
}
