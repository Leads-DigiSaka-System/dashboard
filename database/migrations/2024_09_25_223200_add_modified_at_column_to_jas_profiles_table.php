<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModifiedAtColumnToJasProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jas_profiles', function (Blueprint $table) {
            // Add 'modified_at' column
            $table->timestamp('modified_at')
                ->nullable()
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->onUpdate(DB::raw('CURRENT_TIMESTAMP'))
                ->after('address'); // Adjust based on column order
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
            // Drop the 'modified_at' column
            $table->dropColumn('modified_at');
        });
    }
}
