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
                        $sub_field_type = json_decode($question->sub_field_type);
                        $choices = $sub_field_type->choices;

                        
                        $arr = !empty($choices) ? implode(", ", $choices) : $question->field_type;
                        return $arr;
                    })
                    ->addColumn('action', function ($question) {
                            $btn = '';
                            $btn = '<a href="' . route('questions.edit', encrypt($question->id)) . '" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;';
                            $btn .= '<a href="javascript:void(0);" delete_form="delete_customer_form"  data-id="' . encrypt($question->id) . '" class="delete-datatable-record text-danger delete-users-record" title="Delete"><i class="fas fa-trash"></i></a>';
                        return $btn;
                    })
                    ->addColumn('status', function ($question) {
                        return $question->status == 1 ? 'Active' : 'Not Active';
                    })
                    ->rawColumns([
                        'action'        
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
        if($request->field_type == 'Date Picker' || $request->field_type == 'Image') {
            $validated = $request->validate([
                'field_name' => 'required|string',
                'field_type' => 'required|string'
            ]);

        } else {
            $validated = $request->validate([
                'field_name' => 'required|string',
                'field_type' => 'required|string',
                'sub_field_type' => 'required|array'
            ]);

        }
        DB::beginTransaction();
        try{
            Question::create([
                'field_name' => $request->field_name,
                'field_type' => $request->field_type,
                'required_field' => $request->required_field == 'on' ? 1 : 0,
                'sub_field_type' => json_encode(['choices' => empty($request->sub_field_type) ?"" : $request->sub_field_type]),
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
        $id = decrypt($id);

        $question = Question::find($id);

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

        $question = Question::find($decrypt_id);

        $data = [
            'field_name' => $question->field_name,
            'required_field' => $question->required_field,
            'field_type' => $question->field_type,
            'sub_field_type' => json_decode($question->sub_field_type)
        ];

        return view('questions.edit', ['question' => $data,'id' => $id]);
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
            'field_name' => 'required|string',
            'field_type' => 'required|string',
            'sub_field_type' => 'required|array'
        ]);

        $decrypt_id = decrypt($id);
        $question = Question::find($decrypt_id);

        DB::beginTransaction();
        try{

            $question->field_name = $request->field_name;
            $question->field_type = $request->field_type;
            $question->required_field = $request->required_field == 'on' ? 1 : 0;
            $question->sub_field_type = json_encode(['choices' => $request->sub_field_type]);
            $question->status = 1;
            $question->save();


            DB::commit();
            return redirect()->route("questions.index")->with('success', 'Question updated successfully.');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route("questions.index")->with('error', 'Unable to update question. Please try again later.');
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
        $question = Question::find($decrypt_id);


        if (empty($question)) {
            return returnNotFoundResponse('This question does not exist');
        }

        $hasDeleted = $question->delete();
        if ($hasDeleted) {
            return returnSuccessResponse('Question deleted successfully');
        }

        return returnErrorResponse('Something went wrong. Please try again later');
    }
}
