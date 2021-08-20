<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medio extends Model
{
    use HasFactory;

    protected $table='medios';

    protected $fillable=['medio','porcentaje','id_iva','status','comision'];

    public function iva()
    {
    	return $this->belongsTo('App\Models\Iva','id_iva');
    }

    public function cuotas()
    {
    	return $this->hasMany('App\Models\Cuotas','id_medio','id');
    }
}
