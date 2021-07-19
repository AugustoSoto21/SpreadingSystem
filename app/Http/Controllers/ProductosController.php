<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Alert;
use Datatables;
class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            $productos=Productos::all();
            return datatables()->of($productos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editProducto"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteProducto('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('productos.index');
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
            'codigo.required' => 'El campo código es obligatorio',
            'nombre.required' => 'El campo nombres es obligatorio',
            'descripcion.required' => 'El campo descripción es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'precio_venta.required' => 'El campo precio de venta es obligatorio',
            'status.required' => 'El campo status es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'color' => 'required',
            'precio_venta' => 'required',
            'status' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Productos::where('codigo',$request->codigo)->count();

        if($buscar > 0){
            return response()->json(['message'=>"El còdigo del producto ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $producto= new Productos();
                $producto->codigo=$request->codigo;
                $producto->nombre=$request->nombre;
                $producto->descripcion=$request->descripcion;
                $producto->modelo=$request->modelo;
                $producto->marca=$request->marca;
                $producto->color=$request->color;
                $producto->precio_venta=$request->precio_venta;
                $producto->status=$request->status;

                $producto->save();

                 return response()->json(['message'=>"Producto ".$request->codigo." ".$request->nombre." registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productos=Productos::where('id',$id)->first();
        return response()->json($productos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_producto)
    {
        $message =[
            'codigo.required' => 'El campo código es obligatorio',
            'nombre.required' => 'El campo nombres es obligatorio',
            'descripcion.required' => 'El campo descripción es obligatorio',
            'modelo.required' => 'El campo modelo es obligatorio',
            'marca.required' => 'El campo marca es obligatorio',
            'color.required' => 'El campo color es obligatorio',
            'precio_venta.required' => 'El campo precio de venta es obligatorio',
            'status.required' => 'El campo status es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'codigo' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'color' => 'required',
            'precio_venta' => 'required',
            'status' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Productos::where('codigo',$request->codigo)->count();

        if($buscar > 0){
            return response()->json(['message'=>"El código del producto ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $producto= Productos::find($request->id_producto);
                $producto->codigo=$request->codigo;
                $producto->nombre=$request->nombre;
                $producto->descripcion=$request->descripcion;
                $producto->modelo=$request->modelo;
                $producto->marca=$request->marca;
                $producto->color=$request->color;
                $producto->precio_venta=$request->precio_venta;
                $producto->status=$request->status;

                $producto->save();

                 return response()->json(['message'=>"Producto ".$request->codigo." ".$request->nombre." actualizado con éxito",'icono'=>'success','titulo'=>'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*$buscar=Pedidos::where('id_producto',$id)->count();
        if($buscar > 0){
            
            return response()->json(['message'=>"El Cliente que intenta eliminar se encuentra relacionado con algún pedido",'icono'=>'warning','titulo'=>'Alerta']);
        }else{*/
            //esperando relacion con inventario
            $producto=Productos::find($id);
            if($producto->delete()){
              return response()->json(['message'=>"El producto fue eliminado con éxito",'icono'=>'success','titulo'=>'Éxito']); 
            }else{
                return response()->json(['message'=>"El producto no pudo ser eliminado",'icono'=>'warning','titulo'=>'Alerta']);
            }
        //}
        return redirect()->back();
    }
}
