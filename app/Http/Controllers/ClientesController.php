<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Alert;
class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Clientes::all();

        return view('clientes.index', compact('clientes'));
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
        $buscar=Clientes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->count();
        if($buscar > 0){
            Alert::error('Error', 'Los Nombres, Apellidos y Celular ya han sido registrados')->persistent(true);
        return redirect()->back();
        }else{
            
                $cliente= new Clientes();
                $cliente->nombres=$request->nombres;
                $cliente->apellidos=$request->apellidos;
                $cliente->celular=$request->celular;
                $cliente->direccion=$request->direccion;
                $cliente->localidad=$request->localidad;

                $cliente->save();

                Alert::success('Muy bien', 'Cliente registrado con éxito')->persistent(true);
                return redirect()->back();
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_cliente)
    {
        $buscar=Clientes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->where('id','<>',$request->id_cliente_x)->count();

        if($buscar > 0){
            Alert::error('Error', 'Los Nombres, Apellidos y Celular ya han sido registrados')->persistent(true);
        return redirect()->back();
        }else{
            
                $cliente= Clientes::find($request->id_cliente_x);
                $cliente->nombres=$request->nombres;
                $cliente->apellidos=$request->apellidos;
                $cliente->celular=$request->celular;
                $cliente->direccion=$request->direccion;
                $cliente->localidad=$request->localidad;
                $cliente->save();

                Alert::success('Muy bien', 'Cliente actualizado con éxito')->persistent(true);
                return redirect()->back();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Pedidos::where('id_cliente',$request->id_cliente)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'El Cliente que intenta eliminar se encuentra relacionado con algún pedido')->persistent(true);
        }else{
            $cliente=Clientes::find($request->id_cliente);
            if($cliente->delete()){
              Alert::warning('Alerta', 'La cliente no pudo ser eliminado')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'La cliente fue eliminada con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
