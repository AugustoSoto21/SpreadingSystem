<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;
class Imagenes extends Model
{
    use HasFactory;

    protected $table='imagenes';

    protected $fillable=['id_producto','nombre','url'];

    public function productos(){

    	return $this->belongsTo('App\Models\Productos','id_producto');
    }
}
