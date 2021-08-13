<?php

namespace App\Http\Controllers;

use App\Models\Deliverys;
use Illuminate\Http\Request;
use App\Models\Agencias;
use App\Models\Pedidos;
use Alert;
use Datatables;

class DeliverysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agencias=Agencias::all();
        if(request()->ajax()) {
            $deliverys=\DB::table('deliverys')->join('agencias','agencias.id','=','deliverys.id_agencia')->select('deliverys.*','agencias.nombre')->get();
            return datatables()->of($deliverys)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editDelivery"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-delivery" onClick="deleteDelivery('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('deliverys.index',compact('agencias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agencias=Agencias::all();
        return Response()->json($agencias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $message =[
            'delivery.required' => 'El campo delivery es obligatorio',
            'id_agencia.required' => 'El campo agencia es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'delivery' => 'required',
            'id_agencia' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Deliverys::where('delivery',$request->delivery)->where('id_agencia',$request->id_agencia)->count();
        if($buscar > 0){
            return response()->json(['message'=>"El delivery ya ha sido registrado en dicha agencia.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $delivery= new Deliverys();
                $delivery->delivery=$request->delivery;
                $delivery->id_agencia=$request->id_agencia;
                $delivery->save();

               return response()->json(['message' => "Delivery ".$request->delivery." registrado con éxito",'icono' => 'success', 'titulo' => 'Éxito']);
            
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
    public function edit($id)
    {
        //$deliverys=Deliverys::where('id',$id)->first();
        $deliverys=\DB::table('deliverys')
        ->join('agencias','agencias.id','=','deliverys.id_agencia')
        ->select('deliverys.*','agencias.nombre')
        ->where('deliverys.id',$id)->first();
        $agencias=Agencias::all();

        return Response()->json([$deliverys,$agencias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_delivery)
    {
        $message =[
            'delivery.required' => 'El campo delivery es obligatorio',
            'id_agencia.required' => 'El campo agencia es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'delivery' => 'required',
            'id_agencia' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Deliverys::where('delivery',$request->delivery)->where('id_agencia',$request->id_agencia_edit)->where('id','<>',$request->id_delivery)->count();
        if($buscar > 0){
            return response()->json(['message' => 'El delivery ya ha sido registrado en la agencia seleccionada','icono' => 'warning','titulo' => 'Alerta']);
        }else{
            
                $delivery= Deliverys::find($request->id_delivery);
                $delivery->delivery=$request->delivery;
                $delivery->id_agencia=$request->id_agencia;
                $delivery->save();

                return response()->json(['message' => 'El delivery actualizado con éxito', 'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Deliverys  $deliverys
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Pedidos::where('id_delivery',$id)->count();
        if($buscar > 0){
            return response()->json(['message' => 'El delivery se encuentra registrado a algún pedido','icono' => 'warning', 'titulo' => 'Alerta']);
        }else{
            $delivery=Deliverys::find($id);
            if($delivery->delete()){
              return response()->json(['message' => 'El delivery fue eliminado con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'El delivery no pudo ser eliminado','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        }
        
    }
}
