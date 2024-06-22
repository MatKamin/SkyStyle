<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;

/**
 * USER MANAGEMENT
 */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::get('users', [UserController::class, 'index'])->middleware('admin:5');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('admin:5');
    Route::put('users/{id}', [UserController::class, 'update'])->middleware('admin:5');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('admin:5');
    Route::get('user', [UserController::class, 'profile']);
});

/**
 * LOCATION ROUTES
 */
Route::get('/get-coords-for-city', [LocationController::class, 'getCoordsForCity']);
Route::get('/get-city-from-coords', [LocationController::class, 'getCityFromCoords']);


/**
 * WEATHER
 */
Route::get('/weather', [WeatherController::class, 'getWeatherByCoordinates']);


/**
 * EXAMPLE ROUTES
 */
Route::get('/weather', [WeatherController::class, 'getWeather']);
Route::get('/passwd', [PasswordGeneratorController::class, 'getPassword']);

/**
 * FALLBACK ROUTE FOR NOT FOUND ROUTES
 */
Route::fallback(function () {
    $response = ['error' => 'Not found'];
    
    if (app()->environment('local')) {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
            ];
        });
        $response['availableRoutes'] = $routes;
    }

    return response()->json($response, 404);
});
