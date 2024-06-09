<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aeropuerto; 
use App\Models\Aerolinea;
use App\Models\Vuelo;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getData()
    {
        $aeropuertoConMasMovimientos = Aeropuerto::withCount('vuelos')
            ->orderBy('vuelos_count', 'desc')
            ->first();
        
        $aerolineaConMasVuelos = Aerolinea::withCount('vuelos')
            ->orderBy('vuelos_count', 'desc')
            ->first();
        
        $diaConMasVuelos = Vuelo::select(DB::raw('DATE(dia) as dia'), DB::raw('COUNT(*) as total_vuelos'))
            ->groupBy(DB::raw('DATE(dia)'))
            ->orderBy('total_vuelos', 'desc')
            ->first();
        
        $aerolineasMasDosVuelosPorDia = Aerolinea::whereHas('vuelos', function ($query) {
            $query->select(DB::raw('DATE(dia) as dia'), DB::raw('COUNT(*) as total_vuelos'))
                  ->groupBy(DB::raw('DATE(dia)'))
                  ->havingRaw('COUNT(*) > 2');
        })->get();

        $data = [
            'aeropuerto_con_mas_movimientos' => $aeropuertoConMasMovimientos ? $aeropuertoConMasMovimientos->nombre : null,
            'aerolinea_con_mas_vuelos' => $aerolineaConMasVuelos ? $aerolineaConMasVuelos->nombre : null,
            'dia_con_mas_vuelos' => $diaConMasVuelos ? $diaConMasVuelos->dia : null,
            'aerolineas_mas_dos_vuelos_por_dia' => $aerolineasMasDosVuelosPorDia->pluck('nombre'),
        ];

        return response()->json($data);
    }
}
