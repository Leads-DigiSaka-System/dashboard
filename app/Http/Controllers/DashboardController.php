<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Demo;
use App\Models\Derby;
use App\Models\Farms;
use App\Models\Product;
use App\Models\Province;
use App\Models\Survey;
use App\Models\Region;
use App\Models\User;
use App\Models\Webinar;
use App\Models\QuestionSet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Auth;

class DashboardController extends Controller
{
    //
    protected $years_data;
    public function __construct()
    {
        $this->middleware('auth');
        $data = array();
        $years = ['2019','2020','2021','2022','2023','2024'];

        foreach($years as $year) {
            $months = [
                'Jan' => rand(10,100),
                'Feb' => rand(10,100),
                'Mar' => rand(10,100),
                'Apr' => rand(10,100),
                'May' => rand(10,100),
                'Jun' => rand(10,100),
                'Jul' => rand(10,100),
                'Aug' => rand(10,100),
                'Sep' => rand(10,100),
                'Oct' => rand(10,100),
                'Nov' => rand(10,100),
                'Dec' => rand(10,100)
            ];

            $data[$year] = $months;
        }

        $this->years_data = $data;
    }
    
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

    public function index()
    {
        $restriction = $this->getRegionFilter();

        $farmerPercent = $this->getPercentageCount("User");
        $farmPercent = $this->getPercentageCount("Farms");
        $surveyPercent = $this->getPercentageCount("Survey");
        $webinars = Webinar::orderBy('id', 'desc')->get();
        $users = User::where('role', '!=', 0)->where(function($query) use ($restriction) {
            $query->where('region', 'like', $restriction);
            if($restriction == "%%"){
                $query->orWhereNull('region');
            }
        })->where('role', 2)->count();
        $latest_farmers = User::where('role', '!=', 0)->where('region', 'like', $restriction)->orderBy('id', 'desc')->limit(10)->get();
        $latest_farms = Farms::orderBy('id', 'desc')->where('region', 'like', $restriction)->limit(10)->get();
        $top_performers = User::select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(referrers.referer) as user_count'))
            ->leftJoin('users as referrers', 'users.id', '=', 'referrers.referer')
            ->where('users.region', 'like', $restriction)
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderByDesc('user_count')
            ->take(5)
            ->get();

        $registeredFarmers = User::where('role', 2)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $farms = Farms::where(function($query) use ($restriction) {
            $query->where('region', 'like', $restriction);
            if($restriction == "%%"){
                $query->orWhereNull('region');
            }
        })->count();
        
        $survey = 0;
        $survey_temp = Survey::get();
        foreach ($survey_temp as $key => $value) {
            $temp = User::where("id", $value->farmer_id)
            ->where(function($query) use ($restriction) {
                $query->where('region', 'like', $restriction);
                if($restriction == "%%"){
                    $query->orWhereNull('region');
                }
            })->get();
            if(count($temp) > 0){
                $survey++;
            }
        }

        $allFarms = Farms::getAllFarmWithFarmerDetails($restriction);
        $randomFarms = Farms::getRandomFarmWthFarmerDetails($restriction);
        $allArea = Province::getAllArea($restriction);
        $allRegion = Region::all();
        $distinctFilters = Derby::select('region')
        ->distinct()
        ->where('region','!=', '')
        ->orderBy('region') 
        ->get();

        $filters = [
            'regions' => $distinctFilters->pluck('region')->unique()->values()
        ];

        return view('dashboard.index', compact("webinars","filters", "users", "farms", "survey", "latest_farmers", "latest_farms", "allFarms", "farmerPercent", "farmPercent", "surveyPercent", "allRegion", "top_performers", "randomFarms", "registeredFarmers"));
    }

