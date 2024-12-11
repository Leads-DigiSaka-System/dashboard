<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JasActivity;
use App\Models\JasMonitoringData;
use App\Models\JasMonitoring;
use App\Models\JasProfile;

use DB;
class AnalyticsController extends Controller
{
    public function index() {
        $activities = JasActivity::where('active',1)->get();
        $jas_area = JasProfile::groupBy('area')->pluck('area')->filter();
        $jas_product = JasMonitoring::groupBy('product')->pluck('product')->filter();

        $data = array();
        return view('analytics', compact('activities','jas_area','jas_product','data'));
    }

    // public function generate(Request $request) {
    //     $activity_filter = $request->activity;
    //     $area_filter = $request->area;
    //     $product_filter = $request->product;

    //     $jas_profiles = null;
    //     $jas_monitoring = null;
    //     $activities = DB::table('jas_activities')
    //         ->select('*')
    //         ->when(!empty($activity_filter) && $activity_filter != 'all', function ($query) use ($activity_filter) {

    //             $query->where('activity_id', $activity_filter);
    //         })
    //         ->get();

    //     if(!empty($area_filter) && $area_filter != 'all') {
    //         $jas_profiles = JasProfile::where('area',$area_filter)->get()->pluck('id');

    //         //dd($jas_profiles);
    //         $query = JasMonitoringData::select('activity_id')->whereIn('jas_profile_id',[...$jas_profiles])->groupBy('activity_id')->get()->pluck('activity_id');

    //         //dd($query);
    //         $activities = JasActivity::whereIn('activity_id',[...$query])->get();
    //     }

    //     if(!empty($product_filter) && $product_filter != 'all') {
    //         $jas_monitoring = JasMonitoring::where('product',$product_filter)->get()->pluck('jas_profile_id');

    //         //dd($jas_monitoring);
    //         $query = JasMonitoringData::select('activity_id')->whereIn('jas_profile_id',[...$jas_monitoring])->groupBy('activity_id')->get()->pluck('activity_id');

    //         $activities = JasActivity::whereIn('activity_id',[...$query])->get();
    //     }

    //     if(!empty($jas_profiles) && !empty($jas_monitoring)) {

    //         //dd($jas_profiles,$jas_monitoring,$activities);
    //         $jas_monitoring_arr = [...$jas_monitoring];

    //         $commonValues = array_intersect([...$jas_monitoring], [...$jas_profiles]);



    //         if(!empty($commonValues)) {
    //             //$query = JasMonitoringData::select('activity_id')->whereIn('jas_profile_id',$jas_monitoring_arr)->groupBy('activity_id')->get()->pluck('activity_id');
    //             $activities = JasMonitoringData::whereIn('jas_profile_id',$jas_monitoring_arr)->with('activity')->get();

                
    //             // $activities = JasActivity::whereHas('monitoringData', function($query) use ($commonValues) {
    //             //     $query->whereIn('jas_profile_id',$commonValues);
    //             // })
    //             //->get();

    //             dd($commonValues,$activities[0]->monitoringData);
    //             //$activities = JasActivity::whereIn('activity_id',[...$query])->monitoring_data()->whereIn('jas_profile_id',$commonValues)->get();
    //         }else {
    //             $activities = array();
    //         }
            
    //     }

    //     $data = array();
    //     $que = false;

    //     if((is_array($activities) && !empty($activities))) {
    //         $que = true;
    //     } else if (($activities instanceof \Illuminate\Support\Collection && !$activities->isEmpty())) {
    //         $que = true;
    //     }
    //     //dd($que, $activities);

    //     if($que) {
    //         foreach($activities as $activity) {

    //             //get the total count of timing and observation
    //             $timing_array = array();
    //             $observation_array = array();

    //             $query_monitoring_data = JasMonitoringData::where('activity_id',$activity->activity_id)->get();
    //             foreach($query_monitoring_data as $monitoring_data) {

    //                 if($monitoring_data) {
    //                     $timing_ans = !empty($monitoring_data->timing) ? $monitoring_data->timing : 'no answer';
    //                     $observation_ans = !empty($monitoring_data->observation) ? $monitoring_data->observation : 'no answer';

    //                     if(array_key_exists($monitoring_data->timing, $timing_array)){
    //                         $timing_array[$timing_ans] += 1;
    //                     } else {
    //                         $timing_array[$timing_ans] = 1;
    //                     }
                        
    //                     if(array_key_exists($monitoring_data->observation, $observation_array)){
    //                         $observation_array[$observation_ans] += 1;
    //                     } else {
    //                         $observation_array[$observation_ans] = 1;
    //                     }
    //                 }
                    
    //             }
                
    //             //convert to an array for pie chart
    //             $timing_arr = array();

    //             if(!empty($timing_array)) {
    //                 foreach($timing_array as $key => $value) {
    //                     $timing_arr[] = [
    //                         'name' => $key,
    //                         'y' => $value
    //                     ];
    //                 }
    //             }
                

    //             $observation_arr = array();

