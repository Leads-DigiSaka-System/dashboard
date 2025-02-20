<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farms;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessEmail;
use Carbon\Carbon;
use App\Models\Survey;
use DB, Auth;

class FarmController extends Controller
{
   
    /**
     * Created By Arjinder Singh
     * Created At 21-06-2023
     * @var $request object of request class
     * @var $user object of farm class
     * @return object with farms
     * This function use to show farm list
     */

    public function getRegionFilter() {
        $user_role = Auth::user()->role;
        $user_region = Auth::user()->region;

        if($user_role == 0 || $user_role == 1){
            return "%%";
        } else if($user_role == 6){
            return $user_region;
        } else {
            return "";
        }
    }

    public function getStatusBadge($status){
        $status_temp = "";
        if($status == 1){
            $status_temp = "primary";
        } else {
            $status_temp = "danger";
        }

        return $status_temp;
    }

    public function getStatus($status){
        $status_temp = "";
        if($status == 1){
            $status_temp = "Active";
        } else {
            $status_temp = "Inactive";
        }
        
        return $status_temp;
    }

    public function index(Request $request, Farms $farm)
    {
        if ($request->ajax()) {
            // $farms = $farm->getAllFarms($request);
            // $search = $request['search']['value'];

            // $totalFarms = Farms::count();
            // $search = $request['search']['value'];
            // $setFilteredRecords = $totalFarms;

            // if (! empty($search)) {
            //     $setFilteredRecords = $farm->getAllFarms($request, true);
            //     if(empty($setFilteredRecords))
            //         $totalFarms = 0;
            // }

            $restriction = $this->getRegionFilter();
            $farms = DB::table("farms")
                ->select("users.*", "roles.title as role_title", "farms.*")
                ->join("users", "users.id", "=", "farms.farmer_id")
                ->join("roles", "roles.id", "=", "users.role")
                ->where(function($query) use ($restriction) {
                    $query->where('farms.region', 'like', $restriction);
                    if($restriction == "%%"){
                        $query->orWhereNull('farms.region');
                    }
                })
                ->orderBy('farms.created_at', 'desc')->get();

            return datatables()
                    ->of($farms)
                    ->addIndexColumn()
                   
                    ->addColumn('created_at', function ($farm) {
                        return $farm->created_at;
                    })
                    ->addColumn('full_name', function ($farm) {
                        // return $farm->farmerDetails ? $farm->farmerDetails->full_name : 'N/A';
                        return $farm->full_name ? $farm->full_name : "N/A";
                    })
                    ->addColumn('farm_id', function ($farm) {
                        return $farm->farm_id ? $farm->farm_id : 'N/A';
                    })
                    ->addColumn('role', function ($farm) {
                        // return $farm->farmerDetails && $farm->farmerDetails->roleDetails ? $farm->farmerDetails->roleDetails->title : 'N/A';
                        return $farm->role_title ? $farm->role_title : 'N/A';;
                    })
                    ->addColumn('registered_date', function ($farm) {
                        // return $farm->registered_date ? $farm->registered_date : 'N/A';
                        return $farm->created_at != NULL ? '<span style="display:none;">'.$farm->created_at.'</span> '.Carbon::parse($farm->created_at)->format('M d, Y g:iA') : 'N/A';
                    })
                    ->addColumn('action', function ($farm) {
                            $btn = '';
                            $btn .= '<a href="' . route('farms.show', encrypt($farm->id)) . '" title="View" class="btn btn-sm btn-info mb-1"><i class="fas fa-eye"></i></a>';
                            $btn .= '<a href="#" title="View Map" class="btn btn-sm btn-secondary mb-2 viewMapBtn" data-id="'.encrypt($farm->id).'"><i class="fas fa-map"></i></a>';
                            /*$btn .= '<a href="' . route('farmers.edit', encrypt($farm->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';*/
                            /*$btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($farm->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';*/
                        return $btn;
                    })
                    ->rawColumns([
                        'action',
                        'registered_date',
                        'status'        
                    ])
                    // ->setTotalRecords($totalFarms)
                    // ->setFilteredRecords($setFilteredRecords)
                    // ->skipPaging()
                    ->make(true);
        }

        return view('farms.index');
    }

    public function show($id)
    {
        try{
            $user = new Farms;
            $id = decrypt($id);
            $farmObj = $user->findFarmById($id);
            $farm_address=json_decode($farmObj->area_location);
             $surveys=Survey::where('farm_id',$id)->paginate(10);
            return view('farms.view', compact("farmObj","farm_address","surveys"));
        } catch (\Exception $ex) {
            if($ex->getMessage() == "The payload is invalid."){
                return redirect()->back()->with('error', "Invalid-request");
            }
            return redirect()->back()->with('error', "Something went wrong. Please try again later.");
        }
    }

     public function destroy($id)
    {
        $id = decrypt($id);
        $farm = new Farms;
        $farmObj = $farm->findFarmById($id);

        if (! $farmObj) {
            return returnNotFoundResponse('This farm does not exist');
        }

        $hasDeleted = $farmObj->delete();
        if ($hasDeleted) {
            return returnSuccessResponse('Farm deleted successfully');
        }

        return returnErrorResponse('Something went wrong. Please try again later');
    }

    public function getMapCoordinates(Request $request) {
        $id = decrypt($request->id);

        $user = new Farms;
        $farmObj = $user->findFarmById($id);
        $farm_address=json_decode($farmObj->area_location);

        return response()->json($farm_address);
    }
}
