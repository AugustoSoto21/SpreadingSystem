<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clientes;
use App\Models\Tarifas;
use App\Models\Fuentes;
use App\Models\Recepcionistas;
use App\Models\Estados;
use App\Models\Deliverys;
use App\Models\Productos;
use App\Models\User;
class Pedidos extends Model
{
    use HasFactory;
    protected $table='pedidos';

    protected $fillable=['codigo','id_cliente','id_user','id_producto','cantidad','monto_und','total_pp','monto_descuento','porcentaje_descuento','descuento_total','iva_total','monto_ct','recargo_ct','total_ct','id_cuota','cuotas_ct','interes_ct','total_fact','id_zona','envio_gratis','id_tarifa','monto_tarifa','link','id_fuente','id_estado','observacion'];

    public function clientes(){

    	return $this->belongsTo(Clientes::class,'id_cliente');
    }
    public function tarifas(){

    	return $this->belongsTo(Tarifas::class,'id_tarifa');
    }
    public function fuentes(){

    	return $this->belongsTo(Fuentes::class,'id_fuente');
    }
    public function usuario(){

    	return $this->belongsTo(User::class,'id_user');
    }
    public function estados(){

    	return $this->belongsTo(Estados::class,'id_estado');
    }
    public function productos(){

        return $this->belongsTo(Productos::class,'id_producto');
    }
}

