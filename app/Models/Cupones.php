<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clientes;
class Cupones extends Model
{
    use HasFactory;

    protected $table='cupones';

    protected $fillable=['nombre','condiciones','porcentaje','monto','validez_anios','validez_meses','validez_dias','validez_horas'];

    public function clientes(){

    	return $this->belongsToMany(Clientes::class,'clientes_has_cupones','id_cupon','id_cliente')->withPivot('fecha_activado','fecha_vence','status');
    }
}
