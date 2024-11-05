<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Role;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Jobs\ProcessEmail;
use Carbon\Carbon;
use DB;

class SurveyController extends Controller
{
    /**
     * Created By Arjinder Singh
     * Created At 19-07-2023
     * @var $request object of request class
     * @var $survey object of survey class
     * @return object with survey
     * This function use to show survey list
     */

    public function getStatus($status){
        // $list = [
        //     0=>"Active",
        //     1=>"Inactive"
        // ];
        // return isset($list[$status]) ? $list[$status] : "Not defined";
        return $status == 1 ? "Active" : "Inactive";
    }

    public function getStatusBadge($status){
        // $list = [
        //     0=>"primary",
        //     1=>"danger"
        // ];
        // return isset($list[$status]) ? $list[$status] : "danger";

        return $status == 1 ? "primary" : "danger";
    }

    public function index(Request $request, Survey $survey)
    {
        if ($request->ajax()) {
            $surveys = $survey->getAllSurvey($request, false, 1);
            $search = $request['search']['value'];

            $totalSurvey = Survey::count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalSurvey;

            if (! empty($search)) {
                $setFilteredRecords = $survey->getAllSurvey($request, true, 1);
                if(empty($setFilteredRecords))
                    $totalSurvey = 0;
            }

            return datatables()
                    ->of($surveys)
                    ->addIndexColumn()
                   
                    
                    ->addColumn('full_name', function ($survey) {
                        return $survey->farmerDetails ? $survey->farmerDetails->full_name : 'N/A';
                    })
                    ->addColumn('farm_id', function ($survey) {
                        return $survey->farmDetails ? $survey->farmDetails->farm_id : 'N/A';
                    })
                    ->addColumn('status', function ($survey) {
                        return '<span class="badge badge-light-' . $survey->getStatusBadge() . '">' . $survey->getStatus() . '</span>';
                    })
                    ->addColumn('date', function ($survey) {
                        return date('M d, Y', strtotime($survey->created_at));
                    })
                    ->addColumn('action', function ($survey) {
                            $btn = '';
                            $btn = '<a href="' . route('survey.show', encrypt($survey->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                     
                        return $btn;
                    })
                    ->rawColumns([
                        'action',
                        'status'        
                    ])
                    ->setTotalRecords($totalSurvey)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        $user_count = DB::table("users")->count();
        $farms_count = DB::table("farms")->count();

        return view('survey.index', ["user_count" => $user_count, "farms_count" => $farms_count]);
    }

    /**
     * Created By Arjinder Singh
     * Created At 19-07-2023
     * @var $request object of request class
     * @var $survey object of survey class
     * @return object with survey
     * This function use to show survey detail
     */

    public function show($id)
    {
        try{
            $questions=array();
            $survey = new Survey;
            $id = decrypt($id);
            $surveyObj = $survey->findSurveyById($id);
            $survey_data=json_decode($surveyObj->survey_data);
            if(!empty($survey_data))
            {
             $questions = json_decode($survey_data->surveyResponse);
            //  $questions = $survey_data;
           
            }
            

            return view('survey.view', compact("surveyObj","questions"));
        } catch (\Exception $ex) {
             
            if($ex->getMessage() == "The payload is invalid."){
                return redirect()->back()->with('error', "Invalid-request");
            }
            return redirect()->back()->with('error', "Something went wrong. Please try again later.");
            // die($ex);
        }
    }

    public function getRegisteredUsers(Request $request){
        if($request->ajax()){
            $users =DB::table("users")->get();
            return datatables()
                ->of($users)
                ->addIndexColumn()
                ->addColumn('status', function ($user) {
                    return '<span class="badge badge-light-' . $this->getStatusBadge($user->status) . '">' . $this->getStatus($user->status) . '</span>';
                })
                ->addColumn('created_at', function ($user) {
                    return $user->created_at;
                })
                ->addColumn('phone_number', function ($user) {
                    return $user->phone_number ? $user->phone_number : 'N/A';
                })
                // ->addColumn('role', function ($user) {
                //     return $user->role_title ? $user->role_title : 'N/A';
                // })
                ->addColumn('via_app', function ($user) {
                    return $user->via_app == 1 ? "YES" : 'NO';
                })
                ->addColumn('registered_date', function ($user) {
                    return $user->created_at != NULL ? Carbon::parse($user->created_at)->format('M d, Y g:iA') : 'N/A';
                })
                // ->addColumn('action', function ($user) {
                //         $btn = '';
                //         $btn = '<a href="' . route('farmers.show', encrypt($user->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                //         $btn .= '<a href="' . route('farmers.edit', encrypt($user->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                //         $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($user->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                //     return $btn;
                // })
                ->rawColumns([
                    'action',
                    'status'        
                ])
                ->make(true);
        }
    }
}
