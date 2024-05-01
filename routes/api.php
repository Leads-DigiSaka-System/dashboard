<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        // User Login Route
        Route::post('/login', 'AuthController@login')->name('login');
		Route::post('/resendOtp', 'AuthController@resendOtp')->name('resendOtp');
		Route::post('/forgotPassword', 'AuthController@forgotPassword')->name('forgotPassword');
		Route::post('/resetPassword', 'AuthController@resetPassword')->name('resetPassword');
	    Route::get('/getPage', 'HomeController@getPage')->name('getPage');
		
		//SMS Verification
		Route::post('/sendSMSotp', 'AuthController@sendSMSOTP')->name('sendOTP');
		Route::post('/verifySMSotp', 'AuthController@verifySMSOTP')->name('verifyOTP');

		Route::middleware(['auth:sanctum'])->group(function () {
			Route::get('/logout', 'AuthController@logout')->name('logout');
			Route::post('/changePassword', 'AccountController@changePassword')->name('changePassword');
			Route::get('/profile', 'AccountController@getProfile')->name('profile');
			Route::post('/updateProfile', 'AccountController@updateProfile')->name('updateProfile');
			Route::get('/notification', 'AccountController@notification')->name('notification');
			Route::post('/contactUs', 'HomeController@contactUs')->name('contactUs');
			Route::get('/farm-list', 'FarmController@index')->name('farm_list');
			Route::post('/farm-store', 'FarmController@store')->name('farm_store');
			Route::get('/farm-detail', 'FarmController@detail')->name('farm_detail');
			Route::post('/farm-update', 'FarmController@update')->name('farm_update');
			Route::delete('/farm-delete', 'FarmController@delete')->name('farm_delete');
			Route::get('/home', 'HomeController@index')->name('home');
			Route::get('/get-weather', 'HomeController@getWeather')->name('getWeather');
			Route::post('/survey-store', 'SurveyController@store')->name('survey_store');
		});
    });


});

//routes made by nikko

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
