<?php

namespace App\Http\Controllers;

use App\Models\Zonas;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use App\Models\Partidos;
use App\Models\Tarifas;
use Alert;
class ZonasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zonas=Zonas::all();
        $partidos=Partidos::all();
        return view('zonas.index',compact('zonas','partidos'));
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
        //dd($request->all());
        $buscar=Zonas::where('zona',$request->zona)->where('id_partido',$request->id_partido)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del zona ya ha sido registrado al partido seleccionado')->persistent(true);
        return redirect()->back();
        }else{
            
                $zona= new Zonas();
                $zona->zona=$request->zona;
                $zona->id_partido=$request->id_partido;
                $zona->save();

                Alert::success('Muy bien', 'Zona registrada con éxito')->persistent(true);
                return redirect()->back();
            
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
    public function edit(Zonas $zonas)
    {
        //
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
        $buscar=Zonas::where('zona',$request->mi_zona)->where('id_partido',$request->id_partido_edit)->where('id','<>',$request->id_zona_x)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del zona ya ha sido registrado al partido seleccionado')->persistent(true);
        return redirect()->back();
        }else{
            
                $zona= Zonas::find($request->id_zona_x);
                $zona->zona=$request->mi_zona;
                $zona->id_partido_edit=$request->id_partido_edit;
                $zona->save();

                Alert::success('Muy bien', 'Zona actualizada con éxito')->persistent(true);
                return redirect()->back();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zonas  $zonas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Tarifas::where('id_zona',$request->id_zona)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'La Zona que intenta eliminar se encuentra relacionada con alguna tarifa')->persistent(true);
        }else{
            $zona=Zonas::find($request->id_zona);
            if($zona->delete()){
              Alert::warning('Alerta', 'La zona no pudo ser eliminado')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'La zona fue eliminada con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
