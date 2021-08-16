<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoPedido extends Model
{
    use HasFactory;


    protected $table='carrito_pedido';

    protected $fillable=['id_cliente','id_user','id_producto','cantidad','monto_und','total_pp','monto_descuento','porcentaje_descuento','descuento_total','iva_total','monto_ct','recargo_ct','cuotas_ct','interes_ct','total_ct','stock','disponible','total_fact'];

    public function cliente()
    {
    	return $this->belongsTo('App\Models\Clientes','id_cliente');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User','id_user');
    }

    public function producto()
    {
    	return $this->belongsTo('App\Models\Productos','id_producto');
    }
}
