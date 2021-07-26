<?php

namespace App\Http\Controllers;

use App\Models\Partidos;
use Illuminate\Http\Request;
use Alert;
use App\Models\Zonas;
use Datatables;
class PartidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $partidos=Partidos::all();
            return datatables()->of($partidos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editPartido"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-partido" onClick="deletePartido('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('partidos.index');
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
            'partido.required' => 'El campo partido es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'partido' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Partidos::where('partido',$request->partido)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El nombre del partido ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);

        }else{
           
            $partido= new Partidos();
            $partido->partido=$request->partido;
            $partido->save();

            return response()->json(['message'=>"El partido ha sido registrado con éxito.",'icono'=>'success','titulo'=>'Éxito']);
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partidos  $partidos
     * @return \Illuminate\Http\Response
     */
    public function show(Partidos $partidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partidos  $partidos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $partidos=Partidos::where('id',$id)->first();
        return response()->json($partidos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partidos  $partidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_partido)
    {
        //dd($request->all());
        $message =[
            'partido.required' => 'El campo partido es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'partido' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Partidos::where('partido',$request->partido)->where('id','<>',$request->id_partido)->count();

        if($buscar > 0){
             return response()->json(['message'=>"El nombre del partido ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
            $partido=  Partidos::find($request->id_partido);
            $partido->partido=$request->partido;
            $partido->save();

            return response()->json(['message'=>"El partido ha sido actualizado con éxito.",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partidos  $partidos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Zonas::where('id_partido',$id)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El partido que intenta eliminar se encuentra asignado a una zona.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $partido=Partidos::find($id);
            if($partido->delete()){
              return response()->json(['message'=>"El partido ha sido eliminado con éxito.",'icono'=>'success','titulo'=>'Éxito']);
            }else{
                return response()->json(['message'=>"El partido no pudo ser eliminado.",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        
    }
}
