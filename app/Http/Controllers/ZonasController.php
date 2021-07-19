<?php

namespace App\Http\Controllers;

use App\Models\Zonas;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use App\Models\Partidos;
use App\Models\Tarifas;
use Alert;
use Datatables;

class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidos=Partidos::all();
        if(request()->ajax()) {
            //$zonas=Zonas::all();
            $zonas=\DB::table('zonas')
            ->join('partidos','partidos.id','=','zonas.id_partido')
            ->select('zonas.*','partidos.partido')->get();
            return datatables()->of($zonas)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editZona"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteZona('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('zonas.index',compact('partidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $partidos=Partidos::all();
        return response()->json($partidos);
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
            'zona.required' => 'El campo zona es obligatorio',
            'id_partido.required' => 'El campo partido es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'zona' => 'required',
            'id_partido' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Zonas::where('zona',$request->zona)->where('id_partido',$request->id_partido)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La Zona ya ha sido registrada en dicho partido.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $zona= new Zonas();
                $zona->zona=$request->zona;
                $zona->id_partido=$request->id_partido;
                $zona->save();

                return response()->json(['message'=>"La zona ha sido registrada con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function show(Zonas $zonas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$zonas=Zonas::where('id',$id)->first();
        $zonas=\DB::table('zonas')
            ->join('partidos','partidos.id','=','zonas.id_partido')
            ->where('zonas.id',$id)
            ->select('zonas.*','partidos.partido')->first();
        $partidos=Partidos::all();
        return response()->json([$zonas,$partidos]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_zona)
    {
        $message =[
            'zona.required' => 'El campo zona es obligatorio',
            'id_partido.required' => 'El campo partido es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'zona' => 'required',
            'id_partido' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Zonas::where('zona',$request->zona)->where('id_partido',$request->id_partido)->where('id','<>',$request->id_zona)->count();
        if($buscar > 0){
             return response()->json(['message'=>"La Zona ya ha sido registrada en dicho partido.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $zona= Zonas::find($request->id_zona);
                $zona->zona=$request->zona;
                $zona->id_partido=$request->id_partido;
                $zona->save();

                return response()->json(['message'=>"La zona ha sido actualizada con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Tarifas::where('id_zona',$id)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La Zona que intenta eliminar se encuentra relacionada con alguna tarifa",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $zona=Zonas::find($id);
            if($zona->delete()){
              return response()->json(['message'=>"La zona ha sido eliminada con éxito",'icono'=>'warning','titulo'=>'Éxito']);
            }else{
                return response()->json(['message'=>"La zona no pudo ser eliminada",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        
    }
}
