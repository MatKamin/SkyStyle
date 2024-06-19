<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        return response()->json($users, 200);
    }


    public function profile(Request $request)
    {
        return response()->json(Auth::user());
    }


    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'email.email' => 'Email must be a valid email address',
            'password.min' => 'Password must be at least 6 characters',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email',
            'password' => 'sometimes|min:6',
        ], $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->update($request->all());

        return response()->json(['message' => 'User updated successfully'], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
