<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_versions', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_set_id');
            $table->longText('questionnaire_data')->nullable();
            $table->integer('version');
            $table->timestamp('timestamp')->useCurrent();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_versions');
    }
}
