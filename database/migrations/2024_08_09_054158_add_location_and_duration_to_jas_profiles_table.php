<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationAndDurationToJasProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('jas_profiles', 'location')) {
                $table->text('location')->nullable()->default(null);
            }
            
            if (!Schema::hasColumn('jas_profiles', 'duration')) {
                $table->text('duration')->nullable()->default(null);
            }
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
            if (Schema::hasColumn('jas_profiles', 'location')) {
                $table->dropColumn('location');
            }

            if (Schema::hasColumn('jas_profiles', 'duration')) {
                $table->dropColumn('duration');
            }
        });
    }
}

