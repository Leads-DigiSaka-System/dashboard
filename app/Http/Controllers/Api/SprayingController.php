<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Spraying;
use Validator;

class SprayingController extends Controller
{

    public function get($id = null){
        $data = $id ? Spraying::find($id) : Spraying::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Spraying data get successful',
            'data' => $data
        ]);
    }
    public function upsert($id = null){
        $request = request();
        $validator = Validator::make($request->all(),[
            'pathPoints' => 'required|json',
            'trackingTime' => 'required',
            'trackingRadius' => 'required|numeric',
            'address' => 'required|string'
        ]);
        if($validator->fails()) return response()->json(['status' => 500,'message' => $validator->errors()]);
        if($id){
            $spraying = Spraying::find($id);
            $spraying->pathPoints = $request->pathPoints;
            $spraying->trackingTime = date('Y-m-d H:i:s', strtotime($request->trackingTime));
            $spraying->trackingRadius = $request->trackingRadius;
            $spraying->address = $request->address;
            $spraying->save();
        }else{
            $spraying = new Spraying();
            $spraying->pathPoints = $request->pathPoints;
            $spraying->trackingTime = date('Y-m-d H:i:s', strtotime($request->trackingTime));
            $spraying->trackingRadius = $request->trackingRadius;
            $spraying->address = $request->address;
            $spraying->save();
        }
        return response()->json([
            'status' => 200,
            'message' =>'Success',
            'data' => $spraying
        ]);
    }
    public function destroy($id){
        $spraying = Spraying::find($id);
        $spraying->delete();
        return response()->json([
           'status' => 200,
           'message' =>"Spraying ${id}, Deleted Successfully",
            'data' => $spraying
        ]);
    }
    public function factory(){
        Spraying::factory(5)->create();
        return response()->json([
           'status' => 200,
           'message' =>'success',
            'data' => Spraying::all()
        ]);
    }
}
