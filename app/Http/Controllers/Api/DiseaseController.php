<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Disease;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiseaseController extends Controller
{
    public function insertDisease(Request $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:diseases',
                'score' => 'nullable|string',
                'description' => 'nullable|string',
                'create_by' => 'required|string',
                'image' => 'nullable|array',
                'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $imagePaths = [];

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                    $path = 'upload/images'; 
                    $file->move(public_path($path), $name); 
                    $imagePaths[] = asset($path . '/' . $name); 
                }
            }

            $disease = Disease::create([
                'name' => $validatedData['name'],
                'score' => $validatedData['score'],
                'description' => $validatedData['description'],
                'image' => json_encode($imagePaths), 
                'create_by' => $validatedData['create_by'],
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Disease created successfully!',
                'data' => $disease,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    // public function getAllDiseases()
    // {
    //     try {
    //         $diseases = Disease::all();
    //         $diseases->transform(function ($disease) {
    //             $disease->image = json_decode($disease->image, true);
    //             return $disease;
    //         });

    //         return response()->json([
    //             'message' => 'Diseases retrieved successfully.',
    //             'data' => $diseases,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => 'An error occurred: ' . $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function getDiseasesSummary()
    {
        try {
            // Retrieve only id, name, and score fields
            $diseases = Disease::select('id', 'name', 'score')->get();

            return response()->json([
                'message' => 'Disease summaries retrieved successfully.',
                'data' => $diseases,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getDiseaseById(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer|exists:diseases,id',
            ]);
    
            $disease = Disease::find($validatedData['id']);
    
            if (!$disease) {
                return response()->json([
                    'error' => 'Disease not found.',
                ], 404);
            }
    
            $disease->image = json_decode($disease->image, true);
    
            return response()->json([
                'message' => 'Disease retrieved successfully.',
                'data' => $disease,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
    

    
    
}
