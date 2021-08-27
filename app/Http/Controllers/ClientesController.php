<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Models\Pedidos;
use Alert;
use Datatables;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $agencias=Clientes::all();
            return datatables()->of($agencias)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCliente"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteCliente('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('clientes.index');
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
        $message =[
            'nombres.required' => 'El campo nombres es obligatorio',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'celular.required' => 'El campo celular es obligatorio',
            'direccion.required' => 'El campo dirección es obligatorio',
            'localidad.required' => 'El campo localidad es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Clientes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->count();

        if($buscar > 0){
            return response()->json(['message'=>"Los Nombres, Apellidos y Celular del cliente ya han sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $cliente= new Clientes();
                $cliente->nombres=$request->nombres;
                $cliente->apellidos=$request->apellidos;
                $cliente->celular=$request->celular;
                $cliente->direccion=$request->direccion;
                $cliente->localidad=$request->localidad;

                $cliente->save();

                 return response()->json(['message'=>"Cliente ".$request->nombres." ".$request->nombres." con celular: ".$request->celular." registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
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
    public function edit($id)
    {
        $clientes=Clientes::where('id',$id)->first();
        return Response()->json($clientes);
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
        $message =[
            'nombres.required' => 'El campo nombres es obligatorio',
            'apellidos.required' => 'El campo apellidos es obligatorio',
            'celular.required' => 'El campo celular es obligatorio',
            'direccion.required' => 'El campo dirección es obligatorio',
            'localidad.required' => 'El campo localidad es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'localidad' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Clientes::where('nombres',$request->nombres)->where('apellidos',$request->apellidos)->where('celular',$request->celular)->where('id','<>',$request->id_cliente)->count();

        if($buscar > 0){
            return response()->json(['message'=>"Los Nombres, Apellidos y Celular del cliente ya han sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $cliente= Clientes::find($request->id_cliente);
                $cliente->nombres=$request->nombres;
                $cliente->apellidos=$request->apellidos;
                $cliente->celular=$request->celular;
                $cliente->direccion=$request->direccion;
                $cliente->localidad=$request->localidad;
                $cliente->save();

                return response()->json(['message'=>"Cliente ".$request->nombres." ".$request->nombres." con celular: ".$request->celular." actualizado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Pedidos::where('id_cliente',$id)->count();
        if($buscar > 0){
            
            return response()->json(['message'=>"El Cliente que intenta eliminar se encuentra relacionado con algún pedido",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            $cliente=Clientes::find($id);
            if($cliente->delete()){
              return response()->json(['message'=>"El cliente fue eliminado con éxito",'icono'=>'success','titulo'=>'Éxito']); 
            }else{
                return response()->json(['message'=>"El cliente no pudo ser eliminado",'icono'=>'warning','titulo'=>'Alerta']);
            }
        }
        return redirect()->back();
    }

    public function buscar_clientes()
    {
        $clientes=Clientes::orderby('id','DESC')->get();

        return response()->json($clientes);
    }
}
