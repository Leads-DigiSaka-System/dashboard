<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDemoAndCategoryToFarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->boolean('isDemo')->default(0);
            $table->string('category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('farms', function (Blueprint $table) {
            $table->dropColumn('isDemo');
            $table->dropColumn('category');
        });
    }
}

