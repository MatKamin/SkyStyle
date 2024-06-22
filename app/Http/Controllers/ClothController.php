<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cloth;
use App\Models\Wardrobe;
use Illuminate\Support\Facades\Storage;

class ClothController extends Controller
{
    public function addCloth(Request $request)
    {
        $request->validate([
            'Picture' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
            'Description' => 'required|string',
            'LinkToBuy' => 'nullable|string',
            'Title' => 'required|string|max:255',
            'TypeID' => 'required|exists:types,TypeID',
            'WardrobeID' => 'required|exists:wardrobes,WardrobeID',
        ]);

        try {
            if ($request->hasFile('Picture')) {
                $filePath = $request->file('Picture')->store('public/clothes');
                $fileUrl = Storage::url($filePath); // Generates URL like /storage/clothes/filename.jpg
            }

            $cloth = new Cloth();
            $cloth->Picture = $fileUrl; // Store the public URL
            $cloth->Description = $request->Description;
            $cloth->LinkToBuy = $request->LinkToBuy;
            $cloth->Title = $request->Title;
            $cloth->TypeID = $request->TypeID;
            $cloth->WardrobeID = $request->WardrobeID;
            $cloth->save();

            $cloth->load('type');

            return response()->json(['message' => 'Cloth added successfully', 'cloth' => $cloth], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error adding cloth: ' . $e->getMessage()], 500);
        }
    }

    public function editCloth(Request $request, $clothId)
    {
        $cloth = Cloth::find($clothId);

        if (!$cloth) {
            return response()->json(['message' => 'Cloth not found'], 404);
        }

        // Log all request data
        error_log('Request Data: ' . print_r($request->all(), true));
        error_log('Request Files: ' . print_r($request->allFiles(), true)); // Log all uploaded files

        $request->validate([
            'Picture' => 'sometimes|file|mimes:jpg,png,jpeg,gif|max:2048',
            'Description' => 'sometimes|string',
            'LinkToBuy' => 'nullable|string',
            'Title' => 'sometimes|string|max:255',
            'TypeID' => 'sometimes|exists:types,TypeID',
        ]);

        try {
            if ($request->hasFile('Picture')) {
                // Log file information
                error_log('File present in request: ' . print_r($request->file('Picture'), true));
                
                // Delete the old picture if it exists
                if ($cloth->Picture) {
                    // Log old picture URL
                    error_log('Existing Picture URL: ' . $cloth->Picture);

                    // Get the old file path
                    $oldFilePath = str_replace('/storage', 'public', $cloth->Picture);
                    // Log old file path before deletion
                    error_log('Old file path: ' . $oldFilePath);

                    // Check if the old file exists in storage and delete it
                    if (Storage::exists($oldFilePath)) {
                        Storage::delete($oldFilePath);
                        error_log('Old file deleted: ' . $oldFilePath);
                    } else {
                        error_log('Old file not found: ' . $oldFilePath);
                    }
                }

                // Store new picture
                $filePath = $request->file('Picture')->store('public/clothes');
                $fileUrl = Storage::url($filePath);
                $cloth->Picture = $fileUrl;

                // Log updated Picture URL
                error_log('New Picture URL: ' . $cloth->Picture);
            }

            // Using null coalescing operator to assign values if present
            $cloth->Description = $request->input('Description', $cloth->Description);
            $cloth->LinkToBuy = $request->input('LinkToBuy', $cloth->LinkToBuy);
            $cloth->Title = $request->input('Title', $cloth->Title);
            $cloth->TypeID = $request->input('TypeID', $cloth->TypeID);

            // Log updates for other fields
            error_log('Description updated: ' . $cloth->Description);
            error_log('LinkToBuy updated: ' . $cloth->LinkToBuy);
            error_log('Title updated: ' . $cloth->Title);
            error_log('TypeID updated: ' . $cloth->TypeID);

            // Save the updated cloth
            $cloth->save();

            // Load the related type
            $cloth->load('type');

            // Log the updated cloth
            error_log('Cloth updated successfully: ' . print_r($cloth->toArray(), true));

            return response()->json(['message' => 'Cloth updated successfully', 'cloth' => $cloth], 200);
        } catch (\Exception $e) {
            // Log any errors during the update process
            error_log('Error updating cloth: ' . $e->getMessage());
            error_log('Error Trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error updating cloth: ' . $e->getMessage()], 500);
        }
    }
    
    


    public function getCloth($clothId)
    {
        $cloth = Cloth::with('type', 'wardrobe')->find($clothId);

        if (!$cloth) {
            return response()->json(['message' => 'Cloth not found'], 404);
        }

        return response()->json(['cloth' => $cloth], 200);
    }

    public function removeCloth($clothId)
    {
        $cloth = Cloth::find($clothId);

        if (!$cloth) {
            return response()->json(['message' => 'Cloth not found'], 404);
        }

        try {
            // Delete the picture if it exists
            if ($cloth->Picture) {
                $filePath = str_replace('/storage', 'public', $cloth->Picture);
                Storage::delete($filePath);
            }

            $cloth->delete();

            return response()->json(['message' => 'Cloth removed successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error removing cloth: ' . $e->getMessage()], 500);
        }
    }

    public function getClothesByWardrobe($wardrobeId)
    {
        $wardrobe = Wardrobe::find($wardrobeId);

        if (!$wardrobe) {
            return response()->json(['message' => 'Wardrobe not found'], 404);
        }

        $clothes = $wardrobe->clothes()->with('type')->get();

        return response()->json(['clothes' => $clothes], 200);
    }
}
