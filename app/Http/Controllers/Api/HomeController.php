<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\ContactUs;
use App\Models\Farms; 
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Auth;

class HomeController extends Controller
{
   public function index(Request $request)
   {
      $user = $request->user();
      $farmer_id=Auth::id();
      $farm_detail=Farms::where('farmer_id',$farmer_id)->first();
      $survey_detail=Survey::where('farmer_id',$farmer_id)->first();
      $user_detail= $user->findUserById($farmer_id);
      $isFarm=false;
      $isSurvey=false;
      $isNew=false;
      if(!empty($farm_detail))
      {
        $isFarm=true;
      }
      if(!empty($survey_detail))
      {
        $isSurvey=true;
      }
      if(!isset($user_detail->gender)){
        $isNew = true;
      }
       $data=[
           'isFarm'=>$isFarm,
           'isSurvey'=>$isSurvey,
           'farm_detail'=>$farm_detail,
           'new_user'=>$isNew
         ];
      
      return returnSuccessResponse('home data get successfully.', $data);
   }
   public function getPoints($farmer_id)
  {
      $user = User::find($farmer_id);

      if ($user) {
          return response()->json(['message' => 'Success', 'reward_points' => $user->reward_points]);
      } else {
          return response()->json(['message' => 'User not found'], 404);
      }
  }

   public function weatherFromLatLng($apiKey,$latitude,$longitude,$data = "all",$days = 1){
     $searchWeatherAPI = "https://api.weatherapi.com/v1/forecast.json?key=$apiKey&days=$days&q=" . rawurlencode($this->ajax("https://geocode.maps.co/reverse?lat=$latitude&lon=$longitude&api_key=65efe79c96022483653905xzsda2f39")->display_name);
     $weatherData = $this->ajax($searchWeatherAPI);
     if($data != "all"){
      if($data == "current"){
        return $weatherData->current; 
      }else{
        return $weatherData->forecast; 
      }
     }else{
      return $weatherData; 
     }
   }

   public function ajax($url){
   
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $headers = array();
    $headers[] = "Accept: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
   }

   public function getWeather(Request $request)
   {
   
     $rules = array(
           
            'lat' => 'required',
            'lng'=>'required',
       );
      $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }
       
        $apiKey=env('WEATHER_KEY');
        $query=$request->lat.','.$request->lng;

        

   
      try{
       $encodedQuery = urlencode($query);
      
        $url = "http://dataservice.accuweather.com/locations/v1/search.json?q=$query&apikey=$apiKey";

            
               $curl = curl_init();
               curl_setopt($curl, CURLOPT_URL, $url);
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

               $response = curl_exec($curl);

               if ($response === false) {
                   $error = curl_error($curl);
                   return returnErrorResponse($error);
                   // Handle the error accordingly
               } else {
                   
                   $data = json_decode($response, true);
                   
                   if(isset($data['Message']))
                   {
                     
                     return returnErrorResponse($data['Message']);
                   }
              
                   $locationKey=$data[0]['Key'];
                   $city_name=$data[0]['EnglishName'];

                   $url = "http://dataservice.accuweather.com/currentconditions/v1/$locationKey?apikey=$apiKey";

                     $curl = curl_init();

                     curl_setopt($curl, CURLOPT_URL, $url);
                     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                     // Execute the cURL request
                     $response = curl_exec($curl);

                     if ($response === false) {
                         $error = curl_error($curl);
                         return returnErrorResponse($error);
                     } else {
                         // Process the JSON response
                         $current_conditions = json_decode($response, true);
                         
                     }
                     $url = "http://dataservice.accuweather.com/forecasts/v1/daily/5day/$locationKey?apikey=$apiKey";


                        $curl = curl_init();

                        // Set the cURL options
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                        // Execute the cURL request
                        $response = curl_exec($curl);

                        // Check if the request was successful
                        if ($response === false) {
                            $error = curl_error($curl);
                            return returnErrorResponse($error);
                            // Handle the error accordingly
                        } else {
                            // Process the JSON response
                            $daily = json_decode($response, true);
                            // Handle the data accordingly
                        }

                    $url = "http://dataservice.accuweather.com/forecasts/v1/hourly/12hour/$locationKey?apikey=$apiKey";

                              // Initialize a cURL session
                              $curl = curl_init();

                              // Set the cURL options
                              curl_setopt($curl, CURLOPT_URL, $url);
                              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                              // Execute the cURL request
                              $response = curl_exec($curl);

                              // Check if the request was successful
                              if ($response === false) {
                                  $error = curl_error($curl);
                                  return returnErrorResponse($error);
                                  // Handle the error accordingly
                              } else {
                                  // Process the JSON response
                                  $hourly = json_decode($response, true);
                                  // Handle the data accordingly
                              }

                     curl_close($curl);
                     $data=[
                        'city_name'=>$city_name,
                        'current_conditions'=>$current_conditions,
                        'daily'=>$daily,
                        'hourly'=>$hourly

                     ];
                      return returnSuccessResponse('Get Weather data successfully.', $data);
                                      
               }
            }
            catch(Exception $e){
             return returnErrorResponse($e);
            }

   }

    public function getPage(Request $request){

       $page_type = $request->page_type;

       if(empty($page_type))
          return returnErrorResponse('Please send page type.');

      $page = Page::where('page_type',$page_type)->first();

   return returnSuccessResponse('Data sent successfully',$page);

}

public function contactUs(Request $request,ContactUs $contactUs){

	$rules = [
            'full_name' => 'required',
            'email' => 'required',
            'category' => 'required|integer|min:1|max:3',
            'description' => 'required'

        ];
         $inputArr = $request->all();
        $validator = Validator::make($inputArr, $rules);
        if ($validator->fails()) {
            $errorMessages = $validator->errors()->all();
            throw new HttpResponseException(returnValidationErrorResponse($errorMessages[0]));
        }

        $contactUs = $contactUs->fill($request->all());
        if($contactUs->save())
        	return returnSuccessResponse('Message sent successfully',$contactUs);

        return returnErrorResponse("Something went wrong.");

   }
}
