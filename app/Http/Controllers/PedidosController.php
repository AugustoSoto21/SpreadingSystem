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
use App\Models\Medio;
use App\Models\Iva;
use App\Models\Cuotas;
    
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
        $medios=Medio::all();

        $iva=Iva::where('status','Activo')->first();
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
        $c=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
        if(count($carrito) > 0){
            $monto_descuento=$c->monto_descuento;
            $porcentaje_descuento=$c->porcentaje_descuento;
            $descuento_total=$c->descuento_total;
            $total_fact=$c->total_fact;
            $iva_total=$c->iva_total;
            $recargo_ct=$c->recargo_ct;
            $cuotas_ct=$c->cuotas_ct;
            $total_ct=$c->total_ct;
            $interes_ct=$c->interes_ct;
            $pago_delivery=$c->pago_delivery;
            $monto_pago_delivery=$c->monto_pago_delivery;
            $id_zona=$c->id_zona;
        }else{
            $monto_descuento=0;
            $porcentaje_descuento=0;
            $descuento_total=0;
            $total_fact=0;
            $iva_total=0;
            $recargo_ct=0;
            $cuotas_ct=0;
            $total_ct=0;
            $interes_ct=0;
            $pago_delivery=0;
            $monto_pago_delivery=0;
            $id_zona=0;
        }

        return view('pedidos.create',compact('productos','categorias','clientes','zonas','estados','agencias','carrito','monto_descuento','porcentaje_descuento','descuento_total','total_fact','iva_total','recargo_ct','cuotas_ct','total_ct','fuentes','medios','iva','interes_ct','pago_delivery','monto_pago_delivery','id_zona'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
            $carrito->id_cuota=$previo->id_cuota;
            $carrito->iva_total=$previo->iva_total;
            $carrito->monto_ct=$previo->monto_ct;
            $carrito->recargo_ct=$previo->recargo_ct;
            $carrito->cuotas_ct=$previo->cuotas_ct;
            $carrito->interes_ct=$previo->interes_ct;
            $carrito->total_ct=$previo->total_ct;
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
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$request->id_product_remove){
                $sub_total+=$key->cantidad*$key->monto_und;
                }
            }
            //en caso de tener pago de delivery
           
            $sub_total+=$monto_tarifa;
            
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento > 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento > 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);

            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;
                $total_ct2=$total+$recargo_ct;
                $monto_ct=$total;    
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct + $resta;
                $monto_ct=$previo->monto_ct;
            }
            
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }


            //actualizando totales
            foreach ($previo2 as $key) {
                if($key->id_producto!=$request->id_product_remove){
                    $key->total_fact=$total;
                    $key->porcentaje_descuento=$porcentaje_descuento;
                    $key->descuento_total=$descuento_total;
                    if($previo->recargo_ct > 0){
                        $key->monto_ct=$monto_ct;
                        $key->recargo_ct=$recargo_ct;
                        $key->cuotas_ct=$cuota->cant_cuota;
                        $key->interes_ct=$cada_cuota;
                        $key->total_ct=$total_ct2;
                    }

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
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$id_producto){
                $sub_total+=$key->cantidad*$key->monto_und;
                }else{
                $sub_total+=$nueva_cantidad*$key->monto_und;

                }
            }
            //en caso de tener pago de tarifa de delivery
            $sub_total+=$monto_tarifa;
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);

            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;    
                $total_ct2=$total+$recargo_ct;
                $monto_ct=$total;
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct+$resta;
                $monto_ct=$previo->monto_ct;
            }
            
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }


            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$porcentaje_descuento;
                $key->descuento_total=$descuento_total;
                if($previo->recargo_ct > 0){
                    $key->monto_ct=$monto_ct;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }
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
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                if($key->id_producto!=$id_producto){
                $sub_total+=$key->cantidad*$key->monto_und;
                }else{
                $sub_total+=$nuevo_costo*$key->cantidad;

                }
            }
            //en caso de tener pago de tarifa de delivery
            $sub_total+=$monto_tarifa;
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);

            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;
                $total_ct2=$total+$recargo_ct;
                $monto_ct=$total; 
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct+$resta;
                $monto_ct=$previo->monto_ct;
            }
            
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }

            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$porcentaje_descuento;
                $key->descuento_total=$descuento_total;
                if($previo->recargo_ct > 0){
                    $key->monto_ct=$monto_ct;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }
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
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            //en caso de tener pago de tarifa de delivery
            $sub_total+=$monto_tarifa;
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);
            //---------------------en caso de pago con tarjeta
            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;
                $total_ct2=$total+$recargo_ct;
                $monto_ct=$total;    
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct+$resta;
                $monto_ct=$previo->monto_ct;
            }
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }
            //--------------------------------------------------------------------------
            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->monto_descuento=$nuevo_monto;
                $key->descuento_total=$descuento_total;
                if($previo->recargo_ct > 0){
                    $key->monto_ct=$monto_ct;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }
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
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            //en caso de tener pago de delivery
            $sub_total+=$monto_tarifa;
            //realizando descuento
            $total=$sub_total;
            if ($porcentaje_descuento >= 0) {
                $total-=($porcentaje_descuento*$sub_total)/100;
            }
            if ($monto_descuento >= 0) {
                $total-=$monto_descuento;
            }
            $descuento_total=$monto_descuento+(($porcentaje_descuento*$sub_total)/100);

            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;
                $total_ct2=$total+$recargo_ct;   
                $monto_ct=$total; 
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct+$resta;
                $monto_ct=$previo->monto_ct;
            }
            
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }

            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->porcentaje_descuento=$nuevo_monto;
                $key->descuento_total=$descuento_total;
                if($previo->recargo_ct > 0){
                    $key->monto_ct=$monto_ct;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }

    public function calcular_recargo($id_cuota,$monto)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {
            $iva=Iva::where('status','Activo')->first();
            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
            if($id_cuota > 0){
            $cuota=Cuotas::find($id_cuota);
            $medio=Medio::find($cuota->id_medio);
            //formula:
            //pago total con tarjeta
            /*$total_ct=($monto/100 - ((($medio->porcentaje+$cuota->interes)*(($monto*21)/100)) + ($medio->porcentaje+$cuota->interes)))*100;*/
            //--------------------------------con calculadora---------------------------
            

                $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
                $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
                $total_porcentaje2=100-$total_porcentaje;
                $recargo_ct=($monto/$total_porcentaje2)*100-$monto;
                $total_ct2=$previo->total_fact+$recargo_ct;
                $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }
            //--------------------------------------------------------------------------

            //actualizando totales

            foreach ($previo2 as $key) {
                if($id_cuota > 0){
                    $key->id_cuota=$id_cuota;
                    $key->monto_ct=$monto;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }else{
                    $key->id_cuota=$id_cuota;
                    $key->monto_ct=0;
                    $key->recargo_ct=0;
                    $key->cuotas_ct=0;
                    $key->interes_ct=0;
                    $key->total_ct=0;
                }
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);
        }
    }

    public function buscar_agencias_tarifas($id_zona)
    {
         $agencias=\DB::table('tarifas')->join('zonas','zonas.id','=','tarifas.id_zona')
        ->join('agencias','agencias.id','=','tarifas.id_agencia')
        ->where('tarifas.id_zona',$id_zona)
        ->select('agencias.*','tarifas.id_agencia','tarifas.monto')->get();
        return $agencias;
    }

    public function agregar_tarifa_envio($monto,$opcion)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$previo->monto_descuento;
            $monto_tarifa=$previo->monto_pago_delivery;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            
            //realizando carga o quite de pago de delivery
            if ($opcion==1) {
                $sub_total+=$monto;
            } else {
                $sub_total-=$monto_tarifa;
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
            //---------------------en caso de pago con tarjeta
            if($previo->recargo_ct > 0){
            $cuota=Cuotas::find($previo->id_cuota);
            $medio=Medio::find($cuota->id_medio);
            $iva=Iva::where('status','Activo')->first();
            $iva_total=(($medio->porcentaje+$cuota->interes)*$iva->iva)/100;
            $total_porcentaje=$medio->porcentaje+$cuota->interes+$iva_total;
            $total_porcentaje2=100-$total_porcentaje;
            //en caso de que el monto a pagar con tarjeta sea igual al monto total de la factura
            if($previo->total_fact==$previo->monto_ct){
                $recargo_ct=($total/$total_porcentaje2)*100-$total;
                $total_ct2=$total+$recargo_ct;
                $monto_ct=$total;    
            }else{
                //CALCULANDO DIFERENCIA EN TOTALES
                if ($previo->total_fact > $total) {
                    $resta=$previo->total_fact - $total;
                } else {
                    $resta=$total - $previo->total_fact;
                }
                
                //en caso de que el monto sea distinto
                $recargo_ct=($previo->monto_ct/$total_porcentaje2)*100-$previo->monto_ct;
                $total_ct2=$previo->monto_ct+$recargo_ct+$resta;
                $monto_ct=$previo->monto_ct;
            }
            $cada_cuota=$total_ct2/$cuota->cant_cuota;
            }
            //--------------------------------------------------------------------------
            //actualizando totales
            foreach ($previo2 as $key) {
                
                $key->total_fact=$total;
                $key->descuento_total=$descuento_total;
                if($previo->recargo_ct > 0){
                    $key->monto_ct=$monto_ct;
                    $key->recargo_ct=$recargo_ct;
                    $key->cuotas_ct=$cuota->cant_cuota;
                    $key->interes_ct=$cada_cuota;
                    $key->total_ct=$total_ct2;
                }
                if ($opcion==1) {
                    $key->pago_delivery="Si";
                    $key->monto_pago_delivery=$monto;
                } else {
                    $key->monto_pago_delivery=0;
                    $key->pago_delivery="No";
                }
                
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }
}
