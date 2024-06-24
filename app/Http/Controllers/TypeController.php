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
            return \App\Http\Helpers\ResponseFormatter::format(request(), ['types' => $types], 200);
        } catch (\Exception $e) {
            return \App\Http\Helpers\ResponseFormatter::format(request(), ['message' => 'Failed to fetch types', 'error' => $e->getMessage()], 500);
        }
    }
}
