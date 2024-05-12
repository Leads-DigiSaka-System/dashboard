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
    public function index()
    {
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
                'id' => encrypt($question->id),
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
            'title' => 'required|string',
            'description' => 'required|string',
            'questions' => 'required|array'
        ]);

        $questions = [];

        foreach($request->questions as $question) {
            array_push($questions, decrypt($question));
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
            return redirect()->route("questionnaires.index")->with('success', 'Questionnaire created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("questionnaires.index")->with('error', 'Unable to create questionnaire. Please try again later.');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
