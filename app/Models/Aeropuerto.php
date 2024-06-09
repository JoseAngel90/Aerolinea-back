<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aeropuerto extends Model
{
    protected $table = 'aeropuertos';
    protected $primaryKey = 'id_aeropuerto';

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'id_aeropuerto');
    }
}