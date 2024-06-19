<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
 * EXAMPLE ROUTES
 * TODO: Parameters for these Endpoints
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