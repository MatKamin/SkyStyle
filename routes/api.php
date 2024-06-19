<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PasswordGeneratorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/example', function () {
    return "This is a basic string response from your API.";
});

// Route for Weather
Route::get('/weather', [WeatherController::class, 'getWeather']);

// Route for Password Generator
Route::get('/passwd', [PasswordGeneratorController::class, 'getPassword']);