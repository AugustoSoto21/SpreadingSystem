<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;
class Inventario extends Model
{
    use HasFactory;

    protected $table='inventario';

    protected $fillable=['id_producto','stock','stock_min'];

    public function productos(){

    	return $this->belongsTo(Productos::class,'id_producto');
    }
}