    //             if(!empty($observation_array)) {
    //                 foreach($observation_array as $key => $value) {
    //                     $observation_arr[] = [
    //                         'name' => $key,
    //                         'y' => $value
    //                     ];
    //                 }
    //             }

    //             if(!empty($timing_arr) && !empty($observation_arr)) {
    //                 $data[] = [
    //                     'title' => $activity->title,
    //                     'div_id' => strtolower(str_replace(" ", "_",$activity->title)),
    //                     'timing' => $timing_arr,
    //                     'observation' => $observation_arr,
    //                 ];
    //             }
                    
    //         }
    //     }

    //     return response()->json($data);
    // }

    public function generate(Request $request) {
        $activity_filter = $request->activity;
        $area_filter = $request->area;
        $product_filter = $request->product;

        $jas_profiles = null;
        $jas_monitoring = null;

        $monitoring_data = JasMonitoringData::when(!empty($activity_filter) 
            && $activity_filter != 'all', function ($query) use ($activity_filter) {
                $query->where('activity_id', $activity_filter);
            })
            ->with('activity')
            ->get();
        
        
        if(!empty($area_filter) && $area_filter != 'all') {
            $jas_profiles = JasProfile::where('area',$area_filter)->get()->pluck('id');

            //dd($jas_profiles);
            $monitoring_data = JasMonitoringData::whereIn('jas_profile_id',[...$jas_profiles])
                ->when(!empty($activity_filter) && $activity_filter != 'all', function ($query) use ($activity_filter) {
                    $query->where('activity_id', $activity_filter);
                })
                ->with('activity')->get();
        }

        if(!empty($product_filter) && $product_filter != 'all') {
            $jas_monitoring = JasMonitoring::where('product',$product_filter)->get()->pluck('jas_profile_id');

            $monitoring_data = JasMonitoringData::select('activity_id')->whereIn('jas_profile_id',[...$jas_monitoring])
                ->when(!empty($activity_filter) && $activity_filter != 'all', function ($query) use ($activity_filter) {
                    $query->where('activity_id', $activity_filter);
                })
                ->with('activity')->get();
        }

        if(!empty($jas_profiles) && !empty($jas_monitoring)) {

            //dd($jas_profiles,$jas_monitoring,$activities);
            $jas_monitoring_arr = [...$jas_monitoring];

            $commonValues = array_intersect([...$jas_monitoring], [...$jas_profiles]);

            if(!empty($commonValues)) {
                $monitoring_data = JasMonitoringData::whereIn('jas_profile_id',$commonValues)
                ->when(!empty($activity_filter) && $activity_filter != 'all', function ($query) use ($activity_filter) {
                    $query->where('activity_id', $activity_filter);
                })
                ->with('activity')->get();

            }else {
                $monitoring_data = array();
            }
            
        }

        $que = false;

        if((is_array($monitoring_data) && !empty($monitoring_data))) {
            $que = true;
        } else if (($monitoring_data instanceof \Illuminate\Support\Collection && !$monitoring_data->isEmpty())) {
            $que = true;
        }

        $array = array();
        if($que) {
            foreach($monitoring_data as $monitoring) {
                $array[$monitoring->activity->title]['timing'][] = !empty($monitoring->timing) ? $monitoring->timing : 'no answer';
                $array[$monitoring->activity->title]['observation'][] = !empty($monitoring->observation) ? $monitoring->observation : 'no answer';
            }
        }


        $data = array();
        foreach($array as $activity => $arr) {
            $timing_arr = array();
            $observation_arr = array();
            foreach($arr['timing'] as $value) {
                if(array_key_exists($value, $timing_arr)) {
                    $timing_arr[$value] += 1;
                } else {
                    $timing_arr[$value] = 1;
                }
            }

            foreach($arr['observation'] as $value) {
                if(array_key_exists($value, $observation_arr)) {
                    $observation_arr[$value] += 1;
                } else {
                    $observation_arr[$value] = 1;
                }
            }

            $timing = array();
            if(!empty($timing_arr)) {
                foreach($timing_arr as $key => $value) {
                    $timing[] = [
                        'name' => $key,
                        'y' => $value
                    ];
                }
            }

            $observation = array();
            if(!empty($observation_arr)) {
                foreach($observation_arr as $key => $value) {
                    $observation[] = [
                        'name' => $key,
                        'y' => $value
                    ];
                }
            }

            $data[] = [
                'title' => $activity,
                'div_id' => strtolower(str_replace(" ", "_",$activity)),
                'timing' => $timing,
                'observation' => $observation,
            ];
        }

        // foreach($timing_array as $activity => $timing) {
        //     $sample = array();
        //     foreach($timing as $value) {
                
        //     }

        //     $timing_arr[$activity] = [...$sample];
        // }

        // foreach($observation_array as $activity => $observation) {
        //     $sample = array();
        //     foreach($observation as $value) {
        //         if(array_key_exists($value, $sample)) {
        //             $sample[$value] += 1;
        //         } else {
        //             $sample[$value] = 1;
        //         }
        //     }

        //     $observation_arr[$activity] = [...$sample];
        // }

        // dd(array_keys($timing_arr), array_keys($observation_arr));

        return response()->json($data);
    }
}
