<?php

namespace App\Http\Controllers;

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

    public function get(?int $id = 0) {

        $response = Curl::to("{$this->base_url}getProfiles")
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
                    $buttons .=  '<a href="' . route('ghg.pdf', encrypt($jasProfile->id)) . '" target="_blank" ><i class="fas fa-eye"></i></a>';

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

    public function profilePdf($id) {
        ini_set('memory_limit', '512M');  // You can adjust the limit as needed
        set_time_limit(300);  // Increase script execution time if needed
        $response = Curl::to("{$this->base_url}getJasProfileData/{$id}")
        ->get();

        $response = json_decode($response);

        if($response->success) {
            $profile = $response->profile;
            $monitoring = $response->monitoring;
            $monitoring_data = $response->monitoring_data;
            $first_activity = $response->first_activity;
            $second_activity = $response->second_activity;

            $html = view('ghg.pdf.monitoring', compact('profile', 'monitoring', 'monitoring_data', 'first_activity', 'second_activity'))->render();

            $options = new Options();
            $options->set('defaultFont', 'Courier');
            $options->set('defaultPaperMargins', array(0, 0, 0, 0));
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('document.pdf', ['Attachment' => false]);
        } else {
            abort(404);
        }
        
    }

    public function viewSummaryReportPDF() {
        ini_set('memory_limit', '512M');  // You can adjust the limit as needed
        set_time_limit(300);  // Increase script execution time if needed

        $response = Curl::to("{$this->base_url}getSummaryReportPDF")
        ->get();

        $profiles = json_decode($response);

        // Render the HTML view
        $html = view('ghg.pdf.summary_report', compact('profiles'))->render();
    
        // Configure DOMPDF options
        $options = new \Dompdf\Options();
        $options->set('defaultFont', 'Courier');
        
        // Initialize DOMPDF instance
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
    
        // Stream the generated PDF back to the browser
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="summary_report.pdf"');
    }
}
