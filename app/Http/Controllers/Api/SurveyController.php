<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;

use App\Models\SurveySet;
use App\Models\Questionnaire;
use App\Models\Question;
class SurveyController extends Controller
{
        public function store(Request $request, Survey $survey)
        {
            $rules = array(
				'farm_id'=>'required',
                'farmer_id'=>'required',
                'survey_id' => 'required',
                'data'=>'required',
				'points' => 'required'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
         }

            // $surveyArr['farmer_id']=Auth::id();
			$surveyArr['farm_id']=$request->farm_id;
            $surveyArr['farmer_id']=$request->farmer_id;
            $surveyArr['survey_id']=$request->survey_id;
            $surveyArr['survey_data']=$request->data;
			$surveyArr['status']=$request->status;
            $surveyObj = $survey->saveNewSurvey($surveyArr);
            if (!$surveyObj) {
            	return returnErrorResponse('Unable to add survey. Please try again later');
            }
			User::where('id',$request->farmer_id)->increment('reward_points',$request->points);
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
		$farm_id = $request->farm_id;
		$surveyID = $request->survey_id;
		$query = "SELECT * FROM surveys WHERE farm_id = '$farm_id' AND survey_id= '$surveyID'";
		$res = $conn->query($query);
		if($res->rowCount() > 0){
            	    return '{"status":"success","message":"survey completed"}';
        	}
		return '{"status":"failed","message":"survey not completed"}';
        }
	
		public function getSurvey($surveyId)
		{
			$survey = Survey::find($surveyId);
			$farmer_id = $survey->farmer_id;
			$survey_id = $survey->survey_id;
			$survey = $survey->where('farmer_id', $farmer_id)->where('survey_id', $survey_id)->first();
			if (!$survey) {
				return returnErrorResponse('No survey found');
			}
			return returnSuccessResponse('Survey found', $survey);
		}
	
		public function getSurveyByFarmer($farmer_id)
		{
			$survey = Survey::where('farmer_id', $farmer_id)->get();
			if (!$survey) {
				return returnErrorResponse('No survey found');
			}
			return returnSuccessResponse('Survey found', $survey);
		}
	public function isSurveyFinished($surveyId,$farmerId,$farmID){
		$survey = Survey::where('survey_id',$surveyId)
			->where('farmer_id', $farmerId)
			->where('farm_id', $farmID)->get()->toArray();
		
		return returnSuccessResponse(Count($survey) > 0 ? 'found' : "not found",[
			
		]);
		
	}

	public function getQuestionnaire($id) {
        $decrypt_id = decrypt($id);

        $questionnaire = Questionnaire::find($decrypt_id);

        $data = array();

        if(!empty($questionnaire)) {
        	$decoded_ids = json_decode($questionnaire->question_data);

        	$questions = array();
        	foreach($decoded_ids->question_ids as $question_id) {
        		$question = Question::find($question_id);
        		$sub_field_type = json_decode($question->sub_field_type);

        		$arr = !empty($sub_field_type->choices) ? implode(", ", $sub_field_type->choices) : "";

        		$questions[] = [
        			'field_name' => $question->field_name,
        			'field_type' => $question->field_type,
        			'choices' => $arr,
        			'is_required' => $question->required_field == 1 ? 'required' : 'not required'
        		];

        	}

        	$data = [
        		'id' => encrypt($questionnaire->id),
        		'title' => $questionnaire->title,
        		'description' => $questionnaire->description,
        		'questions' => $questions
        	];
        }

        return json_encode($data);
    }

    public function getSurveySet($id) {
        $decrypt_id = decrypt($id);

        $survey_set = SurveySet::find($decrypt_id);

        $data = array();

        if(!empty($survey_set)) {
        	$decoded_ids = json_decode($survey_set->question_data);

        	$questions = array();
        	foreach($decoded_ids->question_ids as $question_id) {
        		$question = Question::find($question_id);
        		$sub_field_type = json_decode($question->sub_field_type);

        		$arr = !empty($sub_field_type->choices) ? implode(", ", $sub_field_type->choices) : "";

        		$questions[] = [
        			'field_name' => $question->field_name,
        			'field_type' => $question->field_type,
        			'choices' => $arr,
        			'is_required' => $question->required_field == 1 ? 'required' : 'not required'
        		];

        	}

        	$data = [
        		'id' => encrypt($survey_set->id),
        		'title' => $survey_set->title,
        		'description' => $survey_set->description,
        		'questions' => $questions
        	];
        }

        return json_encode($data);
    }
}
