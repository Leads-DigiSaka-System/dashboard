<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\SurveySet;
use App\Models\SurveyVersion;

use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Api\SurveyController;

class SurveySetController extends Controller
{
    public function index(Request $request, SurveySet $survey_set) {
        if ($request->ajax()) {
            $survey_sets = $survey_set->getAllSurveySet($request);

            $search = $request['search']['value'];

            $totalSurveySet = SurveySet::count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalSurveySet;

            if (! empty($search)) {
                $setFilteredRecords = $survey_set->getAllSurveySet($request,true);
                if(empty($setFilteredRecords))
                    $totalSurveySet = 0;
            }

            return datatables()
                    ->of($survey_sets)
                    ->addIndexColumn()
                   
                    ->addColumn('created_at', function ($survey_set) {
                        return $survey_set->created_at;
                    })
                    ->addColumn('title', function ($survey_set) {
                        return $survey_set->title;
                    })
                    ->addColumn('description', function ($survey_set) {
                        return $survey_set->description;
                    })
                    ->addColumn('link', function ($survey_set) {
                        return route('getSurveySetById', encrypt($survey_set->id));
                    })
                    ->addColumn('action', function ($survey_set) {
                        $btn = '';
                        $btn .= '<a href="' . route('survey_set.view', encrypt($survey_set->id)) . '" title="Preview"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                        if($survey_set->is_finalized == 0){
                            $btn .= '<a href="' . route('survey_set.edit', encrypt($survey_set->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                            $btn .= '<a href="javascript:void(0);" lock_form="lock_customer_form"  data-id="' . encrypt($survey_set->id) . '" class="lock-survey_set-record text-primary lock-users-record" title="Finalized"><i class="fas fa-lock"></i></a>&nbsp;&nbsp;';
                            $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($survey_set->id) . '" class="delete-survey_set-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                        } else {
                            $btn .= '<a href="javascript:void(0);" lock_form="unlock_customer_form"  data-id="' . encrypt($survey_set->id) . '" class="unlock-survey_set-record text-primary unlock-users-record" title="Unlock"><i class="fas fa-unlock"></i></a>&nbsp;&nbsp;';
                        }
                        return $btn;
                    })
                    ->addColumn('status', function ($survey_set) {
                        return $survey_set->status == 1 ? 'Active' : 'Not Active';
                    })
                    ->rawColumns([
                        'action'        
                    ])
                    ->setTotalRecords($totalSurveySet)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        return view('survey_set.index');
    }

    public function create() {
        $questionnaires = Questionnaire::where('status',1)->get();

        $data = array();

        foreach($questionnaires as $questionnaire) {
            $data[] = array(
                'id' => $questionnaire->id,
                'title' => $questionnaire->title
            );
        }

        return view('survey_set.create', ['questionnaires' => $data]);
    }

    public function viewSurveySet($id){
        // $id = decrypt($id);
        
        $surveyController = new SurveyController();
        $survey_set = $surveyController->getSurveySet($id);

        if (!$survey_set) {
            abort(404);
        }

        $survey_set = json_decode($survey_set);
        $html = view('survey_set.pdf.view', ['survey' => $survey_set])->render();
        // return $html;
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'questionnaires' => 'required|array',
            'farm_categ' => 'required',
        ]);

        $questionnaires = [];

        foreach($request->questionnaires as $questionnaire) {
            array_push($questionnaires,$questionnaire);
        }

        DB::beginTransaction();
        try{
            $survey_set = new SurveySet;
            $survey_set->title = $request->title;
            $survey_set->slug = Str::slug($request->title,'-');
            $survey_set->description = $request->description;
            //$survey_set->questionnaire_data = json_encode(['questionnaire_ids' => $questionnaires]);
            $survey_set->farm_categ = $request->farm_categ;
            $survey_set->expiry_date = !empty($request->expiry_date) ? $request->expiry_date : Carbon::now()->addMonth();
            $survey_set->status = 1;
            $survey_set->save();
            $survey_set_id = $survey_set->id;

            SurveyVersion::create([
                'survey_set_id' => $survey_set_id,
                'questionnaire_data' => json_encode(['questionnaire_ids' => $questionnaires]),
                'version' => 1,
            ]);

            // SurveySet::create([
            //     'title' => $request->title,
            //     'slug' => Str::slug($request->title,'-'),
            //     'description' => $request->description,
            //     'questionnaire_data' => json_encode(['questionnaire_ids' => $questionnaires]),
            //     'farm_categ' => $request->farm_categ,
            //     'expiry_date' => !empty($request->expiry_date) ? $request->expiry_date : Carbon::now()->addMonth(),
            //     'status' => 1
            // ]);

            DB::commit();
            return redirect()->route("survey.index")->with('success', 'Survey Set created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("survey.index")->with('error', 'Unable to create Survey Set. Please try again later.');
        }
    }

    public function edit($id)
    {
        $decrypt_id = decrypt($id);

        $survey_version = SurveyVersion::where('survey_set_id',$decrypt_id)->orderBy('version','DESC')->first();

        $survey_set = SurveySet::find($decrypt_id);

        
        $data = [
            'title' => $survey_set->title,
            'description' => $survey_set->description,
            'questionnaire_data' => $survey_version ? json_decode($survey_version->questionnaire_data) : [],
            'status' => $survey_set->status,
            'farm_categ' => $survey_set->farm_categ,
            'expiry_date' => $survey_set->expiry_date
        ];
        

        $query_questionnaires = Questionnaire::get();

        $questionnaires = array();

        foreach($query_questionnaires as $questionnaire) {
            $questionnaires[] = array(
                'id' => $questionnaire->id,
                'title' => $questionnaire->title
            );
        }

        return view('survey_set.edit', ['survey_set' => $data,'questionnaires' => $questionnaires,'id' => $id]);
    }

    public function finalized(Request $request, $id){
        $id = decrypt($id);
        $survey_set = SurveySet::find($id);
        DB::beginTransaction();
        try{
            $survey_set->is_finalized = 1;
            $survey_set->save();
            DB::commit();
            return response()->json(['message' => 'Survey Set updated successfully', "statusCode" => 200], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Unable to update survey set. Please try again later.', "statusCode" => 500], 500);
        }
    }

    public function unfinalized(Request $request, $id){
        $id = decrypt($id);
        $survey_set = SurveySet::find($id);
        DB::beginTransaction();
        try{
            $survey_set->is_finalized = 0;
            $survey_set->save();
            DB::commit();
            return response()->json(['message' => 'Survey Set updated successfully', "statusCode" => 200], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Unable to update survey set. Please try again later.', "statusCode" => 500], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'questionnaires' => 'required|array',
            
            'farm_categ' => 'required'
        ]);

        $questionnaires = [];
        $decrypt_id = decrypt($id);
        $survey_set = SurveySet::find($decrypt_id);

        foreach($request->questionnaires as $questionnaire) {
            array_push($questionnaires,$questionnaire);
        }

        DB::beginTransaction();
        try{

            $survey_set->title = $request->title;
            $survey_set->slug = Str::slug($request->title,'-');
            $survey_set->description = $request->description;
            //$survey_set->questionnaire_data = json_encode(['questionnaire_ids' => $questionnaires]);
            if(!empty($request->expiry_date)) {
                $survey_set->expiry_date = $request->expiry_date;
            }
            $survey_set->farm_categ = $request->farm_categ;
            $survey_set->status = 1;
            $survey_set->save();


            $survey_version = SurveyVersion::where('survey_set_id',$decrypt_id)->orderBy('version','DESC')->first();

            $saved_questionnaire_data = $survey_version ? json_decode($survey_version->questionnaire_data) : null;

            if ($saved_questionnaire_data && is_array($saved_questionnaire_data->questionnaire_ids) && count($saved_questionnaire_data->questionnaire_ids) != count($questionnaires)) {
                SurveyVersion::create([
                    'survey_set_id' => $decrypt_id,
                    'questionnaire_data' => json_encode(['questionnaire_ids' => $questionnaires]),
                    'version' => $survey_version->version + 1,
                ]);
            }

            DB::commit();
            return redirect()->route("survey.index")->with('success', 'Survey Set updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("survey.index")->with('error', 'Unable to update survey set. Please try again later.');
        }
    }

    public function destroy($id)
    {
        $decrypt_id = decrypt($id);
        $survey_set = SurveySet::find($decrypt_id);


        if (empty($survey_set)) {
            return returnNotFoundResponse('This Survey Set does not exist');
        }

        $survey_set->is_deleted = 1;
        $hasDeleted = $survey_set->save();

        if ($hasDeleted) {
            return returnSuccessResponse('Survey Set deleted successfully');
        }

        return returnErrorResponse('Something went wrong. Please try again later');    
    }
}
