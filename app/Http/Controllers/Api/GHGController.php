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

use Ixudra\Curl\Facades\Curl;
use Yajra\DataTables\Facades\DataTables;

use Carbon\Carbon;
class GHGController extends Controller
{

    public function get(?int $id = 0)
    {
        $response = Curl::to('http://192.168.1.3:81/ghg/public/api/v1/ghg/getProfiles')
        ->get();


        $jasProfiles = json_decode($response);

        return DataTables::of($jasProfiles)
                ->addColumn('formatted_created_at', function ($jasProfile) {
                    // Format the created_at date
                    return Carbon::parse($jasProfile->created_at)->format('M j, Y g:iA');
                })
                ->addColumn('formatted_modified_at', function ($jasProfile) {
                    // Format the created_at date
                    return Carbon::parse($jasProfile->modified_at)->format('M j, Y g:iA');
                })
                ->addColumn('action', function ($jasProfile) {
                    $buttons = "";
                    $buttons .=  '<a href="' . route('jasProfiles.pdf', encrypt($jasProfile->id)) . '" ><i class="fas fa-eye"></i></a>';

                    if(!empty($jasProfile->image)) {
                        $buttons .=' | 
                        <a data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="'.encrypt($jasProfile->id).'" class="viewImageBtn">
                        <i class="fas fa-images"></i></a>
                        ';
                    }
                    return $buttons;
                })
                ->rawColumns(['formatted_created_at', 'formatted_modified_at', 'action'  ])
                ->addIndexColumn()
                ->make(true);
    }

}
