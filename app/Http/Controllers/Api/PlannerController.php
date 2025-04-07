<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Planner;

class PlannerController extends Controller
{
    public function base($id){
        $id = $id == 'all' ? null : $id;
        $query = Planner::where('date_time', '>=', now());
        if($id == null){
            return $query;
        }else{
            return  $query->whereJsonContains('viewableBy', (string) $id);
        }
    }

    public function getAll($id = null)
    {
        $planners = $this->base($id);
        return response()->json(
            [
            'message' => 'Planners retrieved successfully',
            'data' => $planners->paginate(10)->items(),
            'summary' => [
                'demo' => $planners->clone()->where('type', 0)->count(),
                'meeting' => $planners->clone()->where('type', 1)->count(),
                'visit' => $planners->clone()->where('type', 2)->count(),
            ]
            ], 200
        );
    }


    public function getByType($id,$type)
    {
       
        $planner = $this->base($id)->where('type',$type)->get();

       
        return  response()->json([
                'data' => $planner
            ],200);
    }

    public function getByID($id)
    {
       
        $planner = Planner::find($id);
        if (is_null($planner)) {
            return response()->json(['message' => 'Planner not found'], 404);
        }
        return response()->json($planner);
    }

    public function upsert(Request $request, $id = null)
    {

        $data = $request->all();
        $data['date_time'] = date('Y-m-d H:i:s', strtotime($data['date_time']));
        $data['viewableBy'] = json_encode(explode('|',$data['viewableBy']));
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');
                $images[] = $path;
            }
            $data['images'] = json_encode($images);
        } else {
            $data['images'] = json_encode([]);
        }


        if ($id) {
            $planner = Planner::find($id);
            if (is_null($planner)) {
            return response()->json(['message' => 'Planner not found'], 404);
            }
            $planner->update($data);
            return response()->json($planner);
        } else {
            $planner = Planner::create($data);
            return response()->json($planner, 200);

            //return $data['viewableBy'];
        }
    }    

    public function destroy($id)
    {
        $planner = Planner::find($id);
        if (is_null($planner)) {
            return response()->json(['message' => 'Planner not found'], 404);
        }
        $planner->delete();
        return response()->json(['message' => "delete success"], 200);
    }
    public function factory()
    {
        return response()->json(['message' =>  Planner::factory()->count(5)->create()], 200);

    }
}