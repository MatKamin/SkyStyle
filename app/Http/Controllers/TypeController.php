<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function getTypes()
    {
        try {
            $types = Type::all();
            return response()->json(['types' => $types], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to fetch types', 'error' => $e->getMessage()], 500);
        }
    }
}
