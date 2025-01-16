<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Image;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// First Routes for API

Route::prefix('v1')->namespace('Api')->group(function () {
	Route::prefix('user')->name('user.')->group(function () {
		// User Register Route
		Route::post('/survey-complete', 'SurveyController@complete')->name('survey_complete');
		Route::post('/completedSurvey', 'SurveyController@get_completed')->name('get_completed');
		Route::post('/register', 'AuthController@register')->name('register');
		Route::post('/resendOtp', 'AuthController@resendOtp')->name('resendOtp');
		Route::post('/verifyOtp', 'AuthController@verifyOtp')->name('verifyOtp');
		Route::post('/exist', 'AuthController@doesExist')->name('doesExist');
		Route::post('/upload', 'AuthController@uploadFile')->name('uploadFile');
		Route::post('/uploadApp', 'AuthController@uploadApp')->name('uploadApp');
		Route::get('/latest_app', 'AuthController@latest_app')->name('uploadApp');
		Route::get('/app_details/{version}', 'AuthController@app_details')->name('uploadApp');
		Route::post('/verify_user/{id}', 'AuthController@verify_user')->name('verify_user');
		// Role data fetching
		Route::get('/getRoles', 'AuthController@getRoles')->name('getRole');

		// Regions data fetching
		Route::get('/regions', 'LocationController@getRegions')->name('getRegions');

		// Province data fetching
		Route::get('/regions/{regionCode}/provinces', 'LocationController@getProvinces')->name('getProvinces');

		// Municipality data fetching
		Route::get('/regions/{regionCode}/provinces/{provinceCode}/municipalities', 'LocationController@getMunicipalities')->name('getMunicipalities');

		// Farm ownership fetching
		Route::get('/farmOwnership', 'AuthController@getFarmOwnership')->name('getFarmOwnership');

		// Survey data fetching by id
		Route::get('/survey/{surveyId}', 'SurveyController@getSurvey')->name('getSurvey');

		// Survey data fetching by farmer id
		Route::get('/farmer-surveys/{farmerId}', 'SurveyController@getSurveyByFarmer')->name('getSurveyByFarmer');

		// Survey data fetching by farm id - nikko ( temporary )
		Route::post('/farm-surveys', 'SurveyController@get_completed')->name('getSurveyByFarm');

		// Get Farmer by referer
		Route::get('/farmers/{referer}', 'AccountController@getFarmerByReferer')->name('getFarmerByReferer');

		Route::get('/farms/{id}', 'FarmController@getFarmsByID')->name('getFarmsByID');
		Route::get('/get-farms/{id?}', 'FarmController@getAllFarms')->name('getAllFarms');
		Route::get('/farms/{demo}/{category}', 'FarmController@getFarms')->name('getFarms');
		// Get Weather data base on lat long
		Route::get('/weather/{api_key}/{latitude}/{longitude}/{data?}/{days?}', 'HomeController@weatherFromLatLng')->name('weatherFromLatLng');

		// Get Weather data base on lat long
		Route::get('/is-finished/{surveyId}/{farmerId}/{farmId}', 'SurveyController@isSurveyFinished')->name('isSurveyFinished');

		// Search Location
		Route::get('/location/search/{search}', 'LocationController@searchLocation')->name('searchLocation');
		Route::get('/location/search_barangay/{search}/{reg}/{prov}/{muni}', 'LocationController@searchBarangay')->name('searchBarangay');
		Route::get('/location/province/{prov_code}', 'LocationController@searchProvince')->name('searchProvince');
		// User Login Route
		Route::post('/login', 'AuthController@login')->name('login');
		Route::post('/resendOtp', 'AuthController@resendOtp')->name('resendOtp');
		Route::post('/forgotPassword', 'AuthController@forgotPassword')->name('forgotPassword');
		Route::post('/emailOtp', 'AuthController@emailOtp')->name('emailOtp');
		Route::post('/verifyEmailOtp', 'AuthController@verifyEmailOtp')->name('verifyEmailOtp');
		Route::post('/resetPassword', 'AuthController@resetPassword')->name('resetPassword');
		Route::get('/getPage', 'HomeController@getPage')->name('getPage');

		//SMS Verification
		Route::post('/sendSMSotp', 'AuthController@sendSMSOTP')->name('sendOTP');
		Route::post('/verifySMSotp', 'AuthController@verifySMSOTP')->name('verifyOTP');
		Route::get('/get-proof/{farmerId}', 'AccountController@getProof')->name('getProof');
		Route::middleware(['auth:sanctum'])->group(function () {

			Route::get('/calendar/{month?}', 'AuthController@getCalendar')->name('getCalendar');
			Route::post('/calendar_upsert/{id?}', 'AuthController@upsertCalendar')->name('upsertCalendar');
			Route::post('/calendar_delete/{id}', 'AuthController@delete');


			Route::get('/logout', 'AuthController@logout')->name('logout');
			Route::post('/changePassword', 'AccountController@changePassword')->name('changePassword');
			Route::get('/profile', 'AccountController@getProfile')->name('profile');
			Route::post('/updateProfile', 'AccountController@updateProfile')->name('updateProfile');
			Route::post('/updateRole/{user_id}', 'AccountController@updateRole')->name('updateRole');
			Route::post('/updateProfileAdmin', 'AccountController@updateProfileAdmin')->name('updateProfileAdmin');
			Route::post('/update_profile_pic', 'AccountController@updateProfilePic')->name('updateProfilePic');
			Route::get('/notification', 'AccountController@notification')->name('notification');
			Route::post('/contactUs', 'HomeController@contactUs')->name('contactUs');
			Route::get('/farm-list', 'FarmController@index')->name('farm_list');
			Route::get('/farm-list-for-pyweb', 'FarmController@detailForPyweb')->name('farm_list_pyweb');
			Route::post('/farm-store', 'FarmController@store')->name('farm_store');
			Route::get('/getPoints/{farmer_id}', 'HomeController@getPoints')->name('getPoints');
			Route::get('/farm-detail', 'FarmController@detail')->name('farm_detail');
			Route::post('/farm-update', 'FarmController@update')->name('farm_update');
			Route::delete('/farm-delete', 'FarmController@delete')->name('farm_delete');
			Route::post('/farmer-delete', 'FarmController@farmer_delete')->name('farm_delete');
			Route::get('/get-weather', 'HomeController@getWeather')->name('getWeather');
			Route::post('/survey-store', 'SurveyController@store')->name('survey_store');
			Route::get('/get-farmer-info/{farmerInfo}', 'AccountController@getFarmerInfo')->name('getFarmerInfo');
			//this should have admin privellege
			Route::get('/home', 'HomeController@index')->name('home');
			Route::get('/getAllMobile', 'AccountController@getAllMobile')->name('allMobile');
			Route::post('/verify-farmer', 'AccountController@verifyFarmer')->name('verifyFarmer');
			Route::get('/user-list/{role}', 'AccountController@userList')->name('userList');
			Route::get('/user-list-via/{via_app?}/{region?}/{province?}/{municipality?}', 'AccountController@userListVia')->name('userListVia');

			//JAS-profile
			Route::post('/jas/upsertProfile/{id?}', 'JasController@upsert');
			Route::get('/jas/getProfiles/{id?}', 'JasController@get');
			Route::post('/jas/delete/{id}', 'JasController@delete');
			Route::get('/jas/getProfileByTps/{id?}', 'JasController@getByTps');
			Route::get('/jas/getJasProfileData/{id}', 'JasController@getJasProfileData');

			//jas-activities
			Route::get('/jas/getActivities', 'JasController@getActivities');

			//jas-monitoring
			Route::post('/jas/upsertMonitoring/{id?}', 'JasController@upsertMonitoring');
			Route::get('/jas/getMonitoring/{id?}', 'JasController@getMonitoring');
			Route::get('/jas/getMonitoringByProfile/{id}', 'JasController@getMonitoringByProfile');
			Route::post('/jas/deleteMonitoring/{id}', 'JasController@deleteMonitoring');


			//jas summaries
			Route::get('/jas/getSummaries/{level?}', 'JasController@getSummaries');

			//jas-monitoring data
			Route::post('/jas/upsertMonitoringData/{id?}', 'JasController@upsertMonitoringData');
			Route::get('/jas/getMonitoringData/{id?}', 'JasController@getMonitoringData');
			Route::get('/jas/getMonitoringDataByProfile/{id}', 'JasController@getMonitoringDataByProfile');
			Route::post('/jas/deleteMonitoringData/{id}', 'JasController@deleteMonitoringData');


			Route::get('/search/{search}/{role?}', 'AuthController@searchUser')->name('searchUser');
			Route::get('/search_employee/{first_name}/{last_name}', 'AuthController@searchEmployee')->name('searchEmployee');
			Route::get('/search_by_area/{search}', 'AuthController@searchtps')->name('searchtps');


			Route::post('/image/upsert/{id?}', function (Request $request, $id = null) {
				$data = $request->all(); 
				
				$image = Image::updateOrCreate(
					['id' => $id], 
					$data
				);
			
				return response()->json($image);
			});

			Route::get('/image/get/{id?}', function ($id = null) {
				if ($id > 0) {
					$image = Image::find($id);
					if (!$image) {
						return response()->json(['message' => 'Record not found'], 404);
					}
					return response()->json($image);
				}
			
				return response()->json(Image::all());
			});
			
		});
	});

	Route::post('/farms/upsertJournal/{id?}', 'JournalController@upsert');
	Route::get('/farms/getJournals', 'JournalController@get');
	Route::post('/farms/deleteJournal/{id}', 'JournalController@delete');
	Route::get('/farms/getJournal/{id}', 'JournalController@find');

	Route::get('/survey_set/categ/{id}', 'SurveyController@getSurveySetByCateg')->name('getSurveySetByCateg');
	Route::get('/questionnaire/{id}', 'SurveyController@getQuestionnaire')->name('getQuestionnaireById');
	Route::get('/survey_set/{id}', 'SurveyController@getSurveySet')->name('getSurveySetById');
	Route::get('/surveys/checkDone/{survey_id}', 'SurveyController@checkDone')->name('checkDone');

});

/*
Route::prefix('v2')->namespace('Api2')->group(function () {
	Route::post('/login',function(Request $request){
		$rules = array(
			'email' => 'required|email:rfc,dns,filter',
			'password' => 'required',
		);
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {
			return "
				{
					'status' : 'error',
					'body' : 'invalid password or email format'
				}
			";
		}  

		if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

			return $this->sendFailedLoginResponse($request);

		}
		$token = "create token";
		return "
			{
				'status' : 'success',
				'body' : 'login success',
				'data' : $token
			}
		";
	})->name('fweb.login');
});
*/