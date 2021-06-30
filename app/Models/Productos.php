<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Imagenes;
use App\Models\Pedidos;
class Productos extends Model
{
    use HasFactory;

    protected $table='productos';

    protected $fillable=['codigo','nombre','descripcion','modelo','marca','color','precio_venta','status'];

    public function imagenes(){

    	return $this->hasMany(Imagenes::class);
    }

    public function pedidos(){

    	return $this->belongsToMany(Pedidos::class,'pedidos_has_productos','id_producto','id_pedido')->withPivot('cantidad');
    }
}
