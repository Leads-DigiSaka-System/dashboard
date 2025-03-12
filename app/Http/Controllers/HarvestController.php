<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\HarvestExport;
use App\Models\Harvest; // Replace 'Harvest' with the actual model name if different
use Maatwebsite\Excel\Facades\Excel;

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
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $results = Harvest::with('jasProfile')->get();

    //         return datatables()
    //             ->of($results)
    //             ->addIndexColumn()
    //             ->addColumn('fullname', function ($result) {
    //                 return $result->jasProfile ? $result->jasProfile->first_name . ' ' . $result->jasProfile->middle . ' ' . $result->jasProfile->last_name : 'N/A';
    //             })
    //             ->addColumn('farm_location', function ($result) {
    //                 return $result->farm_location ? $result->farm_location : 'N/A';
    //             })
    //             ->addColumn('planting_date', function ($result) {
    //                 return $result->planting_date ? $result->planting_date : 'N/A';
    //             })
    //             ->addColumn('harvesting_date', function ($result) {
    //                 return $result->harvesting_date ? $result->harvesting_date : 'N/A';
    //             })
    //             ->addColumn('method_harvesting', function ($result) {
    //                 return $result->method_harvesting ? $result->method_harvesting : 'N/A';
    //             })
    //             ->addColumn('action', function ($result) {
    //                 $btn = "";
    //                 $btn .= '<button class="btn btn-primary" onclick="handleViewHarvest(\''.encrypt($result->id).'\')">View Details</button>&nbsp;&nbsp;';
    //                 return $btn;
    //             })
    //             ->make(true);
    //     }
    //     return view('jasHarvest.index');
    // }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $results = Harvest::select(
                    'harvest.jasprofile_id',
                    Harvest::raw('MIN(harvest.id) AS id'), // Use MIN to aggregate id
                    Harvest::raw('MIN(harvest.farm_location) AS farm_location'), // Aggregate farm_location
                    Harvest::raw('MIN(harvest.planting_date) AS planting_date'), // Aggregate planting_date
                    Harvest::raw('MIN(harvest.harvesting_date) AS harvesting_date'), // Aggregate harvesting_date
                    Harvest::raw('MIN(harvest.method_harvesting) AS method_harvesting'), // Aggregate method_harvesting
                    'jas_profiles.first_name',
                    'jas_profiles.middle',
                    'jas_profiles.last_name'
                )
                ->leftJoin('jas_profiles', 'jas_profiles.id', '=', 'harvest.jasprofile_id')
                ->groupBy('harvest.jasprofile_id', 'jas_profiles.first_name', 'jas_profiles.middle', 'jas_profiles.last_name')
                ->orderBy('harvest.jasprofile_id', 'asc')
                ->get();
    
            return datatables()
                ->of($results)
                ->addIndexColumn()
                ->addColumn('fullname', function ($result) {
                    $firstName = ucwords(strtolower($result->first_name));
                    $middleName = ucwords(strtolower($result->middle));
                    $lastName = ucwords(strtolower($result->last_name));
                    return trim("{$firstName} {$middleName} {$lastName}") ?: 'N/A';
                })
                ->addColumn('farm_location', function ($result) {
                    return $result->farm_location ?: 'N/A';
                })
                ->addColumn('planting_date', function ($result) {
                    return $result->planting_date ?: 'N/A';
                })
                ->addColumn('harvesting_date', function ($result) {
                    return $result->harvesting_date ?: 'N/A';
                })
                ->addColumn('method_harvesting', function ($result) {
                    return $result->method_harvesting ? ucwords(strtolower($result->method_harvesting)) : 'N/A';
                })                
                ->addColumn('action', function ($result) {
                    return '<button class="btn btn-success" onclick="handleViewHarvest(\''.encrypt($result->id).'\')">View Details</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('jasHarvest.index');
    }
    

    

    public function getJasHarvest($id)
    {
        $decrypted_id = decrypt($id);
        $harvest = Harvest::with('jasProfile')->find($decrypted_id);

        if (!$harvest) {
            return response()->json(['error' => 'Harvest not found'], 404);
        }

         // Concatenate first name, middle name, and last name to get the full name
        $full_name = $harvest->jasProfile 
        ? trim($harvest->jasProfile->first_name . ' ' . $harvest->jasProfile->middle . ' ' . $harvest->jasProfile->last_name)
        : null;

        return response()->json([
            'farm_location' => $harvest->farm_location,
            'planting_date' => $harvest->planting_date,
            'harvesting_date' => $harvest->harvesting_date,
            'method_harvesting' => $harvest->method_harvesting,
            'variety' => $harvest->variety,
            'seeding_rate' => $harvest->seeding_rate,
            'farm_size' => $harvest->farm_size,
            'total_yield_weight_kg' => $harvest->total_yield_weight_kg,
            'total_yield_weight_tons' => $harvest->total_yield_weight_tons,
            'number_of_canvas' => $harvest->number_of_canvas,
            'validator' => $harvest->validator,
            'validator_signature' => $harvest->validator_signature,
            'kgs_per_cavan' => $harvest->kgs_per_cavan,
            'jasprofile' => $harvest->jasProfile,
        ]);
    }

    public function export()
    {
        return Excel::download(new HarvestExport, 'harvest_data.xlsx');
    }

    
    
}
