<?php

namespace App\Http\Controllers;

use App\Models\Deliverys;
use Illuminate\Http\Request;
use App\Models\Agencias;
use App\Models\Pedidos;
class DeliverysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliverys=Deliverys::all();
        $agencias=Agencias::all();
        return view('deliverys.index',compact('deliverys','agencias'));
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
        $buscar=Deliverys::where('delivery',$request->delivery)->where('id_agencia',$request->id_agencia)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del delivery ya ha sido registrado al agencia seleccionada')->persistent(true);
        return redirect()->back();
        }else{
            
                $delivery= new Deliverys();
                $delivery->delivery=$request->delivery;
                $delivery->id_agencia=$request->id_agencia;
                $delivery->save();

                Alert::success('Muy bien', 'Delivery registrado con éxito')->persistent(true);
                return redirect()->back();
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function show(Deliverys $deliverys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function edit(Deliverys $deliverys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deliverys $deliverys)
    {
        $buscar=Deliverys::where('delivery',$request->mi_delivery)->where('id_agencia',$request->id_agencia_edit)->where('id','<>',$request->id_delivery_x)->count();
        if($buscar > 0){
            Alert::error('Error', 'El nombre del delivery ya ha sido registrado en la agencia seleccionada')->persistent(true);
        return redirect()->back();
        }else{
            
                $delivery= Deliverys::find($request->id_delivery_x);
                $delivery->delivery=$request->mi_delivery;
                $delivery->id_agencia_edit=$request->id_agencia_edit;
                $delivery->save();

                Alert::success('Muy bien', 'Delivery actualizado con éxito')->persistent(true);
                return redirect()->back();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $buscar=Pedidos::where('id_delivery',$request->id_delivery)->count();
        if($buscar > 0){
            Alert::warning('Alerta', 'El Delivery que intenta eliminar se encuentra relacionada con algún pedido')->persistent(true);
        }else{
            $delivery=Deliverys::find($request->id_delivery);
            if($delivery->delete()){
              Alert::warning('Alerta', 'La delivery no pudo ser eliminado')->persistent(true);  
            }else{
                Alert::warning('Alerta', 'La delivery fue eliminada con éxito')->persistent(true);
            }
        }
        return redirect()->back();
    }
}
