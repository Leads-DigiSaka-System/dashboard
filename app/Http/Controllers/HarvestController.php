<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest; // Replace 'Harvest' with the actual model name if different

class HarvestController extends Controller
{
    /**
     * Store a new harvest record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jasprofile_id' => 'required|integer|exists:jas_profiles,id',
            'variety' => 'required|string|max:255',
            'seeding_rate' => 'required|string|max:255',
            'planting_date' => 'required|date',
            'harvesting_date' => 'required|date|after_or_equal:planting_date',
            'farm_location' => 'required|string|max:255',
            'farm_size' => 'required|string|max:255',
            'method_harvesting' => 'required|string|max:255',
            'number_of_canvas' => 'required|integer',
            'total_yield_weight_kg' => 'required|integer',
            'total_yield_weight_tons' => 'required|integer',
            'validator' => 'required|string|max:255',
            'validator_signature' => 'required|string',
        ]);

        try {
            $harvest = Harvest::create($validated);

            return response()->json([
                'message' => 'Harvest record created successfully.',
                'data' => $harvest,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create harvest record.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
