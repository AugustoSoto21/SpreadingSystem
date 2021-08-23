<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agencias;
use App\Models\Productos;

class Almacen extends Model
{
    use HasFactory;

    protected $table='almacens';

    protected $fillable=['id_agencia','id_producto','stock','stock_disponible','stock_min','stock_fallas','stock_reclamos','stock_devueltos'];

    public function agencias(){

    	return $this->belongsTo(Agencias::class,'id_agencia');
    }

    public function productos(){

    	return $this->belongsTo(Productos::class,'id_producto');
    }

}
