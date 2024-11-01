<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyVersion extends Model
{
    use HasFactory;

    protected $table = 'survey_versions';

    protected $fillable = [
        'survey_set_id',
        'version',
        'questionnaire_data'
    ];

    public $timestamps = false;
}
