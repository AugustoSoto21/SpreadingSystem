<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Productos;
class Inventario extends Model
{
    use HasFactory;

    protected $table='inventarios';

    protected $fillable=['id_producto','stock','stock_disponible','stock_min','stock_probar','stock_fallas','stock_reclamos','stock_devueltos'];

    public function productos(){

    	return $this->belongsTo(Productos::class,'id_producto');
    }
}
