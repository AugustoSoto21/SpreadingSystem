<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Alert;
use Datatables;
use App\Models\Imagenes;
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
            return response()->json(['message'=>"El código del producto ya ha sido registrado.",'icono'=>'warning','titulo'=>'Alerta']);
        }else{
            
            //dd(count($request->imagenes));
            $validacion=$this->validar_imagen($request->file('imagenes'));
                if($validacion['valida'] > 0){
                    return response()->json(['message'=>"Error a enviar imágenes",'icono'=>'warning','titulo'=>'Alerta']);
                }

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
                //cargando imagenes
                $imagenes=$request->file('imagenes');
                foreach($imagenes as $imagen){
                    $codigo=$this->generarCodigo();
                    /*
                    $validatedData = $request->validate([
                        'imagenes' => 'mimes:jpeg,png'
                    ]);*/
                    $name=$codigo."_".$imagen->getClientOriginalName();
                    $imagen->move(public_path().'/img_productos', $name);  
                    $url ='img_productos/'.$name;
                    $img=new Imagenes();
                    $img->id_producto=$producto->id;
                    $img->nombre=$name;
                    $img->url=$url;
                    $img->save();

                    $producto->imagenes()->attach($img);
                }
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
            if($request->imagenes!=null){
                    $validacion=$this->validar_imagen($request->file('imagenes'));
                    if($validacion['valida'] > 0){
                        toastr()->warning('intente otra vez!!', $validacion['mensaje'].'');
                        return redirect()->back();
                    }  
                }
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
                if($request->imagenes!=null){
                    //cargando imagenes
                $imagenes=$request->file('imagenes');
                    foreach($imagenes as $imagen){
                        $codigo=$this->generarCodigo();
                        /*
                        $validatedData = $request->validate([
                            'imagenes' => 'mimes:jpeg,png'
                        ]);*/
                        $name=$codigo."_".$imagen->getClientOriginalName();
                        $imagen->move(public_path().'/img_productos', $name);  
                        $url ='img_productos/'.$name;
                        $img=new Imagenes();
                        $img->id_producto=$producto->id;
                        $img->nombre=$name;
                        $img->url=$url;
                        $img->save();

                        $producto->imagenes()->attach($img);
                    }

                }
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
    protected function validar_imagen($imagenes)
    {
        //dd($imagenes);
        $mensaje="";
        $valida=0;
        foreach($imagenes as $imagen){
            //dd('asasas');
            $img=getimagesize($imagen);
            $size=$imagen->getClientSize();
            $width=$img[0];
            $higth=$img[1];
        }

        //dd($size."-".$width."-".$higth);

        if ($size>819200) {
            $mensaje="Alguna imagen excede el límite de tamaño de 800 KB ";
            $valida++;
        }

        if ($width>1024) {
            $mensaje.=" | Alguna imagen excede el límite de ancho de 1024 KB ";
            $valida++;
        }

        if ($higth>800) {
            $mensaje.=" | ALguna imagen excede el límite de altura de 800 KB ";
            $valida++;
        }

        $respuesta=['mensaje' => $mensaje,'valida' => $valida];

        return $respuesta;
    }

    protected function generarCodigo() {
     $key = '';
     $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $max = strlen($pattern)-1;
     for($i=0;$i < 4;$i++){
        $key .= $pattern=mt_rand(0,$max);
    }
     return $key;
    }

    public function eliminar_imagen(Request $request){

        $imagen=Imagenes::find($request->id_imagen);
        $url=$imagen->url;
        if($imagen->delete()){
            unlink($url);
            toastr()->success('Éxito!!', 'Imagen Eliminada');
                return redirect()->back();
        }else{
            toastr()->error('Error!!', 'La Imagen no pudo ser Eliminada');
                return redirect()->back();
        }
    }

    public function imagenes(){
        //dd('asasas');
        $productos=Productos::where('existencia','>',0)->get();
        $i=1;
        return view('productos.imagenes',compact('productos','i'));
    }

    public function welcome(){
        $productos=Productos::where('disponible','>',0)->get();
        $imagenes=array();
        $i=0;
        $j=0;
        foreach($productos as $key){
            foreach($key->imagenes as $key2){
                if($key2->pivot->mostrar=="Si" and $i<3){
                    $imagenes[$i]=$key2->url;
                    $i++;
                }
            }
        }
        return view('welcome',compact('productos','imagenes','j'));
    }

    public function mostrar(Request $request){
        //dd($request->all());
        $productos=\DB::table('productos')
        ->join('inventario','inventario.id_producto','=','productos.id')
        ->where('inventario.existencia','>',0)
        ->select('productos.*')->get();
        $contar=0;
        foreach($productos as $key){
            foreach($key->imagenes as $key2){
                if($key2->pivot->mostrar=="Si"){
                    $contar++;
                }
            }
        }
        if($contar==9 && $request->status=="No"){
            toastr()->error('Error!!', 'Ya se alcanzó el límite para mostrar imágenes');
            return redirect()->back();
        }else{
            foreach($productos as $key){
                foreach($key->imagenes as $key2){
                    if($key2->id==$request->id_imagen){
                        if($key2->pivot->mostrar=="No"){
                            $key2->pivot->mostrar="Si";
                        }else{
                            $key2->pivot->mostrar="No";    
                        }
                        $key2->pivot->save();
                    }
                }
            }

            toastr()->success('Éxito!!', 'La Imagen será mostrada en el portal');
            return redirect()->back();
        }
    }
}
