<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Agencias extends Model
{
    use HasFactory;

    protected $table='agencias';

    protected $fillable=['nombre'];

    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }
}
