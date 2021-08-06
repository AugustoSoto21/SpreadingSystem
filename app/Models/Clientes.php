<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cupones;
use App\Models\Pedidos;

class Clientes extends Model
{
    use HasFactory;

    protected $table='clientes';

    protected $fillable=['nombres','apellidos','celular','direccion','localidad'];

    public function cupones(){

    	return $this->belongsToMany(Cupones::class,'clientes_has_cupones','id_cliente','id_cupon')->withPivot('fecha_activado','fecha_vence','status');
    }

    public function pedidos(){

    	return $this->hasOne(Pedidos::class);
    }

    public function carrito()
    {
    	return $this->hasMany('App\Models\CarritoPedido','id_cliente','id');
    }
}
