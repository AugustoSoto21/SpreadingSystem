<?php 
function search_permits($module,$permit)
{
	/*$search="No";
	$permit=App\Models\Permits::where('permit',$permit)->where('module',$module)->first();
    if(!is_null($permit)){
    	foreach ($permit->user as $key) {    		
    		if ($key->pivot->id_user==\Auth::User()->id) {
    			$search=$key->pivot->status;
    		}
    	}
    }
	return $search;*/
    return "Si";
}

function productos_almacen($id_agencia,$id_producto){

    $valores=array();
    $valores[0]=0;
    $valores[1]=0;
    $buscar=\App\Models\Almacen::where('id_producto',$id_producto)->where('id_agencia',$id_agencia)->get();
    if(count($buscar) > 0){
        foreach ($buscar as $key) {
            $valores[0]=$key->stock;
            $valores[1]=$key->stock_min;
        }
    }
    
    return $valores;
}

function producto_stock($id_producto)
{
    $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->count();
    $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->count();
    $total=0;
    if($buscar_i > 0){
        $buscar_i=\App\Models\Inventario::where('id_producto',$id_producto)->first();
        $total+=$buscar_i->stock;
    }
    if($buscar_a > 0){
        $buscar_a=\App\Models\Almacen::where('id_producto',$id_producto)->get();
        foreach ($buscar_a as $key) {
            $total+=$key->stock;
        }
        
    }

    return $id_producto;
}