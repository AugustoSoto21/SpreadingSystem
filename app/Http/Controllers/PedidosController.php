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
use App\Models\Tarifas;
use App\Models\Inventario;
use App\Models\Horarios;
use Alert;
use Datatables;
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
        $fuentes=Fuentes::all();
        $estados=Estados::all();
        if(request()->ajax()) {
            $pedidos=Pedidos::all();
            return datatables()->of($pedidos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="pedidos/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editPedido"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deletePedido('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->editColumn('id_cliente',function($row){
                    $cliente=Clientes::find($row->id_cliente);

                    return $cliente->nombres.' '.$cliente->apellidos.' '.$cliente->celular;
                })
                ->editColumn('id_user',function($row){
                    $recep=User::find($row->id_user);

                    return $recep->recep->nombres.' '.$recep->recep->apellidos;
                })
                ->editColumn('id_fuente',function($row){

                    $select_f='<select name="id_fuente" id="id_fuente" class="form-control">';
                    foreach($fuentes as $f){
                        $select_f.='<option value="'.$f->id.'"'; 
                        if($row->id_fuente==$f->id){ 
                         $select_f.=' selected="selected"';
                        } 
                        $select_f.=' >'.$f->fuente.'</option>';
                    }
                    $select_f.='</select>';

                    return $select_f;
                })->editColumn('id_estado',function($row){

                    $select_e='<select name="id_estado" id="id_estado" class="form-control">';
                    foreach($estados as $e){
                        $select_e.='<option value="'.$e->id.'"'; 
                        if($row->id_estado==$e->id){ 
                         $select_e.=' selected="selected"';
                        } 
                        $select_e.=' >'.$e->estado.'</option>';
                    }
                    $select_e.='</select>';

                    return $select_e;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('pedidos.index');
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
        $tarifas=Tarifas::all();
        $estados=Estados::all();
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

            $envio_gratis=$c->envio_gratis;
            $id_zona=$c->id_zona;
            $monto_tarifa=$c->monto_tarifa;
            $id_tarifa=$c->id_tarifa;

            $id_fuente=0;
            $id_estado=0;
            $observacion="";

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
            $envio_gratis="Si";
            $id_zona=0;
            $monto_tarifa=0;
            $id_tarifa=0;
            $id_fuente=0;
            $id_estado=0;
            $observacion="";
        }

        return view('pedidos.create',compact('productos','categorias','clientes','zonas','estados','agencias','carrito','monto_descuento','porcentaje_descuento','descuento_total','total_fact','iva_total','recargo_ct','cuotas_ct','total_ct','fuentes','medios','iva','interes_ct','envio_gratis','id_zona','monto_tarifa','id_tarifa','tarifas','estados','id_fuente','id_estado','observacion'));
        
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
        
        //VERIFICANDO SI EXISTE UN CARRITO PARA EL USUARIO
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if($carrito > 0){
            //el usuario ya tiene un pedido en proceso
            //obteniendo los datos unicos
            $p=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            //obteniendo los demas datos
            $pedido=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
            $codigo=date('d').strtoupper(date('M')).date('y').$this->generarCodigo2();
            //dd($codigo);
            //BUSCANDO EL CODIGO PARA EVITAR REPETIRLO
            $found=0;
            do{
             $buscar=Pedidos::where('codigo',$codigo)->count();
             if($buscar > 0){
                $found=1;
             }   
            }while ($found==1);
            //REGISTRANDO PEDIDO NUEVO
            foreach ($pedido as $key) {
                $nuevo_pedido= new Pedidos();
                $nuevo_pedido->codigo=$codigo;
                $nuevo_pedido->id_cliente=$key->id_cliente;
                $nuevo_pedido->id_user=$key->id_user;
                $nuevo_pedido->id_producto=$key->id_producto;
                $nuevo_pedido->cantidad=$key->cantidad;
                $nuevo_pedido->monto_und=$key->monto_und;
                $nuevo_pedido->total_pp=$key->total_pp;
                $nuevo_pedido->monto_descuento=$key->monto_descuento;
                $nuevo_pedido->porcentaje_descuento=$key->porcentaje_descuento;
                $nuevo_pedido->descuento_total=$key->descuento_total;
                $nuevo_pedido->iva_total=$key->iva_total;
                $nuevo_pedido->monto_ct=$key->monto_ct;
                $nuevo_pedido->recargo_ct=$key->recargo_ct;
                $nuevo_pedido->total_ct=$key->total_ct;
                $nuevo_pedido->id_cuota=$key->id_cuota;
                $nuevo_pedido->cuotas_ct=$key->cuotas_ct;
                $nuevo_pedido->interes_ct=$key->interes_ct;
                $nuevo_pedido->total_fact=$key->total_fact;
                $nuevo_pedido->id_zona=$key->id_zona;
                $nuevo_pedido->envio_gratis=$key->envio_gratis;
                $nuevo_pedido->id_tarifa=$key->id_tarifa;
                $nuevo_pedido->id_fuente=$request->id_fuente;
                $nuevo_pedido->id_estado=$request->id_estado;
                $nuevo_pedido->observacion=$request->observacion;
                $nuevo_pedido->save();
                if($key->id_estado > 0){
                    $estado=Estados::find($key->id_estado);
                    if($estado->estado=="AFIRMADO"){
                        //SE DESCONTARÁ DE INVENTARIO O ALMACÉN DE DISPONIBLE
                        //BUSCANDO AGENCIA ENCARGADA
                        if($key->id_tarifa > 0){
                            $tarifa=Tarifa::find($key->id_tarifa);
                            if ($tarifa->id_agencia==1) {
                                $inventario=Inventario::where('id_producto',$key->id_producto)->first();
                                $inventario->stock_disponible=$inventario->stock_disponible-$key->cantidad;
                                $inventario->save();
                            } else {
                                $agencia=Agencias::find($tarifa->id_agencia);
                                if($agencia->almacen=="Si"){
                                    $almacen=Almacen::where('id_producto',$key->id_producto)->where('id_agencia',$tarifa->id_agencia)->first();
                                    $almacen->stock_disponible=$almacen->stock_disponible-$cantidad;
                                    $almacen->save();

                                }else{
                                    $inventario=Inventario::where('id_producto',$key->id_producto)->first();
                                    $inventario->stock_disponible=$inventario->stock_disponible-$key->cantidad;
                                    $inventario->save();
                                }
                            }
                        }
                    }
                }
                
            }
            //REGISTRANDO HORARIOS
            if (count($request->horarios) > 0) {
                for ($i=0; $i < count($request->horarios); $i++) { 
                    $horario= new Horarios();
                    $horario->horario = $request->horarios[$i];
                    $horario->hora_inicio= $request->hora_inicio[$i];
                    $horario->hora_fin= $request->hora_fin[$i];
                    $horario->direccion= $request->direccion[$i];
                    $horario->codigo_pedido= $codigo;
                    $horario->save();
                }
            }
            
            //ELIMINANDO EL PEDIDO DEL CARRITO
            foreach ($pedido as $key) {
                $key->delete();
            }
            Alert::success('Éxito', 'Pedido registrado con éxito')->persistent(true);
                return redirect()->to('pedidos');
        }else{
            Alert::error('Alerta', 'No tiene ningún pedido en proceso')->persistent(true);
                return redirect()->back();
        }
        
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
            $monto_tarifa=$previo->monto_tarifa;
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
            $monto_tarifa=$previo->monto_tarifa;
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
            $monto_tarifa=$previo->monto_tarifa;
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
            $monto_tarifa=$previo->monto_tarifa;
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
            $monto_tarifa=$previo->monto_tarifa;
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
        ->select('agencias.nombre','tarifas.*')->get();
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
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            
            //realizando carga o quite de pago de delivery
            if ($opcion==1) {
                $sub_total+=$monto;
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
                    $key->envio_gratis="No";
                    $key->monto_tarifa=$monto;
                } else {
                    $key->monto_tarifa=0;
                    $key->envio_gratis="Si";
                }
                
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }

    public function agregar_tarifa_envio_agencia($id_tarifa,$opcion)
    {
        $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->count();
        if ($carrito > 0) {

            $previo=CarritoPedido::where('id_user',\Auth::getUser()->id)->first();
            
            $previo2=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();
            $tarifa=Tarifas::find($id_tarifa);
            if($tarifa){
                $monto=$tarifa->monto;
            }else{
                $monto=0;
            }
            $porcentaje_descuento=$previo->porcentaje_descuento;
            $monto_descuento=$previo->monto_descuento;
            $sub_total=0;
            foreach ($previo2 as $key) {
                $sub_total+=$key->cantidad*$key->monto_und;
            }
            
            //realizando carga o quite de pago de delivery
            if ($opcion==1) {
                $sub_total+=$monto;
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
                    $key->envio_gratis="No";
                    $key->monto_tarifa=$monto;
                } else {
                    $key->monto_tarifa=0;
                    $key->envio_gratis="Si";
                }
                
                $key->save();
                
            }

            $carrito=CarritoPedido::where('id_user',\Auth::getUser()->id)->get();

            return response()->json($carrito);        
        }
    }

     protected function generarCodigo2() {
     $key = '';
     $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $max = strlen($pattern)-1;
     for($i=0;$i < 2;$i++){
        $key .= $pattern=mt_rand(0,$max);
    }
     return $key;
    }
}
