<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harvest', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            // Create columns
            $table->id(); 
            $table->integer('jasprofile_id'); 
            $table->string('variety', 255);
            $table->string('seeding_rate', 255);
            $table->date('planting_date');
            $table->date('harvesting_date');
            $table->string('farm_location', 255);
            $table->string('farm_size', 255);
            $table->string('method_harvesting', 255);
            $table->integer('number_of_canvas');
            $table->integer('total_yield_weight_kg');
            $table->integer('total_yield_weight_tons');
            $table->string('validator', 255);
            $table->string('validator_signature'); 
            $table->timestamps();

            $table->foreign('jasprofile_id')
                  ->references('id')
                  ->on('jas_profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table if it exists
        Schema::dropIfExists('harvest');
    }
}
