<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    public function getCoordsForCity(Request $request)
    {
        $request->validate([
            'city' => 'required|string'
        ]);

        $city = $request->input('city');
        $apiKey = env('GEODB_API_KEY');

        try {
            $response = Http::withHeaders([
                'X-RapidAPI-Key' => $apiKey,
                'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com'
            ])->get('https://wft-geo-db.p.rapidapi.com/v1/geo/cities', [
                'namePrefix' => $city,
                'limit' => 1,
                'types' => 'CITY'
            ]);

            // Log the response for debugging
            Log::info('getCoordsForCity response:', ['response' => $response->json()]);

            if ($response->successful() && count($response->json()['data']) > 0) {
                $data = $response->json()['data'][0];
                return response()->json(['lat' => $data['latitude'], 'lon' => $data['longitude']]);
            }

            return response()->json(['error' => 'City not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch coordinates', 'message' => $e->getMessage()], 500);
        }
    }

    public function getCityFromCoords(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $apiKey = env('GEODB_API_KEY');

        try {
            $location = sprintf('%+f%+f', $lat, $lon);
            $response = Http::withHeaders([
                'X-RapidAPI-Key' => $apiKey,
                'X-RapidAPI-Host' => 'wft-geo-db.p.rapidapi.com'
            ])->get("https://wft-geo-db.p.rapidapi.com/v1/geo/locations/$location/nearbyCities", [
                'radius' => 10,
                'limit' => 1
            ]);

            // Log the response for debugging
            Log::info('getCityFromCoords response:', ['response' => $response->json()]);

            if ($response->successful() && count($response->json()['data']) > 0) {
                $data = $response->json()['data'][0];
                return response()->json(['city' => $data['city']]);
            }

            return response()->json(['error' => 'City not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch city', 'message' => $e->getMessage()], 500);
        }
    }
}
