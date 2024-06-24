<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        try {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 52.52,
                'longitude' => 13.41,
                'current' => 'temperature_2m,wind_speed_10m',
                'hourly' => 'temperature_2m,relative_humidity_2m,wind_speed_10m',
            ]);

            $data = $response->json();
            return \App\Http\Helpers\ResponseFormatter::format($request, $data);
        } catch (\Exception $e) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['error' => 'Failed to fetch weather data'], 500);
        }
    }

    public function getWeatherByCoordinates(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $client = new Client();
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone=auto";

        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody(), true);
            return \App\Http\Helpers\ResponseFormatter::format($request, $data);
        } catch (\Exception $e) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['error' => 'Failed to fetch weather data'], 500);
        }
    }

    /**
     * XML PART
     */

    public function getWeatherXML(Request $request)
    {
        try {
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => 52.52,
                'longitude' => 13.41,
                'current' => 'temperature_2m,wind_speed_10m',
                'hourly' => 'temperature_2m,relative_humidity_2m,wind_speed_10m',
            ]);

            $data = $response->json();
            $xml = new \SimpleXMLElement('<root/>');
            array_walk_recursive($data, function ($value, $key) use ($xml) {
                $xml->addChild($key, $value);
            });

            return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
        } catch (\Exception $e) {
            return response()->xml(['error' => 'Failed to fetch weather data'], 500);
        }
    }

    public function getWeatherByCoordinatesXML(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $client = new Client();
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=temperature_2m_max,temperature_2m_min,precipitation_sum&timezone=auto";

        try {
            $response = $client->request('GET', $url);
            $data = json_decode($response->getBody(), true);

            $xml = new \SimpleXMLElement('<root/>');
            array_walk_recursive($data, function ($value, $key) use ($xml) {
                $xml->addChild($key, $value);
            });

            return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
        } catch (\Exception $e) {
            return response()->xml(['error' => 'Failed to fetch weather data'], 500);
        }
    }
}
