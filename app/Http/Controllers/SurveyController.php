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

    public function index(Request $request, Survey $survey)
    {
        if ($request->ajax()) {
            $surveys = $survey->getAllSurvey($request);
            $search = $request['search']['value'];

            $totalSurvey = Survey::count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalSurvey;

            if (! empty($search)) {
                $setFilteredRecords = $survey->getAllSurvey($request, true);
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

        return view('survey.index');
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
            $questions=json_decode($survey_data->surveyResponse);
           
            }
            

            return view('survey.view', compact("surveyObj","questions"));
        } catch (\Exception $ex) {
             
            if($ex->getMessage() == "The payload is invalid."){
                return redirect()->back()->with('error', "Invalid-request");
            }
            return redirect()->back()->with('error', "Something went wrong. Please try again later.");
        }
    }
}
