<?php

namespace App\Http\Controllers;

use App\Models\Agencias;
use Illuminate\Http\Request;
use App\Models\Tarifas;
class AgenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agencias=Agencias::all();

        return view('agencias.index', compact('agencias'));
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
        $buscar=Agencias::where('nombre',$request->agencia)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre de la agencia ya ha sido registrada')->persistent(true);
        return redirect()->back();
        }else{
           
            $agencia= new Agencias();
            $agencia->nombre=$request->agencia;
            $agencia->save();

            Alert::success('Muy bien', 'Agencia registrada con éxito')->persistent(true);
            return redirect()->back();
           
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
        //
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
        $buscar=Agencias::where('nombre',$request->agencia)->where('id','<>',$request->id_agencia)->count();

        if($buscar > 0){
            Alert::error('Error', 'El nombre de la agencia ya ha sido registrada')->persistent(true);
            return redirect()->back();
        }else{
            
            $agencia=  Agencias::find($request->id_agencia);
            $agencia->nombre=$request->agencia;
            $agencia->save();

            Alert::success('Muy bien', 'Agencia actualizada con éxito')->persistent(true);
            return redirect()->back();
            
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
            Alert::warning('Alerta', 'La Agencia que intenta eliminar se encuentra asignado a una Tarifa')->persistent(true);
        }else{
            $agencia=Agencias::find($request->id_agencia);
            if($agencia->delete()){
              Alert::warning('Alerta', 'La agencia no pudo ser eliminada')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'La agencia fue eliminada con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
