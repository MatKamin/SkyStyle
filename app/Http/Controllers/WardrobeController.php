<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wardrobe;
use App\Models\Cloth;
use Illuminate\Support\Facades\Auth;

class WardrobeController extends Controller
{
    public function addWardrobe(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
        ]);

        $wardrobe = new Wardrobe();
        $wardrobe->Title = $request->Title;
        $wardrobe->Description = $request->Description;
        $wardrobe->save();

        Auth::user()->wardrobes()->attach($wardrobe->WardrobeID);

        $wardrobe->loadCount('clothes');
        return response()->json(['message' => 'Wardrobe added successfully', 'wardrobe' => $wardrobe], 201);
    }



    public function editWardrobe(Request $request, $wardrobeId)
    {
        $wardrobe = Wardrobe::find($wardrobeId);

        if (!$wardrobe) {
            return response()->json(['message' => 'Wardrobe not found'], 404);
        }

        $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'nullable|string',
        ]);

        $wardrobe->Title = $request->Title;
        $wardrobe->Description = $request->Description;
        $wardrobe->save();

        $wardrobe->loadCount('clothes');
        return response()->json(['message' => 'Wardrobe updated successfully', 'wardrobe' => $wardrobe], 200);
    }

    public function removeWardrobe($wardrobeId)
    {
        $wardrobe = Wardrobe::find($wardrobeId);

        if (!$wardrobe) {
            return response()->json(['message' => 'Wardrobe not found'], 404);
        }

        // Detach the wardrobe from the authenticated user
        Auth::user()->wardrobes()->detach($wardrobeId);

        // Check if the wardrobe is still associated with other users before deleting
        if ($wardrobe->users()->count() == 0) {
            $wardrobe->delete();
        }

        return response()->json(['message' => 'Wardrobe removed successfully'], 200);
    }

    public function getAllWardrobes()
    {
        // Get wardrobes associated with the authenticated user
        $wardrobes = Auth::user()->wardrobes()->withCount('clothes')->get();
        return response()->json(['wardrobes' => $wardrobes], 200);
    }
}
