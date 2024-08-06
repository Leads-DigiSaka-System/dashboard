<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JasProfile;
use App\Models\JasActivity;
use App\Models\JasMonitoring;
use App\Models\JasMonitoringData;
use File, DB;
class JasController extends Controller
{

    public function getActivities(){
        $activities = JasActivity::orderBy('sort', 'asc')->get();
        return response()->json($activities);
    }

    public function upsertMonitoringData(Request $request, ?int $id = 0)
    {
        DB::beginTransaction();

        try {
            if (!JasProfile::where('id', $request->jas_profile_id)->exists()) {
                return response()->json(['error' => 'JobProfile not found'], 404);
            }
            if ($id == 0) {
                $JasMonitoring = new JasMonitoringData;
            } else {
                $JasMonitoring = JasMonitoringData::find($id);
                if (!$JasMonitoring) {
                    return response()->json(['error' => 'Record not found'], 404);
                }
            }
            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $name = $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->signature = $path . '/' . $name;
            }
            $JasMonitoring->fill($request->all());
            $JasMonitoring->save();

            DB::commit();
            return response()->json($JasMonitoring);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

        
    public function deleteMonitoringData(Int $id) {
        try {
            $JasProfile = JasMonitoringData::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch(Exception $e) {
            return response()->json('error',500);
        }
    }
    public function getMonitoringData(?int $id = 0)
    {
        $jas = $id > 0 ? JasMonitoringData::where('data_id', $id)->get() : JasMonitoringData::all();

        if ($jas->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = $jas->map(function ($j) {
            $jArray = $j->toArray();
            return $jArray;
        });

        return response()->json($data);
    }
    public function getMonitoringDataByProfile(int $id = 0)
    {
        $jas = JasMonitoringData::where('jas_profile_id', $id)->get();

        if ($jas->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = $jas->map(function ($j) {
            $jArray = $j->toArray();
            return $jArray;
        });

        return response()->json($data);
    }
    public function upsertMonitoring(Request $request, ?int $id = 0)
    {
        DB::beginTransaction();

        try {
            if (!JasProfile::where('id', $request->jas_profile_id)->exists()) {
                return response()->json(['error' => 'JobProfile not found'], 404);
            }
            if ($id == 0) {
                $JasMonitoring = new JasMonitoring;
            } else {
                $JasMonitoring = JasMonitoring::find($id);
                if (!$JasMonitoring) {
                    return response()->json(['error' => 'Record not found'], 404);
                }
            }

            $JasMonitoring->fill($request->all());
            $JasMonitoring->save();

            DB::commit();
            return response()->json($JasMonitoring);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

        
    public function deleteMonitoring(Int $id) {
        try {
            $JasProfile = JasMonitoring::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch(Exception $e) {
            return response()->json('error',500);
        }
    }
    public function getMonitoringgetMonitoringByProfile(?int $id = 0)
    {
        $jas = $id > 0 ? JasMonitoring::where('monitoring_id', $id)->get() : JasMonitoring::all();

        if ($jas->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = $jas->map(function ($j) {
            $jArray = $j->toArray();
            return $jArray;
        });

        return response()->json($data);
    }
    public function getMonitoringByProfile(int $id = 0)
    {
        $jas = JasMonitoring::where('jas_profile_id', $id)->get();

        if ($jas->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = $jas->map(function ($j) {
            $jArray = $j->toArray();
            return $jArray;
        });

        return response()->json($data);
    }
    
    public function upsert(Request $request, ?Int $id = 0) {

        DB::beginTransaction();

        try {
            $JasProfile = $id == 0 ? new JasProfile : JasProfile::find($id);
        
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasProfile->image = $path . '/' . $name;
            }
        
            $JasProfile->fill($request->except('image'));
            $JasProfile->save();
        
            DB::commit();
            return response()->json($JasProfile);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json('error', 500);
        }

    }
        
    public function delete(Int $id) {
        try {
            $JasProfile = JasProfile::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch(Exception $e) {
            return response()->json('error',500);
        }
    }
    public function get(?Int $id = 0) {
        if ($id > 0) {
            $jas = JasProfile::where('id', $id)->get();
        } else {
            $jas = JasProfile::all();
        }
    
        $data = array();
        foreach ($jas as $j) {
            $jArray = $j->toArray();
            $jArray['image'] = asset($j->image);
            $data[] = $jArray;
        }
    
        if ($jas->count() == 0) {
            return response()->json(['error' => 'No data found'], 404);
        }
    
        return response()->json($data);
    }
    

}
