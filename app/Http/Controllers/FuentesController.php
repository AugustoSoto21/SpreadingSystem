<?php

namespace App\Http\Controllers;

use App\Models\Fuentes;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Alert;
use Datatables;

class FuentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $fuentes=Fuentes::all();
            return datatables()->of($fuentes)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editFuente"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteFuente('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
            }
            return view('fuentes.index');
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
            'fuente.required' => 'El campo fuente es obligatorio',
            'fuente.unique' => 'El campo fuente ya se encuentra registrado.',
        ];
        $validator = \Validator::make($request->all(), [
            'fuente' => 'required|unique:fuentes',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Fuentes::where('fuente',$request->fuente)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La fuente ya se encuentra registrada",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
           
            $fuente= new Fuentes();
            $fuente->fuente=$request->fuente;
            $fuente->save();

            return response()->json(['message'=>"La fuente fue registrada con éxito",'icono'=>'success','titulo'=>'Éxito']);
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function show(Fuentes $fuentes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fuentes = Fuentes::where('id',$id)->first();
        return Response()->json($fuentes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_fuente)
    {
        $message =[
            'fuente.required' => 'El campo fuente es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'fuente' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Fuentes::where('fuente',$request->fuente)->where('id','<>',$request->id_fuente)->count();

        if($buscar > 0){
            return response()->json(['message'=>"La fuente ya fue registrada",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
            $fuente=  Fuentes::find($request->id_fuente);
            $fuente->fuente=$request->fuente;
            $fuente->save();

            return response()->json(['message'=>"La Fuente fue actualizada con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Pedidos::where('id_fuente',$id)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La Fuente que intenta eliminar se encuentra asignada a un pedido",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $fuente=Fuentes::find($id);
            if($fuente->delete()){
              return response()->json(['message'=>"La fuente se ha eliminada con éxito.",'icono'=>'success','titulo'=>'Éxito']);
            }else{
                return response()->json(['message'=>"La fuente no pudo ser eliminada.",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        
    }
}
