<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    protected $table = 'vuelos';

    public function aerolinea()
    {
        return $this->belongsTo(Aerolinea::class, 'id_aerolinea', 'id_aerolinea');
    }

    public function aeropuerto()
    {
        return $this->belongsTo(Aeropuerto::class, 'id_aeropuerto');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'id_movimiento');
    }
}