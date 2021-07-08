<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use Illuminate\Http\Request;
use Alert;
use App\Models\Pedidos;
class EstadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados=Estados::all();

        return view('estados.index',compact('estados'));
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
        $buscar=Estados::where('estado',$request->estado)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del estado ya ha sido registrado')->persistent(true);
        return redirect()->back();
        }else{
            $buscar=Estados::where('color',$request->color)->count();
            if($buscar > 0 ){
                Alert::error('Error', 'El color del estado ya ha sido registrado')->persistent(true);
                return redirect()->back();
            }else{
                $estado= new Estados();
                $estado->estado=$request->estado;
                $estado->color=$request->color;
                $estado->save();

                Alert::success('Muy bien', 'Estado registrado con éxito')->persistent(true);
                return redirect()->back();
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
    public function edit(Estados $estados)
    {
        //
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
        //dd($request->all());
        $buscar=Estados::where('estado',$request->estado)->where('id','<>',$request->id_estado)->count();

        if($buscar > 0){
            Alert::error('Error', 'El nombre del estado ya ha sido registrado')->persistent(true);
        return redirect()->back();
        }else{
            $buscar=Estados::where('color',$request->color)->where('id','<>',$request->id_estado)->count();
            if($buscar > 0 ){
                Alert::error('Error', 'El color del estado ya ha sido registrado')->persistent(true);
                return redirect()->back();
            }else{
                $estado=  Estados::find($request->id_estado);
                $estado->estado=$request->estado;
                $estado->color=$request->color;
                $estado->save();

                Alert::success('Muy bien', 'Estado actualizado con éxito')->persistent(true);
                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Pedidos::where('id_estado',$request->id_estado)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'El estado que intenta eliminar se encuentra asignado a un pedido')->persistent(true);
        }else{
            $estado=Estados::find($request->id_estado);
            if($estado->delete()){
              Alert::warning('Alerta', 'El estado no pudo ser eliminado')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'El estado fue eliminado con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
