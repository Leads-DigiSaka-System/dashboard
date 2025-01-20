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
            // Validate input data
            $validatedData = $request->validate([
                'name' => 'required|string|unique:diseases',
                'score' => 'nullable|string',
                'description' => 'nullable|string',
                'create_by' => 'required|string',
                'image' => 'nullable|array', // Expect an array of images
                'image.*' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Validate image files
            ]);

            // Initialize an array to store image paths
            $imagePaths = [];

            // If image files are present in the request
            if ($request->hasFile('image')) {
                // Loop through the files and process each one
                foreach ($request->file('image') as $file) {
                    $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                    $path = 'upload/images'; // Directory to store the images
                    $file->move(public_path($path), $name); // Move the image to the directory
                    $imagePaths[] = asset($path . '/' . $name); // Save the image URL
                }
            }

            // Create the Disease record in the database
            $disease = Disease::create([
                'name' => $validatedData['name'],
                'score' => $validatedData['score'],
                'description' => $validatedData['description'],
                'image' => json_encode($imagePaths), // Store image paths as JSON
                'create_by' => $validatedData['create_by'],
            ]);

            DB::commit();

            // Return success response with the created disease
            return response()->json([
                'message' => 'Disease created successfully!',
                'data' => $disease,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors if validation fails
            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollback();

            // Return generic error response
            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
