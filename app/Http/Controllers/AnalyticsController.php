<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasActivity;
use App\Models\JasMonitoringData;

class AnalyticsController extends Controller
{
    public function index() {

        $activities = JasActivity::with('monitoringData')->get();

        $data = array();

        if(!$activities->isEmpty()) {
            foreach($activities as $activity) {

                //get the total count of timing and observation
                $timing_array = array();
                $observation_array = array();
                foreach($activity->monitoringData as $monitoring_data) {

                    if($monitoring_data) {
                        $timing_ans = !empty($monitoring_data->timing) ? $monitoring_data->timing : 'no answer';
                        $observation_ans = !empty($monitoring_data->observation) ? $monitoring_data->observation : 'no answer';

                        if(array_key_exists($monitoring_data->timing, $timing_array)){
                            $timing_array[$timing_ans] += 1;
                        } else {
                            $timing_array[$timing_ans] = 1;
                        }
                        
                        if(array_key_exists($monitoring_data->observation, $observation_array)){
                            $observation_array[$observation_ans] += 1;
                        } else {
                            $observation_array[$observation_ans] = 1;
                        }
                    }
                    
                }
                
                //convert to an array for pie chart
                $timing_arr = array();

                if(!empty($timing_array)) {
                    foreach($timing_array as $key => $value) {
                        $timing_arr[] = [
                            'name' => $key,
                            'y' => $value
                        ];
                    }
                }
                
                $observation_arr = array();

                if(!empty($observation_array)) {
                    foreach($observation_array as $key => $value) {
                        $observation_arr[] = [
                            'name' => $key,
                            'y' => $value
                        ];
                    }
                }

                if(!empty($timing_arr) && !empty($observation_arr)) {
                    $data[] = [
                        'title' => $activity->title,
                        'div_id' => strtolower(str_replace(" ", "_",$activity->title)),
                        'timing' => $timing_arr,
                        'observation' => $observation_arr,
                    ];
                }
                    
            }
        }
        return view('analytics', compact('data'));
    }
}
