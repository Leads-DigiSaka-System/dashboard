<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harvest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class HarvestController extends Controller
{
    /**
     * Store a new harvest record with file upload for validator_signature.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insertHarvest(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'jasprofile_id' => 'required|integer|exists:jas_profiles,id',
                'variety' => 'required|string|max:255',
                'seeding_rate' => 'required|string|max:255',
                'planting_date' => 'required|date',
                'harvesting_date' => 'required|date|after_or_equal:planting_date',
                'farm_location' => 'required|string|max:255',
                'farm_size' => 'required|string|max:255',
                'method_harvesting' => 'required|string|max:255',
                'number_of_canvas' => 'required|string|max:255',
                'kgs_per_cavan' => 'required|string|max:255',
                'total_yield_weight_kg' => 'required|string|max:255',
                'total_yield_weight_tons' => 'required|string|max:255',
                'validator' => 'required|string|max:255',
                'validator_signature' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048', 
            ]);

            $signaturePath = null;
            if ($request->hasFile('validator_signature')) {
                $file = $request->file('validator_signature');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images'; 
                $file->move(public_path($path), $name); 
                $signaturePath = asset($path . '/' . $name);
            }

            $harvest = Harvest::create([
                'jasprofile_id' => $validated['jasprofile_id'],
                'variety' => $validated['variety'],
                'seeding_rate' => $validated['seeding_rate'],
                'planting_date' => $validated['planting_date'],
                'harvesting_date' => $validated['harvesting_date'],
                'farm_location' => $validated['farm_location'],
                'farm_size' => $validated['farm_size'],
                'method_harvesting' => $validated['method_harvesting'],
                'number_of_canvas' => $validated['number_of_canvas'],
                'kgs_per_cavan' => $validated['kgs_per_cavan'],
                'total_yield_weight_kg' => $validated['total_yield_weight_kg'],
                'total_yield_weight_tons' => $validated['total_yield_weight_tons'],
                'validator' => $validated['validator'],
                'validator_signature' => $signaturePath, 
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Harvest record created successfully.',
                'data' => $harvest,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Validation failed.',
                'details' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getHarvestsByJasId(Request $request)
    {
        // Validate that jasprofile_id is provided in the form-data
        $validated = $request->validate([
            'jasprofile_id' => 'required|integer',
        ]);

        $jasprofileId = $validated['jasprofile_id'];

        // Fetch the harvest records
        $harvests = Harvest::where('jasprofile_id', $jasprofileId)->get();

        // Check if records are found
        if ($harvests->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No harvest records found for the given jasprofile_id.',
            ], 404);
        }

        // Return the harvest records
        return response()->json([
            'message' => 'success', 
            'data' => $harvests,
        ], 200);
    }
}
