<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Partidos;
use App\Models\Tarifas;
class Zonas extends Model
{
    use HasFactory;

    protected $table='zonas';

    protected $fillable=['zona','id_partido'];

    public function partidos(){

    	return $this->belongsTo(Partidos::class,'id_partido');
    }

    public function tarifas(){

    	return $this->hasMany(Tarifas::class);
    }
}
