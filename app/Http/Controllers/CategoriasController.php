<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Productos;
use Illuminate\Http\Request;
use Alert;
use Datatables;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(request()->ajax()) {
            $categorias=Categorias::all();
            return datatables()->of($categorias)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editCategoria"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-categoria" onClick="deleteCategoria('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('categorias.index');
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
            'categoria.required' => 'El campo categoría es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'categoria' => 'required',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Categorias::where('categoria',$request->categoria)->count();
        if($buscar > 0){
            return response()->json(['message'=>"La categoría ya ha sido registrada.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
                $categoria= new Categorias();
                $categoria->categoria=$request->categoria;
                $categoria->save();
                $categorias=Categorias::all();
               return response()->json(['message' => "Categoría ".$request->categoria." registrada con éxito",'icono' => 'success', 'titulo' => 'Éxito','categorias' => $categorias]);
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show(Categorias $categorias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categorias=Categorias::where('id',$id)->first();

        return Response()->json($categorias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorias $categorias)
    {
        $message =[
            'categoria.required' => 'El campo categoría es obligatorio',
        ];
        $validator = \Validator::make($request->all(), [
            'categoria' => 'required',
        ],$message);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $buscar=Categorias::where('categoria',$request->categoria)->where('id','<>',$request->id_categoria)->count();
        if($buscar > 0){
            return response()->json(['message' => 'La categoría ya ha sido registrada','icono' => 'warning','titulo' => 'Alerta']);
        }else{
            
                $categoria= Categorias::find($request->id_categoria);
                $categoria->categoria=$request->categoria;
                $categoria->save();

                return response()->json(['message' => 'La categoría actualizada con éxito', 'icono' => 'success', 'titulo' => 'Éxito']);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buscar=Productos::where('id_categoria',$id)->count();
        if($buscar > 0){
            return response()->json(['message' => 'La categoría se encuentra registrada a algún producto','icono' => 'warning', 'titulo' => 'Alerta']);
        }else{
            $categoria=Categorias::find($id);
            if($categoria->delete()){
              return response()->json(['message' => 'La categoría fue eliminada con éxito','icono' => 'success', 'titulo' => 'Éxito']);
            }else{
                return response()->json(['message' => 'La categoría no pudo ser eliminada','icono' => 'warning', 'titulo' => 'Alerta']);
            }
        }
    }
}
