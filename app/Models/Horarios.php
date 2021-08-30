<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    use HasFactory;

    protected $table='horarios';

    protected $fillable=['horario','hora_inicio','hora_fin','direccion','codigo_pedido'];

    
}
