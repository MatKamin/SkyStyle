<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasswordGeneratorController extends Controller
{
    public function getPassword()
    {
        $password = $this->generatePassword();

        return response()->json(['password' => $password]);
    }

    private function generatePassword()
    {
        $response = Http::get('https://api.genratr.com/?length=10&uppercase=true&lowercase=true&special=true&numbers=true');
        $data = $response->json();
        return $data['password'] ?? ''; // Assuming the API response has a 'password' field
    }

    private function validatePassword($password)
    {
        // Regular expression to validate the password
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($regex, $password);
    }
}
