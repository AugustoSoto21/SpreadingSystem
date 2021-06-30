<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Fuentes extends Model
{
    use HasFactory;

    protected $table='fuentes';

    protected $fillable=['fuente'];

    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }
}
