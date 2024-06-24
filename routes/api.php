<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\PasswordGeneratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WardrobeController;
use App\Http\Controllers\ClothController;
use App\Http\Controllers\TypeController;


/**
 * USER MANAGEMENT
 */
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::get('users', [UserController::class, 'index'])->middleware('admin:5');
    Route::get('users/{id}', [UserController::class, 'show'])->middleware('admin:5');
    Route::patch('users/{id}', [UserController::class, 'update'])->middleware('admin:5');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->middleware('admin:5');
    Route::get('user', [UserController::class, 'profile']);
});

/**
 * LOCATION ROUTES
 */
Route::get('/get-coords-for-city', [LocationController::class, 'getCoordsForCity']);
Route::get('/get-city-from-coords', [LocationController::class, 'getCityFromCoords']);

/**
 * WARDROBE
 */
Route::middleware('auth:api')->group(function () {
    Route::post('wardrobe', [WardrobeController::class, 'addWardrobe']);
    Route::put('wardrobe/{wardrobeId}', [WardrobeController::class, 'editWardrobe']);
    Route::delete('wardrobe/{wardrobeId}', [WardrobeController::class, 'removeWardrobe']);
    Route::get('wardrobes', [WardrobeController::class, 'getAllWardrobes']);
});

/**
 * CLOTHES
 */
Route::middleware('auth:api')->group(function () {
    Route::post('clothes', [ClothController::class, 'addCloth']);
    Route::get('clothes/{clothId}', [ClothController::class, 'getCloth']);
    Route::post('clothes/{clothId}', [ClothController::class, 'editCloth']);
    Route::delete('clothes/{clothId}', [ClothController::class, 'removeCloth']);
    Route::get('wardrobe/{wardrobeId}/all-clothes', [ClothController::class, 'getClothesByWardrobe']);
});

/**
 * TYPES
 */
Route::middleware('auth:api')->group(function () {
    Route::get('types', [TypeController::class, 'getTypes']);
});

/**
 * RECOMMENDATIONS
 */
Route::middleware('auth:api')->group(function () {
    Route::post('wardrobe/all/outfit', [ClothController::class, 'getOutfitFromAllWardrobes']);
    Route::post('wardrobe/{wardrobeId}/outfit', [ClothController::class, 'getOutfit']);
});



/**
 * WEATHER
 */
Route::get('/weather', [WeatherController::class, 'getWeather']);
Route::get('/weather-xml', [WeatherController::class, 'getWeatherXML']);
Route::get('/weather-coordinates', [WeatherController::class, 'getWeatherByCoordinates']);
Route::get('/weather-coordinates-xml', [WeatherController::class, 'getWeatherByCoordinatesXML']);




/**
 * EXAMPLE ROUTES
 */
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
