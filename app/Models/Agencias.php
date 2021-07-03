<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Deliverys;

class Agencias extends Model
{
    use HasFactory;

    protected $table='agencias';

    protected $fillable=['nombre'];

    public function deliverys(){

    	return $this->hasMany(Deliverys::class);
    }
}
