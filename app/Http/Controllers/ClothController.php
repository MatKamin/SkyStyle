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
            'Picture' => 'sometimes|file|mimes:jpg,png,jpeg,gif|max:2048',
            'Description' => 'required|string',
            'LinkToBuy' => 'nullable|string',
            'Title' => 'required|string|max:255',
            'TypeID' => 'required|exists:types,TypeID',
            'WardrobeID' => 'required|exists:wardrobes,WardrobeID',
        ]);

        try {
            $fileUrl = null;
            if ($request->hasFile('Picture')) {
                $filePath = $request->file('Picture')->store('public/clothes');
                $fileUrl = Storage::url($filePath);
            } else {
                // Use a placeholder image based on the type
                $type = $request->input('TypeID');
                $fileUrl = "/storage/placeholders/{$type}.jpg";
            }

            $cloth = new Cloth();
            $cloth->Picture = $fileUrl;
            $cloth->Description = $request->Description;
            $cloth->LinkToBuy = $request->LinkToBuy;
            $cloth->Title = $request->Title;
            $cloth->TypeID = $request->TypeID;
            $cloth->WardrobeID = $request->WardrobeID;
            $cloth->save();

            $cloth->load('type');

            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth added successfully', 'cloth' => $cloth], 201);
        } catch (\Exception $e) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Error adding cloth: ' . $e->getMessage()], 500);
        }
    }

    public function editCloth(Request $request, $clothId)
    {
        $cloth = Cloth::find($clothId);
    
        if (!$cloth) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth not found'], 404);
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
    
                // Delete the old picture if it exists and is not from the placeholder folder
                if ($cloth->Picture && !str_contains($cloth->Picture, '/placeholders/')) {
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
                } else {
                    error_log('Old file is from the placeholder folder or not present');
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
    
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth updated successfully', 'cloth' => $cloth], 200);
        } catch (\Exception $e) {
            // Log any errors during the update process
            error_log('Error updating cloth: ' . $e->getMessage());
            error_log('Error Trace: ' . $e->getTraceAsString());
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Error updating cloth: ' . $e->getMessage()], 500);
        }
    }

    public function removeCloth(Request $request, $clothId)
    {
        $cloth = Cloth::find($clothId);

        if (!$cloth) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth not found'], 404);
        }

        try {
            if ($cloth->Picture && !str_contains($cloth->Picture, '/placeholders/')) {
                $filePath = str_replace('/storage', 'public', $cloth->Picture);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }

            $cloth->delete();

            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth removed successfully'], 200);
        } catch (\Exception $e) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Error removing cloth: ' . $e->getMessage()], 500);
        }
    }

    public function getCloth(Request $request, $clothId)
    {
        $cloth = Cloth::with('type', 'wardrobe')->find($clothId);

        if (!$cloth) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Cloth not found'], 404);
        }

        return \App\Http\Helpers\ResponseFormatter::format($request, ['cloth' => $cloth], 200);
    }

    public function getClothesByWardrobe(Request $request, $wardrobeId)
    {
        $wardrobe = Wardrobe::find($wardrobeId);

        if (!$wardrobe) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Wardrobe not found'], 404);
        }

        $clothes = $wardrobe->clothes()->with('type')->get();

        return \App\Http\Helpers\ResponseFormatter::format($request, ['clothes' => $clothes], 200);
    }

    public function getOutfitFromAllWardrobes(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'temperature' => 'required|numeric',
            'isRainy' => 'required|boolean',
        ]);

        $temperature = $request->input('temperature');
        $isRainy = $request->input('isRainy');

        // Get the authenticated user
        $user = auth()->user();

        // Fetch all wardrobes that belong to the user
        $wardrobes = $user->wardrobes()->with('clothes.type')->get();

        if ($wardrobes->isEmpty()) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'No wardrobes found'], 404);
        }

        $coreClothes = $this->organizeClothes($wardrobes);

        return $this->generateOutfit($request, $coreClothes, $temperature, $isRainy);
    }

    public function getOutfit(Request $request, $wardrobeId)
    {
        // Validate the incoming request data
        $request->validate([
            'temperature' => 'required|numeric',
            'isRainy' => 'required|boolean',
        ]);

        $temperature = $request->input('temperature');
        $isRainy = $request->input('isRainy');

        // Fetch the wardrobe with clothes and their types
        $wardrobe = Wardrobe::with('clothes.type')->find($wardrobeId);
        if (!$wardrobe) {
            return \App\Http\Helpers\ResponseFormatter::format($request, ['message' => 'Wardrobe not found'], 404);
        }

        $coreClothes = $this->organizeClothes(collect([$wardrobe]));

        return $this->generateOutfit($request, $coreClothes, $temperature, $isRainy);
    }

    private function organizeClothes($wardrobes)
    {
        $coreClothes = [
            'upperBody' => [],
            'lowerBody' => [],
            'shoes' => [],
            'outerwear' => [],
            'fullBody' => []
        ];
        $accessoryClothes = [];
    
        // Separate core clothing items from accessories
        foreach ($wardrobes as $wardrobe) {
            foreach ($wardrobe->clothes as $cloth) {
                if (isset($cloth->type)) {
                    $type = $cloth->type;
                    if (in_array($type->Title, ['top', 'shirt', 'blouse'])) {
                        $coreClothes['upperBody'][] = $cloth;
                    } elseif (in_array($type->Title, ['pants', 'skirt', 'shorts'])) {
                        $coreClothes['lowerBody'][] = $cloth;
                    } elseif ($type->Title == 'shoes') {
                        $coreClothes['shoes'][] = $cloth;
                    } elseif (in_array($type->Title, ['outerwear', 'rainjacket', 'leather jacket', 'down jacket', 'parka', 'fleece jacket', 'windbreaker'])) {
                        $coreClothes['outerwear'][] = $cloth;
                    } elseif (in_array($type->Title, ['dress', 'swimwear', 'jumpsuit', 'romper'])) {
                        $coreClothes['fullBody'][] = $cloth;
                    } else {
                        $accessoryClothes[] = $cloth;
                    }
                }
            }
        }
    
        return ['core' => $coreClothes, 'accessories' => $accessoryClothes];
    }

    private function generateOutfit(Request $request, $clothes, $temperature, $isRainy)
    {
        try {
            $coreOutfit = [
                'upperBody' => null,
                'lowerBody' => null,
                'shoes' => null,
                'outerwear' => null
            ];
            $extraOutfit = [];
            $selectedTypes = [];
            $coreClothes = $clothes['core'];
            $accessoryClothes = $clothes['accessories'];

            // Function to select a random match based on temperature
            function selectRandomMatch($clothes, $temperature, $isRainy, $umbrella = false) {
                if (empty($clothes)) return null;
                $filteredClothes = array_filter($clothes, function ($cloth) use ($temperature, $isRainy, $umbrella) {
                    $type = $cloth->type;
                    return $temperature >= $type->Temperature_min && $temperature <= $type->Temperature_max &&
                        (!$isRainy || $type->isRainOkay || $umbrella);
                });
                if (empty($filteredClothes)) return null;
                return $filteredClothes[array_rand($filteredClothes)];
            }

            // Check for umbrella
            $hasUmbrella = false;
            foreach ($accessoryClothes as $cloth) {
                if ($cloth->type->Title == 'umbrella') {
                    $extraOutfit[] = $cloth;
                    $selectedTypes[] = $cloth->type->Title;
                    $hasUmbrella = true;
                    break;
                }
            }

            // Check if a full body item is appropriate and should replace upper/lower body
            $useFullBody = rand(0, 1); // Randomly decide whether to use a full-body item

            if ($useFullBody && !empty($coreClothes['fullBody'])) {
                $selectedFullBody = selectRandomMatch($coreClothes['fullBody'], $temperature, $isRainy, $hasUmbrella);
                if ($selectedFullBody) {
                    $selectedFullBody->avgTemp = ($selectedFullBody->type->Temperature_min + $selectedFullBody->type->Temperature_max) / 2;
                    $coreOutfit['upperBody'] = $selectedFullBody;
                    $coreOutfit['lowerBody'] = $selectedFullBody;
                    $selectedTypes[] = $selectedFullBody->type->Title;
                }
            }

            // Select core clothes if full body item was not selected
            if (empty($coreOutfit['upperBody']) || empty($coreOutfit['lowerBody']) || empty($coreOutfit['shoes'])) {
                foreach (['upperBody', 'lowerBody', 'shoes', 'outerwear'] as $coreType) {
                    if (empty($coreOutfit[$coreType])) {
                        $selectedCloth = selectRandomMatch($coreClothes[$coreType], $temperature, $isRainy, $hasUmbrella);
                        if ($selectedCloth) {
                            $selectedCloth->avgTemp = ($selectedCloth->type->Temperature_min + $selectedCloth->type->Temperature_max) / 2;
                            $coreOutfit[$coreType] = $selectedCloth;
                            $selectedTypes[] = $selectedCloth->type->Title;
                        }
                    }
                }
            }

            // Ensure upperBody is selected if outerwear is chosen
            if (!empty($coreOutfit['outerwear']) && empty($coreOutfit['upperBody'])) {
                if (!empty($coreClothes['upperBody'])) {
                    $selectedTop = $coreClothes['upperBody'][array_rand($coreClothes['upperBody'])];
                    $selectedTop->avgTemp = ($selectedTop->type->Temperature_min + $selectedTop->type->Temperature_max) / 2;
                    $coreOutfit['upperBody'] = $selectedTop;
                    $selectedTypes[] = $selectedTop->type->Title;
                } else {
                    $coreOutfit['upperBody'] = (object)['message' => 'No suitable upperBody found for the given conditions'];
                }
            }

            // Filter accessory clothes based on weather conditions and layering logic
            foreach ($accessoryClothes as $cloth) {
                if (count($extraOutfit) >= 3) break; // Limit to 3 accessories

                $type = $cloth->type;

                // Skip if this type has already been selected or if it doesn't meet rain requirements
                if (in_array($type->Title, $selectedTypes) || ($isRainy && !$type->isRainOkay && !$hasUmbrella)) {
                    continue;
                }

                // Calculate average temperature for the cloth type
                $avgTemp = ($type->Temperature_min + $type->Temperature_max) / 2;

                // Skip if the cloth is not suitable for the current temperature
                if ($temperature < $type->Temperature_min || $temperature > $type->Temperature_max) {
                    continue;
                }

                // Ensure logical layering
                if ($type->ParentTypeID) {
                    $foundParent = false;
                    foreach ($coreOutfit as $outfitCloth) {
                        if ($outfitCloth && isset($outfitCloth->type) && $outfitCloth->type->TypeID == $type->ParentTypeID) {
                            $foundParent = true;
                            break;
                        }
                    }
                    if (!$foundParent) {
                        continue;
                    }
                }

                // Select the cloth with the average temperature closest to the current temperature
                $cloth->avgTemp = $avgTemp;
                $extraOutfit[] = $cloth;
                $selectedTypes[] = $type->Title;
            }

            return \App\Http\Helpers\ResponseFormatter::format($request, [
                'core' => array_values(array_filter($coreOutfit)),
                'extras' => array_values($extraOutfit)
            ], 200);
            
        } catch (\Exception $e) {
            // Log the exception for debugging
            error_log('Error generating outfit: ' . $e->getMessage());
            error_log('Error Trace: ' . $e->getTraceAsString());

            return \App\Http\Helpers\ResponseFormatter::format($request, [
                'message' => 'Error generating outfit: ' . $e->getMessage()
            ], 500);
        }
    }
}
