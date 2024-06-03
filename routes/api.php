<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/example', function () {
    return "This is a basic string response from your API.";
});

// Route for Weather
Route::get('/weather', [WeatherController::class, 'getWeather']);