<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToJasMonitoringData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jas_monitoring_data', function (Blueprint $table) {
            $table->string('image1')->nullable()->default(null);
            $table->string('image2')->nullable()->default(null);
            $table->string('image3')->nullable()->default(null);
            $table->string('image4')->nullable()->default(null);
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
            $table->dropColumn(['image1', 'image2', 'image3', 'image4']);
        });
    }
}

