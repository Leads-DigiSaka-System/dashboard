<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasActivity;
use App\Models\JasMonitoringData;
use App\Models\JasProfile;
use Illuminate\Support\Facades\DB;


class JasDetailsController extends Controller
{
    // public function getActivityDetails(Request $request)
    // {
    //     $activityName = $request->query('activityName');

    //     if (!$activityName) {
    //         return response()->json(['error' => 'Activity name is required.'], 400);
    //     }

    //     $activity = JasActivity::where('title', $activityName)->first();

    //     if (!$activity) {
    //         return response()->json(['error' => 'Activity not found.'], 404);
    //     }

    //     $data = \DB::table('jas_monitoring_data')
    //         ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
    //         ->join('jas_monitoring', 'jas_monitoring.monitoring_id', '=', 'jas_monitoring_data.monitoring_id')
    //         ->select(
    //             \DB::raw("CONCAT(jas_profiles.first_name, ' ', jas_profiles.last_name) AS full_name"),
    //             'jas_monitoring.product AS product_used',
    //             'jas_monitoring.pest_disease AS disease',
    //             'jas_monitoring.created_at AS date_of_activity', 
    //             'jas_monitoring_data.image1',
    //             'jas_monitoring_data.image2',
    //             'jas_monitoring_data.image3',
    //             'jas_monitoring_data.image4'
    //         )
    //         ->where('jas_monitoring_data.activity_id', $activity->activity_id)
    //         ->get();


    //     if ($data->isEmpty()) {
    //         return response()->json(['error' => 'No details found for the specified activity.'], 404);
    //     }

    //     return response()->json(['details' => $data], 200);
    // }
    // public function getActivityDetails(Request $request)
    // {
    //     $activityName = $request->query('activityName');
    //     $provinceId = $request->query('provinceId');  

    //     if (!$activityName) {
    //         return response()->json(['error' => 'Activity name is required.'], 400);
    //     }

    //     $activity = JasActivity::where('title', $activityName)->first();

    //     if (!$activity) {
    //         return response()->json(['error' => 'Activity not found.'], 404);
    //     }

    //     // Check if provinceId is provided
    //     if (!$provinceId) {
    //         return response()->json(['error' => 'Province ID is required.'], 400);
    //     }

    //     $query = \DB::table('jas_monitoring_data')
    //         ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
    //         ->join('jas_monitoring', 'jas_monitoring.monitoring_id', '=', 'jas_monitoring_data.monitoring_id')
    //         ->join('jas_activities', 'jas_activities.activity_id', '=', 'jas_monitoring_data.activity_id')
    //         ->select(
    //             \DB::raw("CONCAT(jas_profiles.first_name, ' ', jas_profiles.last_name) AS full_name"),
    //             'jas_monitoring.product AS product_used',
    //             'jas_monitoring.pest_disease AS disease',
    //             'jas_monitoring.created_at AS date_of_activity',
    //             'jas_monitoring_data.image1',
    //             'jas_monitoring_data.image2',
    //             'jas_monitoring_data.image3',
    //             'jas_monitoring_data.image4'
    //         )
    //         ->where('jas_monitoring_data.activity_id', $activity->activity_id)  // Filter by activity_id
    //         ->where('jas_profiles.province_id', $provinceId);  // Filter by province_id

    //     // Execute the query
    //     $data = $query->get();

    //     // If no data found, return error
    //     if ($data->isEmpty()) {
    //         return response()->json(['error' => 'No details found for the specified activity and area.'], 404);
    //     }

    //     // Return the data
    //     return response()->json(['details' => $data], 200);
    // }

    public function getActivityDetails(Request $request)
    {
        $activityName = $request->query('activityName');
        $provinceId = $request->query('provinceId');  

        if (!$activityName) {
            return response()->json(['error' => 'Activity name is required.'], 400);
        }

        $activity = JasActivity::where('title', $activityName)->first();

        if (!$activity) {
            return response()->json(['error' => 'Activity not found.'], 404);
        }

        // Check if provinceId is provided
        if (!$provinceId) {
            return response()->json(['error' => 'Province ID is required.'], 400);
        }

        // If provinceId is a string (province name), get the corresponding provcode
        if (!is_numeric($provinceId)) {
            $province = \DB::table('provinces')
                ->where('name', $provinceId)
                ->select('provcode')
                ->first();

            if (!$province) {
                return response()->json(['error' => 'Province not found.'], 404);
            }

            $provinceId = $province->provcode; // Use the retrieved provcode
        }

        // Main query using province_id
        $query = \DB::table('jas_monitoring_data')
            ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
            ->join('jas_monitoring', 'jas_monitoring.monitoring_id', '=', 'jas_monitoring_data.monitoring_id')
            ->join('jas_activities', 'jas_activities.activity_id', '=', 'jas_monitoring_data.activity_id')
            ->select(
                \DB::raw("CONCAT(jas_profiles.first_name, ' ', jas_profiles.last_name) AS full_name"),
                'jas_monitoring.product AS product_used',
                'jas_monitoring.pest_disease AS disease',
                'jas_monitoring.created_at AS date_of_activity',
                'jas_monitoring_data.image1',
                'jas_monitoring_data.image2',
                'jas_monitoring_data.image3',
                'jas_monitoring_data.image4'
            )
            ->where('jas_monitoring_data.activity_id', $activity->activity_id)  // Filter by activity_id
            ->where('jas_profiles.province_id', $provinceId);  // Filter by province_id

        // Execute the query
        $data = $query->get();

        // If no data found, return error
        if ($data->isEmpty()) {
            return response()->json(['error' => 'No details found for the specified activity and area.'], 404);
        }

        // Return the data
        return response()->json(['details' => $data], 200);
    }


}
