<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasActivity;
use App\Models\JasMonitoringData;
class JasActivityController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
        
            // Fetch the data from the database
            $results = JasActivity::get();

            return datatables()
                ->of($results)
                ->addIndexColumn()
                ->addColumn('title', function ($result) {
                    return $result->title ? $result->title : 'N/A';
                })
                ->addColumn('action', function ($result) {
                    $btn = "";
                    $btn .= '<button class="btn btn-primary" onclick="handleViewObservations(\''.encrypt($result->activity_id).'\')">View Timing/Observation</button>&nbsp;&nbsp;';
                    return $btn;
                })
                ->make(true);
        }
        return view('jasActivities.index');
    }

    public function getJasActivities($id) {
        $id = decrypt($id);

        $activity = JasActivity::where('activity_id',$id)->first();
        $monitoring_data = JasMonitoringData::select('timing','observation','jas_profile_id')->where('activity_id',$id)
            ->with('profile')
            ->get();
        $data = array();


        if(!$monitoring_data->isEmpty()) {
            foreach($monitoring_data as $monitoring) {
                $first_name = empty($monitoring->profile) ? "-" : $monitoring->profile->first_name;
                $last_name = empty($monitoring->profile) ? "-" : $monitoring->profile->last_name;
                $full_name = $first_name !== "-" && $last_name !== "-" ? $first_name.' '.$last_name : "Deleted User";

                $data[] = array(
                    'timing' => $monitoring->timing,
                    'observation' => $monitoring->observation,
                    'fullname' => $full_name,
                );
            }
        }
        
        return ['data' => $data,'title' => $activity->title];
    }
}
