<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\ArrayToXml\ArrayToXml;

class ResponseFormatter
{
    public static function format(Request $request, $data, $status = 200)
    {
        $acceptHeader = $request->header('Accept', 'application/json'); // Default to JSON if not specified

        if ($acceptHeader === 'application/xml') {
            $xmlContent = ArrayToXml::convert(['response' => $data]);
            return response($xmlContent, $status, ['Content-Type' => 'application/xml']);
        }

        return response()->json($data, $status);
    }
}
