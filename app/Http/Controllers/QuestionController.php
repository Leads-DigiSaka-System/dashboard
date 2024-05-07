<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use Validator, DB;
class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Question $question)
    {
        if ($request->ajax()) {
            $questions = $question->getAllQuestions($request);
            $search = $request['search']['value'];

            $totalQuestions = Question::count();
            $search = $request['search']['value'];
            $setFilteredRecords = $totalQuestions;

            if (! empty($search)) {
                $setFilteredRecords = $question->getAllQuestions($request,true);
                if(empty($setFilteredRecords))
                    $totalQuestions = 0;
            }

            return datatables()
                    ->of($questions)
                    ->addIndexColumn()
                   
                    ->addColumn('created_at', function ($question) {
                        return $question->created_at;
                    })
                    ->addColumn('field_name', function ($question) {
                        return $question->field_name;
                    })
                    ->addColumn('field_type', function ($question) {
                        return $question->field_type;
                    })
                    ->addColumn('sub_field_type', function ($question) {
                        return $question->sub_field_type;
                    })
                    ->addColumn('action', function ($question) {
                            $btn = '';
                            $btn = '<a href="' . route('farms.show', encrypt($question->id)) . '" title="View"><i class="fas fa-eye"></i></a>&nbsp;&nbsp;';
                        return $btn;
                    })
                    ->rawColumns([
                        'action',
                        'status'        
                    ])
                    ->setTotalRecords($totalQuestions)
                    ->setFilteredRecords($setFilteredRecords)
                    ->skipPaging()
                    ->make(true);
        }

        return view('questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
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
            'field_name' => 'required|string',
            'field_type' => 'required|string',
            'sub_field_type' => 'required|array'
        ]);

        DB::beginTransaction();
        try{
            Question::create([
                'field_name' => $request->field_name,
                'field_type' => $request->field_type,
                'sub_field_type' => json_encode(['choices' => $request->sub_field_type]),
                'status' => 1
            ]);

            DB::commit();
            return redirect()->route("questions.index")->with('success', 'Question created successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("questions.index")->with('error', 'Unable to create question. Please try again later.');
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
