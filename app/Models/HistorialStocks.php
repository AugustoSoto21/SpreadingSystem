<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialStocks extends Model
{
    use HasFactory;

    protected $table='historial_stocks';

    protected $fillable=['fecha','id_agencia','locker','id_producto','cantidad'];

    public function agencia(){

    	return $this->belongsTo('App\Models\Agencias','id_agencia');
    }

    public function producto(){

    	return $this->belongsTo('App\Models\Producto','id_producto');
    }
}
