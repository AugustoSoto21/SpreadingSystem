<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deliverys;
use App\Models\Tarifas;

class Agencias extends Model
{
    use HasFactory;

    protected $table='agencias';

    protected $fillable=['nombre'];

    public function deliverys(){

    	return $this->hasMany(Deliverys::class);
    }

    public function tarifas(){

    	return $this->hasMany(Tarifas::class);
    }
}
