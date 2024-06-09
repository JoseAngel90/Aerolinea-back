<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aerolinea extends Model
{
    protected $table = 'aerolineas';
    protected $primaryKey = 'id_aerolinea';

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'id_aerolinea', 'id_aerolinea');
    }
}