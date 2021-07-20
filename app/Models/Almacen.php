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

    protected $fillable=['id_agencia','id_producto','existencia','stock_min','stock_max'];

    public function agencias(){

    	return $this->belongsTo(Agencias::class,'id_agencia');
    }

    public function productos(){

    	return $this->belongsTo(Productos::class,'id_producto');
    }

}
