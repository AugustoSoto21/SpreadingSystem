<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Imagenes;
use App\Models\Pedidos;
use App\Models\Inventario;
use App\Models\Almacen;
class Productos extends Model
{
    use HasFactory;

    protected $table='productos';

    protected $fillable=['codigo','detalles','marca','modelo','color','id_categoria','status'];

    public function imagenes(){

    	return $this->hasMany('App\Models\Imagenes','id_producto','id');
    }

    public function pedidos(){

    	return $this->belongsToMany(Pedidos::class,'pedidos_has_productos','id_producto','id_pedido')->withPivot('cantidad');
    }

    public function almacen(){

    	return $this->hasMany('App\Models\Almacen','id_producto','id');
    }

    public function inventario(){

    	return $this->hasMany('App\Models\Inventario','id_producto','id');
    }

    public function categorias(){

        return $this->belongsTo('App\Models\Categorias','id_categoria','id');
    }

    public function historial(){

        return $this->hasMany('App\Models\HistorialStocks','id_producto','id');
    }

    public function carrito()
    {
        return $this->hasMany('App\Models\CarritoPedido','id_producto','id');
    }

    public function reclamos()
    {
        return $this->hasMany('App\Models\ProductosReclamos','id_producto','id');
    }
}
