<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Journal;
use File, DB;
class JournalController extends Controller
{
    
    public function upsert(Request $request, ?Int $id = 0) {

        DB::beginTransaction();

        try {
            if($id == 0) {
                $journal = new Journal;
            } else {
                $journal = Journal::find($id);
            }

            if($request->has('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $path = 'upload/images';
                $file->move($path, $name);
                $image = $path . '/' . $name;
                $journal->image = $image; 
            }

            $journal->date = $request->date;
            $journal->description = $request->description;
            $journal->title = $request->title;
            $journal->type = $request->type;
            $journal->farm_id = $request->farm_id;
            $journal->farmer_id = $request->farmer_id;
            $journal->save();

            DB::commit();
            return response()->json('success');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json('error',500);
        }
    }
    public function delete(Int $id) {
        try {
            $journal = Journal::find($id);
          
            if(!empty($journal)) {
                $journal->delete();
            }
            else{
                return response()->json(['error' => 'Journal not found'], 404);
            }
            return response()->json('success');
        } catch(Exception $e) {
            return response()->json('error',500);
        }
    }
    public function get() {
        $journals = Journal::all();

        $data = array();

        foreach($journals as $journal) {
            $data[] = array(
                'id' => $journal->id,
                'date' => $journal->date,
                'description' => $journal->description,
                'title' => $journal->title,
                'image' => asset($journal->image),
                'type' => $journal->type,
                'farm_id' => $journal->farm_id,
                'farmer_id' => $journal->farmer_id
            );
        }
        return response()->json($data);

    }

    public function find(Int $id) {
        $journal = Journal::findOrFail($id);

        $data = array();
        if(!empty($journal)) {
            $data = array(
                'id' => $journal->id,
                'date' => $journal->date,
                'description' => $journal->description,
                'title' => $journal->title,
                'image' => asset($journal->image),
                'type' => $journal->type,
                'farm_id' => $journal->farm_id,
                'farmer_id' => $journal->farmer_id
            );
        }
        

        return response()->json($data);
    }
}
