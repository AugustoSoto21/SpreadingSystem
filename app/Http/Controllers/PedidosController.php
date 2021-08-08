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
use App\Models\CarritoPedido;
date_default_timezone_set("America/Argentina/Buenos_Aires");
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
        $productos=Productos::where('status','Activo');
        $categorias=Categorias::all();
        $clientes=Clientes::all();
        $zonas=Zonas::all();
        $estados=Estados::all();
        $agencias=Agencias::all();
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

        return view('pedidos.create',compact('productos','categorias','clientes','zonas','estados','agencias','carrito'));
       
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

    public function llenar_carrito($id_producto,$id_cliente)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if($carrito > 0){
            //el usuario ya tiene un pedido en proceso
            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            $monto_descuento=$previo->monto_descuento;
            $porcentaje_descuento=$previo->porcentaje_descuento;
            $total_fact=$previo->total_fact;
            
            $carrito=new CarritoPedido();
            $carrito->id_cliente=$id_cliente;
            $carrito->id_user=\Auth::getUser()->id;
            $carrito->id_producto=$id_producto;
            $carrito->cantidad=1;
            $carrito->monto_und=0;
            $carrito->total_pp=0;
            $carrito->monto_descuento=$monto_descuento;
            $carrito->porcentaje_descuento=$porcentaje_descuento;
            $carrito->stock=producto_stock($id_producto);
            $carrito->disponible=producto_disponible($id_producto);
            $carrito->total_fact=$total_fact;
            $carrito->save();
            $actual=CarritoPedido::join('productos','productos.id','=','carrito_pedido.id_producto')
            ->where('id_user',\Auth::getUser()->id)
            ->select('carrito_pedido.*','productos.detalles','productos.marca','productos.modelo','productos.color')->get();

            return response()->json($actual);
        }else{
            //el usuario no tiene pedido en proceso
            $carrito=new CarritoPedido();
            $carrito->id_cliente=$id_cliente;
            $carrito->id_user=\Auth::getUser()->id;
            $carrito->id_producto=$id_producto;
            $carrito->cantidad=1;
            $carrito->monto_und=0;
            $carrito->total_pp=0;
            $carrito->monto_descuento=0;
            $carrito->porcentaje_descuento=0;
            $carrito->stock=producto_stock($id_producto);
            $carrito->disponible=producto_disponible($id_producto);
            $carrito->total_fact=0;
            $carrito->save();
            $actual=CarritoPedido::join('productos','productos.id','=','carrito_pedido.id_producto')
            ->where('id_user',\Auth::getUser()->id)
            ->select('carrito_pedido.*','productos.detalles','productos.marca','productos.modelo','productos.color')->get();

            return response()->json($actual);
        }
    }
}
