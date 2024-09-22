<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webinar;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class WebinarController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Webinar::all();

            return DataTables::of($data)
                ->addColumn('type', function ($data) {
                    // Create a shortened clickable link using the webinar title
                    return $data->type == 0 ? 'Webinar' : 'Conference';
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == 2) {

                        $startDate = strtotime($data->start_date);
                        $currentDate = time();

                        if ($startDate > $currentDate) {
                            return '<span class="text-warning">Not Started</span>';
                        } else {
                            return '<span class="text-success">Active</span>';
                        }

                    } elseif ($data->status == 1) {
                        return '<span class="text-info">Active</span>';
                    } elseif ($data->status == 0) {
                        return '<span class="text-success">Finished</span>';
                    }

                })
                ->addColumn('link', function ($data) {
                    // Create a shortened clickable link using the webinar title
                    return '<a href="' . $data->link . '" target="_blank" title="View Webinar" class="text-info">' . Str::limit($data->link, 50) . '</a>';
                })
                ->addColumn('image_source', function ($data) {
                    if ($data->image_source && Str::startsWith($data->image_source, 'webinars_images/')) {
                        // Use Storage::url to get the correct URL path
                        $imageUrl = Storage::url($data->image_source);
                
                        // Return the image HTML
                        return '<img src="' . $imageUrl . '" alt="Webinar Image" height="50">';
                    }
                    
                    return 'No Image';
                })
                ->addColumn('action', function ($data) {
                    return '<button class="editWebinar btn" data-id="' . $data->id . '" data-title="' . $data->title . '" data-type="' . $data->type . '" data-link="' . $data->link . '" data-status="' . $data->status . '" data-start_date="' . $data->start_date . '">
                                <i class="far fa-edit"></i>
                            </button>';
                })
                ->rawColumns(['status','link', 'image_source', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('webinars.index');
    }

    public function show()
    {
        return view('webinars.create');
    }

    public function create()
    {
        return view('webinars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'link' => 'required|url',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'image_source' => 'nullable|image|max:2048',
        ]);

        $webinar = new Webinar();
        $webinar->title = $request->title;
        $webinar->type = $request->type;
        $webinar->link = $request->link;
        $webinar->status = $request->status;
        $webinar->start_date = $request->start_date;

        if ($request->hasFile('image_source')) {
            // Handle image upload
            $path = $request->file('image_source')->store('webinars_images', 'public');
            $webinar->image_source = $path;
        }

        if(!$webinar->save()){
            return returnErrorResponse('Unable to create webinar/conference. Please try again later',$webinar);
        }

        return returnSuccessResponse( 'Webinar created successfully.',$webinar);
    }


    public function edit(Webinar $webinar)
    {
        return view('webinars.edit', compact('webinar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'link' => 'required|url',
            'status' => 'required|string',
            'start_date' => 'required|date',
            'image_source' => 'nullable|image|max:2048',
        ]);

        $webinar = Webinar::findOrFail($id);
        $webinar->title = $request->title;
        $webinar->type = $request->type;
        $webinar->link = $request->link;
        $webinar->status = $request->status;
        $webinar->start_date = $request->start_date;

        if ($request->hasFile('image_source')) {
            // Handle image upload
            $path = $request->file('image_source')->store('webinars_images', 'public');

            $webinar->image_source = $path;
        }

        if(!$webinar->save()){
            return returnErrorResponse('Unable to update webinar/conference. Please try again later',$webinar);
        }

        return returnSuccessResponse('Webinar/conference updated successfully',$webinar);
    }
    public function destroy(Webinar $webinar)
    {
        $webinar->delete();
        return redirect()->route('webinars.index')->with('success', 'Webinar deleted successfully.');
    }
}
