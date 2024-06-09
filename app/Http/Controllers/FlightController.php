<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vuelo;
use App\Models\Aeropuerto;
use App\Models\Aerolinea;
use Illuminate\Support\Facades\DB;

class FlightController extends Controller
{
    public function getAirportWithMaxMovement()
{
    $airport = Vuelo::select('id_aeropuerto', DB::raw('COUNT(*) as total_movements'))
                     ->groupBy('id_aeropuerto')
                     ->orderBy('total_movements', 'DESC')
                     ->with('aeropuerto')
                     ->first();

    return response()->json([
        'id_aeropuerto' => $airport->id_aeropuerto,
        'nombre_aeropuerto' => $airport->aeropuerto->nombre_aeropuerto,
        'total_movements' => $airport->total_movements
    ]);
}


public function getAirlineWithMaxFlights()
{
    $airline = Vuelo::select('id_aerolinea', DB::raw('COUNT(*) as total_flights'))
                     ->groupBy('id_aerolinea')
                     ->orderBy('total_flights', 'DESC')
                     ->with('aerolinea')
                     ->first();

    return response()->json([
        'id_aerolinea' => $airline->id_aerolinea,
        'nombre_aerolinea' => $airline->aerolinea->nombre_aerolinea,
        'total_flights' => $airline->total_flights
    ]);
}


    public function getDayWithMaxFlights()
    {
        $day = Vuelo::select(DB::raw('DATE(dia) as flight_day'), DB::raw('COUNT(*) as total_flights'))
            ->groupBy(DB::raw('DATE(dia)'))
            ->orderBy('total_flights', 'DESC')
            ->first();

        return response()->json($day ?? []);
    }

    public function getAirlinesWithMoreThanTwoFlights()
{
    $subQuery = DB::table('vuelos')
        ->select('id_aerolinea', DB::raw('DATE(dia) as flight_day'), DB::raw('COUNT(*) as total_flights'))
        ->groupBy('id_aerolinea', 'flight_day')
        ->having('total_flights', '>=', 2);

    $airlines = DB::table('aerolineas')
        ->joinSub($subQuery, 'subquery', function($join) {
            $join->on('aerolineas.id_aerolinea', '=', 'subquery.id_aerolinea');
        })
        ->select('aerolineas.id_aerolinea', 'aerolineas.nombre_aerolinea')
        ->distinct()
        ->get();

    return response()->json($airlines);
}



}