    public function getDistinctFilters(Request $request)
    {
        $region = $request->input('region');
        $province = $request->input('province');
        $town = $request->input('town');

        $distinctFiltersQuery = Derby::select('province', 'town', 'barangay')
            ->when($region, function ($query) use ($region) {
                return $query->where('region', $region);
            })
            ->when($province, function ($query) use ($province) {
                return $query->where('province', $province);
            })
            ->when($town, function ($query) use ($town) {
                return $query->where('town', $town);
            })
            ->distinct();

        $distinctFilters = $distinctFiltersQuery->get();

        $result = [
            'provinces' => $distinctFiltersQuery->pluck('province')->unique()->values(),
            'towns' => $distinctFiltersQuery->pluck('town')->unique()->values(),
            'barangays' => $distinctFilters->pluck('barangay')->unique()->values(),
        ];

        return response()->json($result);
    }

    public function getPercentageCount($modelName)
    {
        $modelClass = "App\\Models\\" . $modelName;
        $startOfLastWeek = now()->startOfWeek()->subWeek();
        $endOfLastWeek = now()->endOfWeek()->subWeek();
        $startOfCurentWeek = now()->startOfWeek();
        $endOfCurrentWeek = now()->endOfWeek();

        $lastWeekCount = $modelClass::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->count();
        $currentWeekCount = $modelClass::whereBetween('created_at', [$startOfCurentWeek, $endOfCurrentWeek])->count();
        if ($lastWeekCount != 0) {
            $increasePercent = round((($currentWeekCount - $lastWeekCount) / $lastWeekCount) * 100);
        } else {
            $increasePercent = 0;
        }

        return $increasePercent;
    }

    public function getCountCountry()
    {
        $data = User::select('country', DB::raw('COUNT(*) as row_count'))
            ->groupBy('country')
            ->get();

        return response()->json($data);
    }

    public function getCountReco()
    {
        $year = date('Y');

        $monthlyCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->get();

        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[$i] = 0;
        }

        foreach ($monthlyCounts as $monthlyCount) {
            $month = $monthlyCount->month;
            $count = $monthlyCount->count;
            $data[$month] = $count;
        }

