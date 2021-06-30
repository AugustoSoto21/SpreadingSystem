<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agencias extends Model
{
    use HasFactory;

    protected $table='agencias';

    protected $fillable=['nombre'];
}
