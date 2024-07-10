<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Questionnaire;

use Illuminate\Support\Str;
use DB;
class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Questionnaire $questionnaire)
    {
        if ($request->ajax()) {
            $questionnaires = $questionnaire->getAllQuestionnaires($request);
            $search = $request['search']['value'];

            $totalQuestionnaires = Questionnaire::count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalQuestionnaires;

            if (! empty($search)) {
                $setFilteredRecords = $questionnaire->getAllQuestionnaires($request,true);
                if(empty($setFilteredRecords))
                    $totalQuestionnaires = 0;
            }

            return datatables()
                    ->of($questionnaires)
                    ->addIndexColumn()
                   
                    ->addColumn('created_at', function ($questionnaire) {
                        return $questionnaire->created_at;
                    })
                    ->addColumn('date_revised', function ($questionnaire) {
                        return $questionnaire->updated_at;
                    })
                    ->addColumn('title', function ($questionnaire) {
                        return $questionnaire->title;
                    })
                    ->addColumn('description', function ($questionnaire) {
                        return $questionnaire->description;
                    })
                    ->addColumn('link', function ($questionnaire) {
                        return route('getQuestionnaireById', encrypt($questionnaire->id));
                    })
                    ->addColumn('action', function ($questionnaire) {
                            $btn = '';
                            $btn = '<a href="' . route('questionnaires.edit', encrypt($questionnaire->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                            $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($questionnaire->id) . '" class="delete-questionnaire-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                        return $btn;
                    })
                    ->addColumn('status', function ($questionnaire) {
                        return $questionnaire->status == 1 ? 'Active' : 'Not Active';
                    })
                    ->rawColumns([
                        'action'        
                    ])
                    ->setTotalRecords($totalQuestionnaires)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        return view('questionnaires.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::where('status',1)->get();

        $data = array();

        foreach($questions as $question) {
            $data[] = array(
                'id' => $question->id,
                'field_name' => $question->field_name,
                'required_field' => $question->required_field,
                'field_type' => $question->field_type,
                'options' => json_decode($question->sub_field_type),
            );
        }

        return view('questionnaires.create', ['questions' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:questionnaires',
            'description' => 'required|string',
            'questions' => 'required|array'
        ]);

        $questions = [];

        foreach($request->questions as $question) {
            array_push($questions,$question);
        }

        DB::beginTransaction();
        try{
            Questionnaire::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title,'-'),
                'description' => $request->description,
                'question_data' => json_encode(['question_ids' => $questions]),
                'status' => 1
            ]);

            DB::commit();
            return redirect()->route("survey.index")->with('success', 'Questionnaire created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("survey.index")->with('error', 'Unable to create questionnaire. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $decrypt_id = decrypt($id);

        $questionnaire = Questionnaire::find($decrypt_id);

        $data = [
            'title' => $questionnaire->title,
            'description' => $questionnaire->description,
            'question_data' => json_decode($questionnaire->question_data),
            'status' => $questionnaire->status
        ];

        $query_questions = Question::where('status',1)->get();

        $questions = array();

        foreach($query_questions as $question) {
            $questions[] = array(
                'id' => $question->id,
                'field_name' => $question->field_name,
                'required_field' => $question->required_field,
                'field_type' => $question->field_type,
                'options' => json_decode($question->sub_field_type),
            );
        }

        return view('questionnaires.edit', ['questionnaire' => $data,'questions' => $questions,'id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'questions' => 'required|array'
        ]);

        $questions = [];
        $decrypt_id = decrypt($id);
        $questionnaire = Questionnaire::find($decrypt_id);

        foreach($request->questions as $question) {
            array_push($questions,$question);
        }

        DB::beginTransaction();
        try{

            $questionnaire->title = $request->title;
            $questionnaire->slug = Str::slug($request->title,'-');
            $questionnaire->description = $request->description;
            $questionnaire->question_data = json_encode(['question_ids' => $questions]);
            $questionnaire->status = 1;
            $questionnaire->save();

            DB::commit();
            return redirect()->route("survey.index")->with('success', 'Questionnaire updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("survey.index")->with('error', 'Unable to update questionnaire. Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decrypt_id = decrypt($id);
        $questionnaire = Questionnaire::find($decrypt_id);


        if (empty($questionnaire)) {
            return returnNotFoundResponse('This question does not exist');
        }

        $hasDeleted = $questionnaire->delete();
        if ($hasDeleted) {
            return returnSuccessResponse('Questionnaire deleted successfully');
        }

        return returnErrorResponse('Something went wrong. Please try again later');    
    }
}
