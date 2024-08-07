<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('prevent-back-history')->group(function (){
    
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        
        return Redirect::back()->with('success', 'All cache cleared successfully.');
    });
    Route::get('/install', function(){
        $app = DB::table("app")->orderByDesc("id")->first();
        //print_r($app->filename);
        return view('install',['app'=>$app]);
    })->name('install.app');
    Route::get('/upload-app', function(){
        
        return view('uploadApp');
    })->name('upload.app');
      
    Auth::routes();
    
    Route::middleware('auth')->group(function(){
        Route::get('/', function () {
            return redirect()->route('dashboard.index');
        })->name('user.home');
        
        
        Route::get('/farmers/export', 'UserController@export')->name('farmers.export');
        Route::get('/leads/export', 'UserController@export2')->name('leads.export');
        Route::resource('farmers', 'UserController');
        Route::get('getProvinceByRegion','UserController@getProvinceByRegion');
        Route::get('leads', 'UserController@leadsUser')->name("leads");
        
        Route::get('/farmer/changeStatus/{id}','UserController@changeStatus')->name('farmer.changeStatus');
        Route::get('user/profile','UserController@profile')->name('user.profile');
        Route::get('user/update-profile','UserController@showUpdateProfileForm')->name('user.updateProfile');
        Route::post('user/update-profile','UserController@updateProfile')->name('user.updateProfile.submit');
        Route::get('user/change-password','UserController@changePasswordView')->name('user.changePassword');
        Route::post('user/change-password','UserController@changePassword')->name('user.changePassword.submit');

        Route::get('/farms/getMapCoordinates','FarmController@getMapCoordinates');
        Route::resource('farms', 'FarmController');
        Route::resource('survey', 'SurveyController');
        Route::get('/registered_users', 'SurveyController@getRegisteredUsers');

        Route::get('/export-items/{id}', 'ExportController@exportItems')->name('export.items');
        Route::get('/export-survey/{id}', 'ExportController@exportSurveyItems')->name('export_survey_items');

        Route::resource('questions','QuestionController');

        Route::resource('questionnaires','QuestionnaireController');

        Route::get('survey_set','SurveySetController@index')->name('survey_set.index');
        Route::get('survey_set/create','SurveySetController@create')->name('survey_set.create');
        Route::get('survey_set/{survey_set}/edit','SurveySetController@edit')->name('survey_set.edit');
        Route::post('survey_set','SurveySetController@store')->name('survey_set.store');
        Route::get('survey_set/view/{survey_set}','SurveySetController@viewSurveySet')->name('survey_set.view');
        Route::put('survey_set/{survey_set}','SurveySetController@update')->name('survey_set.update');
        Route::put('survey_set/finalized/{survey_set}','SurveySetController@finalized')->name('survey_set.finalized');
        Route::put('survey_set/unfinalized/{survey_set}','SurveySetController@unfinalized')->name('survey_set.unfinalized');
        Route::delete('survey_set/{survey_set}','SurveySetController@destroy')->name('surevy_set.destroy');

    });
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/getCountCountry', 'DashboardController@getCountCountry');
    Route::get('/dashboard/getCountReco', 'DashboardController@getCountReco');
    Route::get('/dashboard/graphs', 'DashboardController@surveyGraphs');
    Route::get('/dashboard/getAgeChartData', 'DashboardController@getAgeChartData');
    Route::get('/dashboard/getGenderChartData', 'DashboardController@getGenderChartData');
    Route::get('/dashboard/getfarmCountChartData', 'DashboardController@getfarmCountChartData');
    Route::get('/dashboard/getfarmOwnershipChartData', 'DashboardController@getfarmOwnershipChartData');
    Route::get('/dashboard/getfarmEquipChartData', 'DashboardController@getfarmEquipChartData');
    Route::get('/dashboard/getfarmIrrigatedChartData', 'DashboardController@getfarmIrrigatedChartData');
    Route::get('/dashboard/getharvestChartData', 'DashboardController@getharvestChartData');
    Route::get('/dashboard/getseedTypeChartData', 'DashboardController@getseedTypeChartData');
    Route::get('/dashboard/getcropPracticeChartData', 'DashboardController@getcropPracticeChartData');
    Route::get('/dashboard/getfertilizerChartData', 'DashboardController@getfertilizerChartData');
    Route::get('/dashboard/getfarmProblemChartData', 'DashboardController@getfarmProblemChartData');
    Route::get('/dashboard/getfarmNoticeChartData', 'DashboardController@getfarmNoticeChartData');
    Route::get('/dashboard/getcommonPestChartData', 'DashboardController@getcommonPestChartData');
    Route::get('/dashboard/getsellChartData', 'DashboardController@getsellChartData');
    Route::get('/dashboard/getpriceFactorChartData', 'DashboardController@getpriceFactorChartData');
    Route::get('/dashboard/getappBasedChartData', 'DashboardController@getappBasedChartData');
    Route::get('/dashboard/getinitiativesChartData', 'DashboardController@getinitiativesChartData');
    Route::get('/dashboard/getphoneClassChartData', 'DashboardController@getphoneClassChartData');
    Route::get('/dashboard/getsmartphoneAppChartData', 'DashboardController@getsmartphoneAppChartData');
    Route::get('/dashboard/getfarmGroupAppChartData', 'DashboardController@getfarmGroupAppChartData');
    Route::get('/dashboard/getAreaPlantedPerVariety', 'DashboardController@getAreaPlantedPerVariety');
    Route::get('/dashboard/getVarietyPlantedPerRegion', 'DashboardController@getVarietyPlantedPerRegion');
    Route::get('/dashboard/getProvinceByRegion/{region}', 'DashboardController@getProvinceByRegion');
    Route::get('/dashboard/getDemoPerformed/{product}/{area}/{province}', 'DashboardController@getDemoPerformed');
    Route::get('/dashboard/getSampleUsed/{product}/{area}/{province}', 'DashboardController@getSampleUsed');
    Route::get('/dashboard/getPoints/{product}/{area}/{province}', 'DashboardController@getPoints'); 
    Route::get('/dashboard/getCropStandPerRegion', 'DashboardController@getCropStandPerRegion');
    Route::get('/dashboard/getDistinctFilters', 'DashboardController@getDistinctFilters');
    Route::get('/dashboard/getLegend', 'DashboardController@getLegend');
    Route::get('/dashboard/getRecommendations', 'DashboardController@getRecommendations');
    Route::get('/dashboard/getAgriProducts','DashboardController@getAgriProducts');
    Route::get('/dashboard/getSurveyV2','DashboardController@getSurveyV2');
    
    // Custom for Fetching locations \\
    Route::get('/calibrate/{level}/{code}','CalibrateLocationController@calibrate');
    
    // Sale Team Section \\
    Route::get('/sales','SalesTeamController@index')->name('sales.index');
    Route::get('/getProfile/{id}','SalesTeamController@getProfile')->name('sales.profile');

    // Contacts Section \\
    Route::get('/contacts','ContactController@index')->name('contacts.index');
    
});
