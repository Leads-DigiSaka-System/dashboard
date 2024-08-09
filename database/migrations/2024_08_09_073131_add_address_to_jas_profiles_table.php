<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressToJasProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->string('address')->nullable(); // You can adjust the type and options as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
}