        return response()->json($data);
    }

    public function surveyGraphs()
    {
        // $this->getAgeChartData();
        return view('dashboard.graphs');
    }

    public function getAgeChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Under 18' => 0,
            '18-24' => 0,
            '25-34' => 0,
            '35-44' => 0,
            '45-54' => 0,
            '55-64' => 0,
            '65+' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);
            // echo '<pre>'; print_r($surveyResponseData); echo '</pre>';
            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130208182') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';

        return response()->json($result);
    }

    public function getGenderChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Male' => 0,
            'Female' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);
            //     echo '<pre>';
            // print_r($surveyResponseData);
            // echo '</pre>';
            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130208197') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';

        return response()->json($result);
    }

    public function getfarmCountChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
            '>5' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137438820') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        // ksort($responseCounts);
        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfarmOwnershipChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Owner' => 0,
            'Tenant (kasama)' => 0,
            'Leasee (upa)' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137430181') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfarmEquipChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Tractor' => 0,
            'Seeder' => 0,
            'Carabao' => 0,
            'Cow' => 0,
            'Water pump' => 0,
            'Rice milling machine' => 0,
            'Harvester / Threshers (Halimaw)' => 0,
            'Hand Tools' => 0,
            'Plows' => 0,
            'Harrows' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137430879') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }
    public function getfarmIrrigatedChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Yes' => 0,
            'No' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130208878') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }
    public function getharvestChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Manually' => 0,
            'Reaper' => 0,
            'Combine harvest' => 0,
            'Mechanical' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '142519207') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getseedTypeChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Regular' => 0,
            'Golden' => 0,
            'Inbred' => 0,
            'Hybrid' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);
            // echo '<pre>';
            // print_r($surveyResponseData);
            // echo '</pre>';
            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130209064') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getcropPracticeChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Yes' => 0,
            'No' => 0,
            'Sometimes' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130208734') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfertilizerChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'iSmart Boom' => 0,
            'Grand Foliar' => 0,
            'Yara Viking' => 0,
            'Hyfer Plus' => 0,
            'Yara Mila' => 0,
            'Turton' => 0,
            'Golden Bloom' => 0,
            'Organic' => 0,
            'No preference' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130208932') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfarmProblemChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Low yield (mababang ani)' => 0,
            'Pests and disease (peste)' => 0,
            'Irrigation is limited (kulang ang patubig)' => 0,
            'Low farm-gate price (barat na presyo)' => 0,
            'Farm inputs are limited' => 0,
            'Seeds sources' => 0,
            'Weeds (damo)' => 0,
            'Insects' => 0,
            'Typhoons and other natural disasters' => 0,
            'Fire' => 0,
            'Thieves' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137432589') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfarmNoticeChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'None of the above' => 0,
            'Water lettuce in the farm' => 0,
            'Oily film in the water' => 0,
            'Stagnant water (>3 weeks) before land preparation' => 0,
            'Dusty brown spots in the leaves after transplanting' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '140549119') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getcommonPestChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Snail (kuhol)' => 0,
            'Rat (Dagang bukid)' => 0,
            'Suso' => 0,
            'Blast (leaf and neck blast)' => 0,
            'Bacterial leaf blight' => 0,
            'Rice tungro disease/ green leafhopper' => 0,
            'Brown planthopper' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '138184969') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getsellChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Local market' => 0,
            'Contract growing' => 0,
            'Middleman' => 0,
            'Cooperative' => 0,
            'Export' => 0,
            'Online' => 0,
            'other' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130209084') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getpriceFactorChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Market demand and supply' => 0,
            'Quality of the crop' => 0,
            'Timing of harvest and sales' => 0,
            'Distance from markets' => 0,
            'Storage and post-harvest handling' => 0,
            'Contractual arrangements' => 0,
            'other' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '130209184') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getappBasedChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Very likely' => 0,
            'Likely' => 0,
            'Neither likely nor unlikely' => 0,
            'Unlikely' => 0,
            'Very unlikely' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137431616') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getinitiativesChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Yes' => 0,
            'No' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '140566709') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getphoneClassChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Smartphone Apple' => 0,
            'Smartphone Android' => 0,
            'Regular phone (not smartphone)' => 0,
            'No phone' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137431793') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getsmartphoneAppChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Yes' => 0,
            'No' => 0
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '137434960') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }

    public function getfarmGroupAppChartData()
    {
        $query = Survey::getAllSurveyByVersion(1);
        $responseCounts = [
            'Yes' => 0,
            'No' => 0,
        ];
        $skippedCount = 0;
        $answeredCount = 0;
        $question = '';

        foreach ($query as $data) {
            $surveyData = json_decode($data['survey_data'], true);
            $surveyResponseData = json_decode($surveyData['surveyResponse'], true);

            if (isset($surveyResponseData['responses']) && is_array($surveyResponseData['responses'])) {
                foreach ($surveyResponseData['responses'] as $response) {
                    if (isset($response['question_id']) && $response['question_id'] === '140549274') {
                        $question = $response['question_value'];
                        if (isset($response['answers']) && is_array($response['answers'])) {
                            if (empty($response['answers'])) {
                                $skippedCount++;
                            } else {
                                $answeredCount++;
                                foreach ($response['answers'] as $answer) {
                                    $answerValue = $answer['row_value'];

                                    if (array_key_exists($answerValue, $responseCounts)) {
                                        $responseCounts[$answerValue]++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $totalResponses = $skippedCount + $answeredCount;

        if ($totalResponses > 0) {
            foreach ($responseCounts as $key => $count) {
                $responseCounts[$key] = ($count / $totalResponses) * 100;
            }
        }

        $result = [
            'categories' => array_keys($responseCounts),
            'data' => array_values($responseCounts),
            'skipped' => $skippedCount,
            'answered' => $answeredCount,
            'question' => $question
        ];

        return response()->json($result);
    }
    public function getAreaPlantedPerVariety()
    {
        /*$data = Derby::getAreaPlantedPerVariety();
        $result = [
            'categories' => array_keys($data),
            'data' => array_values($data)
        ];*/

        $question_sets = QuestionSet::where('survey_id',2)
                    ->whereIN('question_id',[2,3,4])
                    ->get();

        $surveyList = Survey::where('version',2)->get();

        $survey_array = array();
        foreach($surveyList as $survey){
            $survey_data = json_decode($survey->survey_data);

            if(count($survey_data) == 13) {
                foreach($survey_data as $data) {
                    foreach($question_sets as $set) {
                        if($set->question_id == $data->question_id) {
                            $survey_array[$set->question][] = $data->answer;
                        }
                        
                    }
                    
                }
            }
        }

        $categories = [];
        $data = [];
        foreach($survey_array as $key => $value) {
            array_push($categories, $key);
            array_push($data,count($value));

        }
        $result = [
            'categories' => $categories,
            'data' => $data
        ];

        return response()->json($result);
    }


    public function getVarietyPlantedPerRegion()
    {
        $data = Derby::getVarietyPlantedPerRegion();

        $categories = [];
        $seriesData = [];

        foreach ($data as $variety => $regionData) {
            $categories[] = $variety;
            $seriesData[] = $regionData;
        }

        $result = [
            'categories' => $categories,
            'series' => $seriesData,
        ];

        return response()->json($result);
    }

    public function getProvinceByRegion($region)
    {
        $provinces = Province::where('regcode', $region)->get();
        return response()->json($provinces);
    }
    public function getDemoPerformed($product, $region, $provcode)
    {
        $demo = Demo::getDemoPerformed($product, $region, $provcode);
        return response()->json($demo);
    }
    public function getSampleUsed($product, $region, $provcode)
    {
        $demo = Demo::getSampleUsed($product, $region, $provcode);
        return response()->json($demo);
    }
    public function getPoints($product, $region, $provcode)
    {
        $demo = Demo::getPoints($product, $region, $provcode);
        // Capitalize the first letter of each word in farm_location
        foreach ($demo as &$point) {
            $location = $point->barangay == ''
                ? $point->municipality_name . ', ' . $point->province_name
                : $point->barangay . ', ' . $point->municipality_name . ', ' . $point->province_name;

            $point->farm_location = ucwords(strtolower($location));
        }
        return response()->json($demo);
    }
    public function getLegend() {
        $legend = Product::all();

        return response()->json($legend);
    }

    public function getRecommendations(Request $request) {
        $year = $request->year;

        $data = $this->years_data[$year];
        return response()->json($data);
    }


    public function getSurveyAnswered() {
        $question_sets = QuestionSet::where('survey_id',2)
                    ->whereIN('question_id',[2,3,4])
                    ->get();

        $demo_performed = QuestionSet::where('survey_id',2)
                    ->count();
        $surveyList = Survey::where('version',2)->get();

        
        $farms = array();
        $survey_array = array();
        $sample_used = 0;
        foreach($surveyList as $survey){
            $survey_data = json_decode($survey->survey_data);

            if(count($survey_data) == 13) {
                foreach($survey_data as $data) {
                    foreach($question_sets as $set) {
                        if($set->question_id == $data->question_id) {
                            $survey_array[$set->question][] = $data->answer;
                            $sample_used++;
                        }
                        
                    }
                    
                }
            }
        }


    }
    public function getAgriProducts(Request $request) {

        $question_sets = QuestionSet::where('survey_id',2)
                    ->whereIN('question_id',[2,3,4])
                    ->get();

        $demo_performed = QuestionSet::where('survey_id',2)
                    ->count();
        $surveyList = Survey::where('version',2)->get();

        
        $farms = array();
        $survey_array = array();
        $sample_used = 0;
        foreach($surveyList as $survey){
            $survey_data = json_decode($survey->survey_data);

            if(count($survey_data) == 13) {
                foreach($survey_data as $data) {
                    foreach($question_sets as $set) {
                        if($set->question_id == $data->question_id) {
                            $survey_array[$set->question][] = $data->answer;
                            $sample_used++;
                        }
                        
                    }
                    
                }

                $farm = Farms::join('users', 'farms.farmer_id', '=', 'users.id')
                    ->join('provinces', 'farms.province', '=', 'provinces.provcode')
                    ->join('municipalities', 'farms.municipality', '=', 'municipalities.muncode')
                    //->join('products', 'farms.product', '=', 'products.id')
                    ->select('farms.*','municipalities.name as municipality_name','provinces.name as province_name','users.*')
                    ->where('farms.id',$survey->farm_id)->first();
                //dd($farm->area_location);
                //dd($farm);

                if(!empty($farm)) {
                    $location = empty($farm->barangay) || $farm->barangay == ''
                        ? $farm->municipality_name . ', ' . $farm->province_name
                        : $farm->barangay . ', ' . $farm->municipality_name . ', ' . $farm->province_name;
                    $farm->farm_location = ucwords(strtolower($location));
                    $farms[] = $farm;
                }
            }
        }
        
        return response()->json(['points' => $farms,
            'demo_performed' => count($survey_array),
            'sample_used' => $sample_used]);
    }

    public function getSurveyV2() {
        $question_sets = QuestionSet::get();
        $surveyList = Survey::where('version',2)->get();

        $survey_array = array();
        
        $test = [];
        $questions = array( 2 => array());
        foreach($surveyList as $survey){
            $survey_data = json_decode($survey->survey_data);

            if(count($survey_data) == 13) {
                array_push($test, $survey_data);

            }

            foreach($survey_data as $data) {
                $skippedCount = 0;
                $answeredCount = 0;
                foreach($question_sets as $set) {
                    if(count($survey_data) == 13 && $set->survey_id == 2 ) {
                        $this->transformSurveyData($questions, 2, $data, $set);
                    }
                }
            }

        }

        //dd($test);
        $chartData = array();
        $chart_no = 1;
        foreach($questions[2] as $key => $value) {

            $chartData[] = array(
                'title' => $key,
                'categories' => array_keys($value['answers']),
                'data' => array_values($value['answers']),
                'answeredCount' => array_key_exists('answeredCount',$value) ? $value['answeredCount'] : 0,
                'skippedCount' => array_key_exists('skippedCount', $value) ? $value['skippedCount'] : 0,
                'element_id' => "element{$chart_no}"
            );

            $chart_no++;
        }

        //dd($chartData);
        return response()->json($chartData);
    }

    private function transformSurveyData(&$questions, $survey_id, $data, $set) {
        $skippedCount = 0;
        $answeredCount = 0;
        if($set->question_id == $data->question_id) {
            if(array_key_exists($set->question,$questions[$survey_id])) {
                if(array_key_exists($data->answer, $questions[$survey_id][$set->question]['answers'])) {
                    if($data->answer == "") {
                        $skippedCount++;
                    } else {
                        $answeredCount++;
                        $questions[$survey_id][$set->question]['answers'][$data->answer] += 1;
                        $questions[$survey_id][$set->question]['answers'][$data->answer] += 1;
                    }
                } else {
                    if($data->answer == "") {
                        $skippedCount++;
                    } else {
                        $answeredCount++;
                        $questions[$survey_id][$set->question]['answers'][$data->answer] = 1;
                    }
                }

                if(array_key_exists('skippedCount', $questions[$survey_id][$set->question])) {
                    $questions[$survey_id][$set->question]['skippedCount'] += $skippedCount;
                } else {
                    $questions[$survey_id][$set->question]['skippedCount'] = 1;
                }

                if(array_key_exists('answeredCount', $questions[$survey_id][$set->question])) {
                    $questions[$survey_id][$set->question]['answeredCount'] += $answeredCount;
                } else {
                    $questions[$survey_id][$set->question]['answeredCount'] = 1;
                }

            } else {
                if($data->answer == "") {
                    $skippedCount++;
                } else {
                    $answeredCount++;
                    $questions[$survey_id][$set->question]['answers'][$data->answer] = 1;
                    $questions[$survey_id][$set->question]['answeredCount'] = 1;
                }
                
            }
        }
    }
}
