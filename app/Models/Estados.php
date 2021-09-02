<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Estados extends Model
{
    use HasFactory;

    protected $table='estados';

    protected $fillable=['estado','color'];

    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }

    public function reclamos()
    {
    	return $this->hasMany('App\Models\ProductosReclamos','id_estado','id');
    }
}
