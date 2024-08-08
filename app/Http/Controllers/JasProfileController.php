<?php

namespace App\Http\Controllers;

use App\Models\JasActivity;
use App\Models\JasProfile;
use App\Models\JasMonitoringData;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;
use Dompdf\Options;

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
                'users.full_name as technician_name'
            ])
            ->leftJoin('users', 'jas_profiles.technician', '=', 'users.id');
    
            return DataTables::of($jasProfiles)
                ->addColumn('action', function ($jasProfile) {
                    return '<a href="' . route('jasProfiles.pdf', encrypt($jasProfile->id)) . '" ><i class="fas fa-eye"></i></a>';
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('jasProfiles.index');
    }

    public function viewJasProfilePDF($id)
    {
        $id = decrypt($id);

        $profile = JasProfile::find($id);

        $monitoring = $profile->monitoring;
        $monitoring_data = JasMonitoringData::where('jas_profile_id', $profile->id)
            ->with('activity')
            ->get();
        
        $first_activity = JasActivity::where('pdf_table_no', 1)->get();
        $second_activity = JasActivity::where('pdf_table_no', 2)->get();
        // $activities = $monitoring->first()->monitoringData->first()->activity;

        // return $monitoring_data;

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
