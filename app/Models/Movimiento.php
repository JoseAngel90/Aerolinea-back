<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';

    public function vuelos()
    {
        return $this->hasMany(Vuelo::class, 'id_movimiento');
    }
}