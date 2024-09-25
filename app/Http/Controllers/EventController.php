<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $eventsArray = [];
        foreach ($events as $event) {
            // Add one day to the end date
            $endDate = Carbon::parse($event->end_date)->addDay()->format('Y-m-d');

            $eventsArray[] = [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $endDate, // Use adjusted end date
                'end_date' => $event->end_date,
                'extendedProps' => [
                    'activity_type' => $event->activity_type,
                ]
            ];
        }
        return response()->json($eventsArray);
    }

    public function store(Request $request)
    {
        $event = new Event();
        $event->title = $request->input('title');
        $event->activity_type = $request->input('activity_type');
        $event->start_date = $request->input('start_date');
        $event->end_date = $request->input('end_date');
        $event->created_by = auth()->user()->id;
        $event->save();

        return response()->json(['status' => 'Event created successfully']);
    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if ($event) {
            $event->title = $request->input('title');
            $event->start_date = $request->input('start_date');
            $event->end_date = $request->input('end_date'); // Adjust end date
            $event->activity_type = $request->input('activity_type');
            $event->save();

            return response()->json(['success' => 'Event updated successfully']);
        } else {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }

    public function delete($id)
    {
        // Find the event by its ID
        $event = Event::find($id);

        if ($event) {
            // Delete the event from the database
            $event->delete();

            // Return a success response
            return response()->json(['success' => 'Event deleted successfully']);
        } else {
            // Return an error response if the event was not found
            return response()->json(['error' => 'Event not found'], 404);
        }
    }


}