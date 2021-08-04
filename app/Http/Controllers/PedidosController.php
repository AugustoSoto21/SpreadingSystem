<?php

namespace App\Http\Controllers;

use App\Models\Pedidos;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Zonas;
use App\Models\Estados;
use App\Models\Agencias;
class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*$productos=Productos::where('status','Activo');
        $categorias=Categorias::all();
        $clientes=Clientes::all();
        $zonas=Zonas::all();
        $estados=Estados::all();
        $agencias=Agencias::all();
        return view('pedidos.create',compact('productos','categorias','clientes','zonas','estados','agencias'));*/
        $producto=\DB::table('productos')
            ->join('inventarios','inventarios.id_producto','=','productos.id')
            ->join('almacens','almacens.id_producto','=','productos.id')
            ->where('productos.id',2)
            ->select('productos.*','(inventarios.stock + almacens.stock) AS total_stock','(inventarios.stock_disponible + almacens.stock_disponible) AS total_disponible')->get();
        dd($producto);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function show(Pedidos $pedidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedidos $pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedidos $pedidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedidos  $pedidos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedidos $pedidos)
    {
        //
    }
}
