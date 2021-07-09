<?php

namespace App\Http\Controllers;

use App\Models\Fuentes;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Alert;
class FuentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fuentes= Fuentes::all();

        return view('fuentes.index',compact('fuentes'));
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
        $buscar=Fuentes::where('fuente',$request->fuente)->count();
        if($buscar > 0){
            Alert::error('Error', 'El fuente ya ha sido registrada')->persistent(true);
        return redirect()->back();
        }else{
           
            $fuente= new Fuentes();
            $fuente->fuente=$request->fuente;
            $fuente->save();

            Alert::success('Muy bien', 'Fuente registrada con éxito')->persistent(true);
            return redirect()->back();
           
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
    public function edit(Fuentes $fuentes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fuentes $fuentes)
    {
        $buscar=Fuentes::where('fuente',$request->fuente)->where('id','<>',$request->id_fuente)->count();

        if($buscar > 0){
            Alert::error('Error', 'La fuente ya ha sido registrada')->persistent(true);
            return redirect()->back();
        }else{
            
            $fuente=  Fuentes::find($request->id_fuente);
            $fuente->fuente=$request->fuente;
            $fuente->save();

            Alert::success('Muy bien', 'Fuente actualizada con éxito')->persistent(true);
            return redirect()->back();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fuentes  $fuentes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Pedidos::where('id_fuente',$request->id_fuente)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'La Fuente que intenta eliminar se encuentra asignado a un pedido')->persistent(true);
        }else{
            $fuente=Fuentes::find($request->id_fuente);
            if($fuente->delete()){
              Alert::warning('Alerta', 'La fuente no pudo ser eliminada')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'La fuente fue eliminada con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
