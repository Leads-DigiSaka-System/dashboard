<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJasProfileTableAddProvinceId extends Migration
{
    public function up()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->integer('province_id')->nullable()->after('location'); 
            $table->foreign('province_id')
                ->references('id')->on('provinces')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->dropForeign(['province_id']); 
            $table->dropColumn('province_id'); 
        });
    }
}
