<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->unique(); 
            $table->string('score')->nullable(); 
            $table->text('description')->nullable(); 
            $table->json('image')->nullable(); 
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
            $table->string('create_by'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diseases');
    }
}
