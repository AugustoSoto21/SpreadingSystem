<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Recepcionistas extends Model
{
    use HasFactory;

    protected $table='recepcionistas';

    protected $fillable=['nombres','apellidos','id_user'];

    
    public function usuario()
    {
    	return $this->belongsTo('App\Models\User','id_user');
    }
}
