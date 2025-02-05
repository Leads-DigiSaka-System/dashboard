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
    private $base_url;
    public function __construct() {
        $this->base_url = 'http://192.168.1.3:81/ghg/public/api/v1/ghg/';
    }


    public function get(?int $id = 0)
    {
        $response = Curl::to("{$this->base_url}getProfiles")
        ->get();

        $jasProfiles = json_decode($response);

        
    }

    public function getGHGProfileData($id) {
        //ini_set('memory_limit', '512M');  // You can adjust the limit as needed
        //set_time_limit(300);  // Increase script execution time if needed

        $response = Curl::to("{$this->base_url}getJasProfileData/{$id}")
        ->get();

        $response = json_decode($response);

        return $response;
        // if($response->success) {
        //     $profile = $response->profile;
        //     $monitoring = $response->monitoring;
        //     $monitoring_data = $response->monitoring_data;
        //     $first_activity = $response->first_activity;
        //     $second_activity = $response->second_activity;

        //     $html = view('ghg.pdf.monitoring', compact('profile', 'monitoring', 'monitoring_data', 'first_activity', 'second_activity'))->render();

        //     $options = new Options();
        //     $options->set('defaultFont', 'Courier');
        //     $options->set('defaultPaperMargins', array(0, 0, 0, 0));
        //     $dompdf = new Dompdf($options);
        //     $dompdf->loadHtml($html);
        //     $dompdf->setPaper('A4', 'portrait');
        //     $dompdf->render();
        //     $dompdf->stream('document.pdf', ['Attachment' => false]);
        // } else {
        //     abort(404);
        // }
        
    }
}
