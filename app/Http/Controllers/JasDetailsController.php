<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasActivity;
use App\Models\JasMonitoringData;
use App\Models\JasProfile;
use Illuminate\Support\Facades\DB;


class JasDetailsController extends Controller
{
    public function getActivityDetails(Request $request)
    {
        $activityName = $request->query('activityName');

        if (!$activityName) {
            return response()->json(['error' => 'Activity name is required.'], 400);
        }

        $activity = JasActivity::where('title', $activityName)->first();

        if (!$activity) {
            return response()->json(['error' => 'Activity not found.'], 404);
        }

        $data = \DB::table('jas_monitoring_data')
            ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
            ->join('jas_monitoring', 'jas_monitoring.monitoring_id', '=', 'jas_monitoring_data.monitoring_id')
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
            ->where('jas_monitoring_data.activity_id', $activity->activity_id)
            ->get();


        if ($data->isEmpty()) {
            return response()->json(['error' => 'No details found for the specified activity.'], 404);
        }

        return response()->json(['details' => $data], 200);
    }
}
