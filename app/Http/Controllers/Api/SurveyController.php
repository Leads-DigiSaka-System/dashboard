<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;

class SurveyController extends Controller
{
        public function store(Request $request, Survey $survey)
        {
            $rules = array(
                'farm_id'=>'required',
                'survey_data' => 'required',
                'status'=>'required',
              
                 
            );
             $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
         }

            $surveyArr['farmer_id']=Auth::id();
            $surveyArr['farm_id']=$request->farm_id;
            $surveyArr['survey_data']=$request->survey_data;
            $surveyArr['status']=$request->status;
            $surveyObj = $survey->saveNewSurvey($surveyArr);
            if (!$surveyObj) {
            return returnErrorResponse('Unable to add survey. Please try again later');
            }
            return returnSuccessResponse('Survey added successfully!.', $surveyObj);
         }
	public function complete(Request $request, Survey $survey)
        {
		$sn = "localhost";$un = "farmer";$pw = "BkjA8wwzt44sxH58yrq8";$db = "farmer";
		try {
            		$conn = new \PDO("mysql:host=$sn;dbname=$db", $un, $pw);
            		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	} catch(PDOException $e) {
            		die("error");
        	}
		$farmer_id = $request->farmer_id;
		$survey_id = $request->survey_id;
		$query = "INSERT INTO surveys_completed (farmer_id,survey_id) VALUES ('$farmer_id','$survey_id')";
		$conn->query($query);
		return '{"status":"success","message":"survey completed"}';
        }
	public function get_completed(Request $request, Survey $survey)
        {
		$sn = "localhost";$un = "farmer";$pw = "BkjA8wwzt44sxH58yrq8";$db = "farmer";
		try {
            		$conn = new \PDO("mysql:host=$sn;dbname=$db", $un, $pw);
            		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        	} catch(PDOException $e) {
            		die("error");
        	}
		$farmer_id = $request->farmer_id;
		$query = "SELECT * FROM surveys_completed WHERE farmer_id = '$farmer_id'";
		$res = $conn->query($query);
		$data = array();
		if($res->rowCount() > 0){
            	    while($row = $res->fetch(\PDO::FETCH_ASSOC)){
               		array_push($data,$row["survey_id"]);
            	    }
        	}
		//return $res->rowCount();
		return '{"status":"success","message":"survey completed","data":"'.json_encode($data).'"}';
        }

}
