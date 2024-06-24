<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\ResponseFormatter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $messages = [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'name.required' => 'Username is required.',
            'name.unique' => 'This username is already taken.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.'
        ];

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'unique:users', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'name' => 'required|unique:users',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/']
        ], $messages);

        if ($validator->fails()) {
            return ResponseFormatter::format($request, ['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return ResponseFormatter::format($request, ['token' => $token], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return ResponseFormatter::format($request, ['token' => $token], 200);
        } else {
            return ResponseFormatter::format($request, ['error' => 'Wrong E-Mail or Password'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return ResponseFormatter::format($request, ['message' => 'Successfully logged out']);
    }
}
