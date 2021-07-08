<?php

namespace App\Http\Controllers;

use App\Models\Estados;
use Illuminate\Http\Request;
use Alert;
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
        $buscar=Estados::where('estado',$request->estado)->orWhere('color',$request->color)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del estado o color ya ha sido registrado')->persistent(true);
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function show(Estados $estados)
    {
        //
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
    public function update(Request $request, Estados $estados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estados  $estados
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estados $estados)
    {
        //
    }
}
