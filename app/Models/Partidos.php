<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Zonas;
class Partidos extends Model
{
    use HasFactory;

    protected $table='partidos';

    protected $fillable=['partido'];

    public function zonas(){

    	return $this->hasMany(Zonas::class);
    }
}
