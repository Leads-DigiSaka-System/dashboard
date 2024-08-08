<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonitoringIdToJasMonitoringDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jas_monitoring_data', function (Blueprint $table) {
            $table->integer('monitoring_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jas_monitoring_data', function (Blueprint $table) {
            $table->dropColumn('monitoring_id');
        });
    }
}
