<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clientes;
use App\Models\Tarifas;
use App\Models\Fuentes;
use App\Models\Recepcionistas;
use App\Models\Estados;
use App\Models\Agencias;
use App\Models\Productos;
class Pedidos extends Model
{
    use HasFactory;

    protected $table='pedidos';

    protected $fillable=['fecha','id_cliente','id_tarifa','link','envio_gratis','monto_envio','id_fuente','id_recepcionista','id_estado','observacion','id_agencia','status_deposito'];

    public function clientes(){

    	return $this->belongsTo(Clientes::class,'id_cliente');
    }
    public function tarifas(){

    	return $this->belongsTo(Tarifas::class,'id_tarifa');
    }
    public function fuentes(){

    	return $this->belongsTo(Fuentes::class,'id_fuente');
    }
    public function recepcionistas(){

    	return $this->belongsTo(Recepcionistas::class,'id_recepcionista');
    }
    public function estados(){

    	return $this->belongsTo(Estado::class,'id_estado');
    }
    public function agencias(){

    	return $this->belongsTo(Agencias::class,'id_agencia');
    }

    public function productos(){

    	return $this->belongsToMany(Productos::class,'pedidos_has_productos','id_pedido','id_producto')->withPivot('cantidad');
    }
}

