<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deliverys;
use App\Models\Tarifas;

class Agencias extends Model
{
    use HasFactory;

    protected $table='agencias';

    protected $fillable=['nombre','almacen'];

    public function deliverys(){

    	return $this->hasMany(Deliverys::class);
    }

    public function tarifas(){

    	return $this->hasMany(Tarifas::class);
    }

    public function historial(){

    	return $this->hasMany('App\Models\HistorialStocks','id_agencia','id');
    }
}
