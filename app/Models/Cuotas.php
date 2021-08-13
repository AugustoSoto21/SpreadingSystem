<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuotas extends Model
{
    use HasFactory;

    protected $table='cuotas';

    protected $fillable=['id_medio','cant_cuota','interes'];

    public function medios()
    {
    	return $this->belongsTo('App\Models\Medio','id_medio');
    }
}
