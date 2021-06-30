<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Recepcionistas extends Model
{
    use HasFactory;

    protected $table='recepcionistas';

    protected $fillable=['nombres','apellidos'];

    public function pedidos(){

    	return $this->hasMany(Pedidos::class);
    }
}
