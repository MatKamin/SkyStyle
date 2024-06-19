<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordGeneratorController extends Controller
{
    public function getPassword()
    {
        $response = Http::get('https://api.genratr.com/?length=10&uppercase&lowercase&special&numbers');

        return $response->json();
    }
}
