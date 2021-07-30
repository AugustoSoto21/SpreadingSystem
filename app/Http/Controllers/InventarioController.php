<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Categorias;
use App\Models\Almacen;
use App\Models\Agencias;
class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categorias::all();
        if(request()->ajax()) {
            $productos=\DB::table('productos')
            ->join('categorias','categorias.id','=','productos.id_categoria')
            ->join('inventarios','inventarios.id_producto','=','productos.id')
            ->select('productos.*','categorias.categoria','inventarios.stock','inventarios.stock_disponible','inventarios.stock_min','inventarios.stock_probar','inventarios.stock_fallas','inventarios.stock_devueltos')
            ->get();
            return datatables()->of($productos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="productos/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editStocks"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteStocks('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->editColumn('detalles',function($row){
                    $d=$row->detalles;
                    $ma=$row->marca;
                    $mo=$row->modelo;
                    $c=$row->color;
                    return $d.' '.$ma.' '.$mo.' '.$c;
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('stocks.index',compact('categorias'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventario $inventario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventario $inventario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventario $inventario)
    {
        //
    }

    public function historial(){

        $agencias=Agencias::all();
        $productos=Productos::all();
        if(request()->ajax()) {
            $productos=\DB::table('historial')
            ->join('productos','productos.id','=','historial.id_producto')
            ->join('agencias','agencias.id','=','historial.id_agencia')
            ->select('historial.*')
            ->get();
            return datatables()->of($productos)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="productos/'.$row->id.'/edit" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editStocks"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-estado" onClick="deleteStocks('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->editColumn('id_agencia',function($row){
                    $select="<div class='form-group'>
                                <select class='form-control' name='id_agencia' id='id_agencia".$row->id."'>";
                                foreach ($agencias as $k) {
                                    $select.="<option value='".$k->id."'";
                                    if($k->id==$row->id_agencia){ 
                                        $select.=" selected='selected' ";
                                     }
                                    $select.=" >".$k->nombre."</option>";
                                }
                            $select.="</select>
                            </div>";
                    return $select;
                })
                ->editColumn('locker',function($row){
                    $select2="<div class='form-group'>
                                <select class='form-control' name='id_agencia' id='id_agencia".$row->id."'>";
                            $select2.="<option value='SIN PROBAR'";
                            if($row->locker=="SIN PROBAR"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >SIN PROBAR</option>";
                            $select2.="<option value='STOCK'";
                            if($row->locker=="STOCK"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >STOCK</option>";
                            $select2.="<option value='FALLA'";
                            if($row->locker=="FALLA"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >FALLA</option>";
                            $select2.="<option value='CAMBIO'";
                            if($row->locker=="CAMBIO"){ 
                                $select2.=" selected='selected' ";
                             }
                            $select2.=" >CAMBIO</option>";
                    $select2.="</select>
                            </div>";
                    return $select2;
                })->editColumn('id_producto',function($row){
                    $select3="<div class='form-group'>
                                <select class='form-control' name='id_producto' id='id_producto".$row->id."'>";
                        foreach ($productos as $k) {
                            $select3.="<option value='".$k->id."'";
                            if($k->id==$row->id_producto){ 
                                $select3.=" selected='selected' ";
                             }
                            $select3.=" >".$k->detalles." ".$k->marca." ".$k->modelo." ".$k->color."</option>";
                        }
                    $select3.="</select>
                    </div>";
                    return $select3;
                })
                ->editColumn('cantidad',function($row){
                    $campo="<div class='form-group'>
                    <input name='cantidad' id='cantidad".$row->id."' class='form-control' value='".$row->id."'  />
                    </div>";
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('stocks.historial',compact('agencias','productos'));
    }
}
