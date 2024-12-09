<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\JasActivity;
use App\Models\JasProfile;
use App\Models\JasMonitoringData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JasProfileController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jasProfiles = JasProfile::select([
                'jas_profiles.id',
                'jas_profiles.first_name',
                'jas_profiles.last_name',
                'jas_profiles.phone',
                'jas_profiles.year',
                'jas_profiles.area',
                'jas_profiles.created_at', 
                'jas_profiles.modified_at',
                DB::raw("CONCAT(users.full_name, ' (', users.email, ')') as technician_name"),
            ])
                ->leftJoin('users', 'jas_profiles.technician', '=', 'users.id');

                if(Auth::user()->role == 5){
                    $jasProfiles->where('jas_profiles.technician', auth()->user()->id);
                }

                $technician_searchValue = $request->input('columns.0.search.value');
                if ($technician_searchValue) {
                    $jasProfiles->where('users.full_name', 'like', '%' . $technician_searchValue . '%');
                }

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

                    if(!$jasProfile->monitoringData->isEmpty()) {
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
        return view('jasProfiles.index');
    }

    public function viewJasProfilePDF($id)
    {
        // Increase memory limit to avoid memory issues during PDF generation
        ini_set('memory_limit', '512M');  // You can adjust the limit as needed
        set_time_limit(300);  // Increase script execution time if needed

        $id = decrypt($id);

        $profile = JasProfile::with('technician', 'farmer')->find($id);

        $monitoring = $profile->monitoring;
        $monitoring_data = JasMonitoringData::where('jas_profile_id', $profile->id)
            ->with('activity')
            ->get();

        $first_activity = JasActivity::where('pdf_table_no', 1)->where('active',1)->get();
        $second_activity = JasActivity::where('pdf_table_no', 2)->get();
        // $activities = $monitoring->first()->monitoringData->first()->activity;


        // return $profile;
        $html = view('jasProfiles.pdf.monitoring_new', compact('profile', 'monitoring', 'monitoring_data', 'first_activity', 'second_activity'))->render();
        // return $html;
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $options->set('defaultPaperMargins', array(0, 0, 0, 0));
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function viewJasSummaryReportPDF()
    {
        // Increase memory limit and execution time if necessary
        ini_set('memory_limit', '512M');
        set_time_limit(300);
    
        // Fetch the profiles data
        $profiles = JasProfile::with(['monitoring', 'monitoringData', 'farmer', 'technician'])->get();
    
        // Render the HTML view
        $html = view('jasProfiles.pdf.summary_report', compact('profiles'))->render();
    
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
    
    public function getMonitoringImages(Request $request) {
        $id = decrypt($request->id);

        $array = JasMonitoringData::where('jas_profile_id',$id)->with('activity')->get();

        $data = array();
        foreach($array as $arr) {
            $images = array();

            for($i = 1; $i <= 3; $i++) {
                $img_column = "image{$i}";
                if($arr[$img_column] && !empty($arr[$img_column])) {
                    $images[] = $arr[$img_column];
                }
            }

            $data[] = array(
                'activity' => $arr->activity->title,
                'images' => $images
            );
        }

        return response()->json($data);
    }
    public function create()
    {
        return view('jasProfiles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle' => 'nullable',
            'birthdate' => 'required|date',
            'phone' => 'required',
            'variety_used_wet' => 'nullable',
            'variety_used_dry' => 'nullable',
            'average_yield_wet' => 'nullable|numeric',
            'average_yield_dry' => 'nullable|numeric',
            'dealers' => 'nullable',
            'year' => 'required|integer',
            'image' => 'nullable|image',
            'technician' => 'nullable',
            'area' => 'nullable'
        ]);

        JasProfile::create($validated);

        return redirect()->route('jasProfiles.index')->with('success', 'Jas Profile created successfully.');
    }

    public function show(JasProfile $jasProfile)
    {
        return view('jasProfiles.show', compact('jasProfile'));
    }

    public function edit(JasProfile $jasProfile)
    {
        return view('jasProfiles.edit', compact('jasProfile'));
    }

    public function update(Request $request, JasProfile $jasProfile)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle' => 'nullable',
            'birthdate' => 'required|date',
            'phone' => 'required',
            'variety_used_wet' => 'nullable',
            'variety_used_dry' => 'nullable',
            'average_yield_wet' => 'nullable|numeric',
            'average_yield_dry' => 'nullable|numeric',
            'dealers' => 'nullable',
            'year' => 'required|integer',
            'image' => 'nullable|image',
            'technician' => 'nullable',
            'area' => 'nullable'
        ]);

        $jasProfile->update($validated);

        return redirect()->route('jasProfiles.index')->with('success', 'Jas Profile updated successfully.');
    }

    public function destroy(JasProfile $jasProfile)
    {
        $jasProfile->delete();

        return redirect()->route('jasProfiles.index')->with('success', 'Jas Profile deleted successfully.');
    }
}
