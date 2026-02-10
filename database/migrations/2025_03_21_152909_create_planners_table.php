<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planners', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_time');
            $table->string('type');
            $table->string('title');
            $table->string('description');
            $table->string('location');
            $table->string('region');
            $table->string('province');
            $table->string('municipality');
            $table->string('barangay');
            $table->boolean('isDone')->default(false);
            $table->string('color');
            $table->json('viewableBy');
            $table->json('images');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planners');
    }
}
