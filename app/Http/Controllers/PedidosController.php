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
use App\Models\Fuentes;
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
        $fuentes=Fuentes::all();
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
        $c=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
        if(count($carrito) > 0){
            $monto_descuento=$c->monto_descuento;
            $porcentaje_descuento=$c->porcentaje_descuento;
            $descuento_total=$c->descuento_total;
            $total_fact=$c->total_fact;
        }else{
            $monto_descuento=0;
            $porcentaje_descuento=0;
            $descuento_total=0;
            $total_fact=0;
        }

        return view('pedidos.create',compact('productos','categorias','clientes','zonas','estados','agencias','carrito','monto_descuento','porcentaje_descuento','descuento_total','total_fact','fuentes'));
        
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

            
            $carrito=new CarritoPedido();
            $carrito->id_cliente=$id_cliente;
            $carrito->id_user=\Auth::getUser()->id;
            $carrito->id_producto=$id_producto;
            $carrito->cantidad=1;
            $carrito->monto_und=0;
            $carrito->total_pp=0;
            $carrito->monto_descuento=$previo->monto_descuento;
            $carrito->porcentaje_descuento=$previo->porcentaje_descuento;
            $carrito->descuento_total=$previo->descuento_total;
            $carrito->stock=producto_stock($id_producto);
            $carrito->disponible=producto_disponible($id_producto);
            $carrito->total_fact=$previo->total_fact;
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
            $carrito->descuento_total=0;
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

    public function remove(Request $request)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {
            //se busca el producto en el carrito
            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$request->id_product_remove)->first();
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$request->id_product_remove){
                $sub_total+=$key->cantidad*$key->monto_und;
                }
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento > 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento > 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);



            //actualizando totales
            foreach ($previo2 as $key) {
                if($key->id_producto!=$request->id_product_remove){
                    $key->total_fact=$total;
                    $key->porcentaje_descuento=$porcentaje_descuento;
                    $key->descuento_total=$descuento_total;
                    $key->save();
                }
            }

            $eliminar=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$request->id_product_remove)->delete();

            return redirect()->back();
        }
                        
    }

    public function actualizar_cantidad_producto($nueva_cantidad,$id_producto)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$id_producto)->first();
            $previo->cantidad=$nueva_cantidad;
            $previo->total_pp=$nueva_cantidad*$previo->monto_und;
            $previo->save();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$id_producto){
                $sub_total+=$key->cantidad*$key->monto_und;
                }else{
                $sub_total+=$nueva_cantidad*$key->monto_und;

                }
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);



            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$porcentaje_descuento;
                $key->descuento_total=$descuento_total;
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$id_producto)->get();

            return response()->json($carrito);

        }
    }
    public function actualizar_costo_producto($nuevo_costo,$id_producto)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$id_producto)->first();
            $previo->monto_und=$nuevo_costo;
            $previo->total_pp=$nuevo_costo*$previo->cantidad;
            $previo->save();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$id_producto){
                $sub_total+=$key->cantidad*$key->monto_und;
                }else{
                $sub_total+=$nuevo_costo*$key->cantidad;

                }
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);



            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$porcentaje_descuento;
                $key->descuento_total=$descuento_total;
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->where('id_producto',$id_producto)->get();

            return response()->json($carrito);

        }
    }

    public function actualizar_monto_descuento($nuevo_monto)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$nuevo_monto;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);

            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->monto_descuento=$nuevo_monto;
                $key->descuento_total=$descuento_total;
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }
    public function actualizar_porcentaje_descuento($nuevo_monto)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$nuevo_monto;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);



            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$nuevo_monto;
                $key->descuento_total=$descuento_total;
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }

    public function calcular_recargo($valor)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$nuevo_monto;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);



            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$nuevo_monto;
                $key->descuento_total=$descuento_total;
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);
        }
    }
}
