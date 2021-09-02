<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosReclamos extends Model
{
    use HasFactory;

    protected $table='productos_reclamos';

    protected $fillable=['id_producto','codigo_pedido','id_estado','observacion'];

   public function productos()
   {
   		return $this->belongsTo('App\Models\Productos','id_producto');
   }

   public function estados()
   {
   		return $this->belongsTo('App\Models\Estados','id_estado');
   }
}
