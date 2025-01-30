<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JasProfile;
use App\Models\JasActivity;
use App\Models\JasMonitoring;
use App\Models\JasMonitoringData;
use Illuminate\Support\Str;
use File, DB;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Validator;

class JasController extends Controller
{

    public function getActivities()
    {
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

            $JasMonitoring->fill($request->all());

            if ($request->hasFile('signature')) {
                $file = $request->file('signature');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->signature = $path . '/' . $name;
            }

            // Handle image1
            if ($request->hasFile('image1')) {
                $file = $request->file('image1');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->image1 = $path . '/' . $name;
            }

            // Handle image2
            if ($request->hasFile('image2')) {
                $file = $request->file('image2');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->image2 = $path . '/' . $name;
            }

            // Handle image3
            if ($request->hasFile('image3')) {
                $file = $request->file('image3');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->image3 = $path . '/' . $name;
            }

            // Handle image4
            if ($request->hasFile('image4')) {
                $file = $request->file('image4');
                $name = Str::uuid() . '_' . time() . '_' . $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $JasMonitoring->image4 = $path . '/' . $name;
            }

            $JasMonitoring->save();
            DB::commit();
            return response()->json($JasMonitoring);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function deleteMonitoringData(int $id)
    {
        try {
            $JasProfile = JasMonitoringData::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch (Exception $e) {
            return response()->json('error', 500);
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


    public function deleteMonitoring(int $id)
    {
        try {
            $JasProfile = JasMonitoring::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch (Exception $e) {
            return response()->json('error', 500);
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
    public function getMonitoring(int $id = 0)
    {
        if ($id > 0) {
            $jas = JasMonitoring::where('monitoring_id', $id)->get();
        } else {
            $jas = JasMonitoring::all();
        }

        if ($jas->isEmpty()) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = $jas->map(function ($j) {
            $jArray = $j->toArray();
            return $jArray;
        });

        return response()->json($data);
    }
    public function upsert(Request $request, ?int $id = 0)
    {

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

    public function getSummaries(?string $level = '')
{
    $jasProfilesQuery = JasProfile::query();

    if (!empty($level)) {
        $jasProfilesQuery->where('jas_profiles.level', $level);
    }

    $data = [
        'total_registered' => $jasProfilesQuery->count(),
        'total_farms' => $jasProfilesQuery->where('farm_id', '!=', null)->count(),
        'total_location' => $jasProfilesQuery->whereNotNull('area')
            ->select('area', DB::raw('COUNT(*) as total'))
            ->groupBy('area')
            ->get()
            ->pluck('total', 'area'),
        'total_activities' => JasMonitoringData::join('jas_activities', 'jas_monitoring_data.activity_id', '=', 'jas_activities.activity_id')
            ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
            ->when($level, function ($query) use ($level) {
                $query->where('jas_profiles.level', $level);
            })
            ->select('jas_activities.title', DB::raw('COUNT(jas_monitoring_data.data_id) as total'))
            ->groupBy('jas_activities.title')
            ->get()
            ->pluck('total', 'title'),
        'product_usage' => JasMonitoring::join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring.jas_profile_id')
            ->when($level, function ($query) use ($level) {
                $query->where('jas_profiles.level', $level);
            })
            ->whereNotNull('product')
            ->select('product', DB::raw('COUNT(*) as total'))
            ->groupBy('product')
            ->get()
            ->pluck('total', 'product'),
        'fertilizer_usage' => JasMonitoring::join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring.jas_profile_id')
            ->when($level, function ($query) use ($level) {
                $query->where('jas_profiles.level', $level);
            })
            ->whereNotNull('fertilizer')
            ->select('fertilizer', DB::raw('COUNT(*) as total'))
            ->groupBy('fertilizer')
            ->get()
            ->pluck('total', 'fertilizer'),
        'harvest_details' => JasMonitoringData::join('jas_activities', 'jas_monitoring_data.activity_id', '=', 'jas_activities.activity_id')
            ->join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring_data.jas_profile_id')
            ->when($level, function ($query) use ($level) {
                $query->where('jas_profiles.level', $level);
            })
            ->where('jas_activities.title', 'LIKE', '%HARVESTING%')
            ->whereNotNull('jas_monitoring_data.timing')
            ->whereNotNull('jas_monitoring_data.observation')
            ->select('jas_monitoring_data.timing', 'jas_monitoring_data.observation', 'jas_monitoring_data.remarks')
            ->get(),
        'pest_usage' => JasMonitoring::join('jas_profiles', 'jas_profiles.id', '=', 'jas_monitoring.jas_profile_id')
            ->when($level, function ($query) use ($level) {
                $query->where('jas_profiles.level', $level);
            })
            ->whereNotNull('pest_disease')
            ->select('pest_disease', DB::raw('COUNT(*) as total'))
            ->groupBy('pest_disease')
            ->get()
            ->pluck('total', 'pest_disease'),
    ];

    return response()->json($data);
}

    public function delete(int $id)
    {
        try {
            $JasProfile = JasProfile::find($id);
            if ($JasProfile === null) {
                return response()->json(['message' => 'JasProfile not found'], 404);
            }
            $JasProfile->delete();
            return response()->json('success');
        } catch (Exception $e) {
            return response()->json('error', 500);
        }
    }

    public function getByTps(?int $id = 0)
    {
        if ($id > 0) {
            $jas = JasProfile::where('technician', $id)->get();
        } else {
            return response()->json(['error' => 'No data found'], 404);
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
    public function get(?int $id = 0)
    {
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

    // public function getJasProfileData($id)
    // {
    //     // Use the ID directly without decryption
    //     $profile = JasProfile::with('technician', 'farmer')->find($id);

    //     if (!$profile) {
    //         return response()->json(['success' => false, 'message' => 'Profile not found'], 404);
    //     }

    //     // Fetch related monitoring and monitoring data
    //     $monitoring = $profile->monitoring;
    //     $monitoring_data = JasMonitoringData::where('jas_profile_id', $profile->id)
    //         ->with('activity')
    //         ->get();

    //     // Fetch the activities for the PDF
    //     $first_activity = JasActivity::where('pdf_table_no', 1)->get();
    //     $second_activity = JasActivity::where('pdf_table_no', 2)->get();

    //     // Return the profile data along with monitoring and activities
    //     return response()->json([
    //         'success' => true,
    //         'data' => [
    //             'profile' => $profile,
    //             'monitoring' => $monitoring,
    //             'monitoring_data' => $monitoring_data,
    //             'first_activity' => $first_activity,
    //             'second_activity' => $second_activity,
    //         ]
    //     ]);
    // }
    public function getJasProfileData($id){
        ini_set('memory_limit', '512M');  // You can adjust the limit as needed
        set_time_limit(300);  // Increase script execution time if needed

        $profile = JasProfile::with('technician', 'farmer')->find($id);

        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Profile not found'], 404);
        }

        $monitoring = $profile->monitoring;
        $monitoring_data = JasMonitoringData::where('jas_profile_id', $profile->id)
            ->with('activity')
            ->get();

        $first_activity = JasActivity::where('pdf_table_no', 1)->get();
        $second_activity = JasActivity::where('pdf_table_no', 2)->get();

        $html = view('jasProfiles.pdf.enrollment', compact('profile', 'monitoring', 'monitoring_data', 'first_activity', 'second_activity'))->render();
        // return $html;
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('defaultPaperMargins', array(0, 0, 0, 0));
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }


    public function updateFarmId(Request $request)
    {
        // Validate request parameters
        $validator = Validator::make($request->all(), [
            'farmer_id' => 'required|integer|exists:jas_profiles,farmer_id',
            'farm_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $farmerId = $request->input('farmer_id');
        $farmId = $request->input('farm_id');

        // Update the farm_id in jas_profiles
        $updated = DB::table('jas_profiles')
            ->where('farmer_id', $farmerId)
            ->update(['farm_id' => $farmId]);

        if ($updated) {
            return response()->json(['message' => 'Farm ID updated successfully.'], 200);
        } else {
            return response()->json(['error' => 'Update failed or no changes made.'], 400);
        }
    }


}
