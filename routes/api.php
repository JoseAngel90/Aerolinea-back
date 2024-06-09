<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ServiciosExternosController;
use App\Http\Controllers\FlightController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data', [ApiController::class, 'getData']);

Route::get('/stack-exchange/search', [ServiciosExternosController::class, 'search']);

Route::get('/airport/max-movement', [FlightController::class, 'getAirportWithMaxMovement']);
Route::get('/airline/max-flights', [FlightController::class, 'getAirlineWithMaxFlights']);
Route::get('/day/max-flights', [FlightController::class, 'getDayWithMaxFlights']);
Route::get('/airlines/more-than-two-flights', [FlightController::class, 'getAirlinesWithMoreThanTwoFlights']);
