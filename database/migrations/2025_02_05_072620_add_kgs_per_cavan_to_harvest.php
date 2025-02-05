<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('harvest', function (Blueprint $table) {
            $table->integer('kgs_per_cavan');
        });
    }

    public function down()
    {
        Schema::table('harvest', function (Blueprint $table) {
            $table->dropColumn('kgs_per_cavan');
        });
    }
};
