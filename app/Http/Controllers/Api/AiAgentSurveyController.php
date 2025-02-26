<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveySet;
use App\Models\Questionnaire;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AiAgentSurveyController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== '6fu1pldhb902m2eqg2870d1r2i') {
                    $fail('The provided client ID is invalid.');
                }
            }],
            'client_secret' => ['required', 'string', function ($attribute, $value, $fail) {
                if ($value !== '4fl5nmv0347ou93g3mcrgs2t7uqqmkhs7635g3dgt7u2hcsernf') {
                    $fail('The provided client secret is invalid.');
                }
            }],
            'survey_id' => 'nullable|integer',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:survey_set,slug',
            'description' => 'nullable|string',
            'reward_points' => 'required|integer',
            'farm_category' => 'required|integer', 
            'expiry_date' => 'nullable|date',
            'is_finalized' => 'required|integer|in:0,1',
            'questionnaires' => 'required|array',
            'questionnaires.*.questionnaire_id' => 'required|integer',
            'questionnaires.*.questionnaire_title' => 'required|string|max:255',
            'questionnaires.*.description' => 'nullable|string',
            'questionnaires.*.questions' => 'required|array',
            'questionnaires.*.questions.*.question_id' => 'required|integer',
            'questionnaires.*.questions.*.field_name' => 'required|string|max:255',
            'questionnaires.*.questions.*.field_type' => 'required|string|max:255',
            'questionnaires.*.questions.*.choices' => 'nullable|string',
            'questionnaires.*.questions.*.conditional' => 'required|integer',
            'questionnaires.*.questions.*.sub_questionnaire' => 'required|integer',
            'questionnaires.*.questions.*.is_required' => 'required|integer|in:0,1',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
        try {
            // ✅ Create or update Survey Set
            $survey = SurveySet::updateOrCreate(
                ['id' => $request->survey_id],
                [
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'description' => $request->description,
                    'reward_points' => $request->reward_points,
                    'farm_categ' => $request->farm_category,
                    'expiry_date' => $request->expiry_date,
                    'is_finalized' => $request->is_finalized,
                    'questionnaire_data' => json_encode(array_column($request->questionnaires, 'questionnaire_id')),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
    
            foreach ($request->questionnaires as $qData) {
                // ✅ Create or update Questionnaire
                $questionnaire = Questionnaire::updateOrCreate(
                    ['id' => $qData['questionnaire_id']],
                    [
                        'title' => $qData['questionnaire_title'],
                        'slug' => \Str::slug($qData['questionnaire_title']),
                        'description' => $qData['description'],
                        'question_data' => json_encode(array_column($qData['questions'], 'question_id')),
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
    
                foreach ($qData['questions'] as $questionData) {
                    // ✅ Create or update Questions
                    Question::updateOrCreate(
                        ['id' => $questionData['question_id']],
                        [
                            'field_name' => $questionData['field_name'],
                            'field_type' => $questionData['field_type'],
                            'sub_field_type' => $questionData['choices'] ?? null,
                            'conditional' => $questionData['conditional'],
                            'sub_question_id' => $questionData['sub_questionnaire'],
                            'required_field' => $questionData['is_required'],
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                            'questionnaire_id' => $questionnaire->id,
                        ]
                    );
                }
            }
    
            DB::commit();
            return response()->json(['message' => 'Survey created successfully', 'survey' => $survey], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to create survey', 'details' => $e->getMessage()], 500);
        }
    }
    
    
}
