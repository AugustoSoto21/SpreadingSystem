<?php

namespace App\Http\Controllers;

use App\Models\Partidos;
use Illuminate\Http\Request;
use Alert;
use App\Models\Zonas;
class PartidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partidos= Partidos::all();

        return view('partidos.index',compact('partidos'));
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
        $buscar=Partidos::where('partido',$request->partido)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del partido ya ha sido registrado')->persistent(true);
        return redirect()->back();
        }else{
           
            $partido= new Partidos();
            $partido->partido=$request->partido;
            $partido->save();

            Alert::success('Muy bien', 'Partido registrado con éxito')->persistent(true);
            return redirect()->back();
           
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
    public function edit(Partidos $partidos)
    {
        //
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
        $buscar=Partidos::where('partido',$request->partido)->where('id','<>',$request->id_partido)->count();

        if($buscar > 0){
            Alert::error('Error', 'El nombre del partido ya ha sido registrado')->persistent(true);
        return redirect()->back();
        }else{
            
            $partido=  Partidos::find($request->id_partido);
            $partido->partido=$request->partido;
            $partido->save();

            Alert::success('Muy bien', 'Partido actualizado con éxito')->persistent(true);
            return redirect()->back();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partidos  $partidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Zonas::where('id_partido',$request->id_partido)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'El partido que intenta eliminar se encuentra asignado a una zona')->persistent(true);
        }else{
            $partido=Partidos::find($request->id_partido);
            if($partido->delete()){
              Alert::warning('Alerta', 'El partido no pudo ser eliminado')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'El partido fue eliminado con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
