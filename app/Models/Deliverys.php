<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agencias;
use App\Models\Pedidos;
class Deliverys extends Model
{
    use HasFactory;

    protected $table='deliverys';

    protected $fillable=['delivery','id_agencia'];

    public function agencias(){

    	return $this->belongsTo(Agencias::class,'id_agencia');
    }

    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }
}
