<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zonas;
use App\Models\Pedidos;
use App\Models\Agencias;
class Tarifas extends Model
{
    use HasFactory;

    protected $table='tarifas';

    protected $fillable=['id_agencia','monto','id_zona'];

    public function zonas(){

    	return $this->belongsTo(Zonas::class,'id_zona');
    }
    
    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }

    public function agencias(){

    	return $this->belongsTo(Agencias::class,'id_agencia');	
    }
}
