<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $response = Http::get('https://api.open-meteo.com/v1/forecast', [
            'latitude' => 52.52,
            'longitude' => 13.41,
            'current' => 'temperature_2m,wind_speed_10m',
            'hourly' => 'temperature_2m,relative_humidity_2m,wind_speed_10m',
        ]);

        return $response->json();
    }
}
