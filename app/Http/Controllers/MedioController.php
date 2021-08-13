<?php

namespace App\Http\Controllers;

use App\Models\Medio;
use App\Models\Cuotas;
use App\Models\Iva;
use Illuminate\Http\Request;
use Alert;
use Datatables;
class MedioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iva_activo=Iva::where('status','Activo')->count();
        if(request()->ajax()) {
            $medios=\DB::table('medios')->join('ivas','ivas.id','=','medios.id_iva')->select('medios.*','ivas.iva')->get();
            return datatables()->of($medios)
                ->addColumn('action', function ($row) {
                    $edit = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-warning btn-xs" id="editMedio"><i class="fa fa-pencil-alt"></i></a>';
                    $delete = ' <a href="javascript:void(0);" id="delete-medio" onClick="deleteMedio('.$row->id.')" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                    return $edit . $delete;
                })->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('medios.index',compact('iva_activo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
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
            'medio.required' => 'El campo medio es obligatorio',
            'porcentaje.required' => 'El campo porcentaje es obligatorio',
            'porcentaje.numeric' => 'El campo porcentaje solo debe contener números',
        ];
        $validator = \Validator::make($request->all(), [
            'medio' => 'required',
            'porcentaje' => 'required|numeric',
        ],$message);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $iva=Iva::where('status','Activo')->first();
        $buscar=Medio::where('medio',$request->medio)->where('id_iva',$iva->id)->count();
        if ($buscar > 0) {
            return response()->json(['message'=>"El Medio ya se encuentra registrado para el iva activo",'icono'=>'warning','titulo'=>'Alerta']);
        } else {
            if (count($request->interes) == 0 || count($request->interes) < 5) {
                return response()->json(['message'=>"Faltaron montos de intereses en cuotas, debe registrarlos todos",'icono'=>'warning','titulo'=>'Alerta']);
            } else {
                $medio= new Medio();
                $medio->medio=$request->medio;
                $medio->porcentaje=$request->porcentaje;
                $medio->id_iva=$iva->id;
                $medio->save();

                //registrando cuotas
                $j=0;
                for ($i=1; $i <=12; $i=$i+3) { 
                    if ($i==4) {
                        $i++;
                    }
                    $cuotas= new Cuotas();
                    $cuotas->id_medio=$medio->id;
                    $cuotas->cant_cuota=$i;
                    $cuotas->interes=$request->interes[$j];
                    $cuotas->save();
                    $j++;
                }
                 return response()->json(['message'=>"Medio de Mercado Pago registrado con éxito",'icono'=>'success','titulo'=>'Éxito']);   
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function show(Medio $medio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function edit($id_medio)
    {
        $medio=Medio::where('id',$id_medio)->get();

        return response()->json($medio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medio $medio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Medio  $medio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medio $medio)
    {
        //
    }

    public function buscar_cuotas($id_medio)
    {
        $cuotas=Cuotas::where('id_medio',$id_medio)->get();
        return response()->json($cuotas);
    }
}
