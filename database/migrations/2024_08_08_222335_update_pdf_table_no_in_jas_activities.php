<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdatePdfTableNoInJasActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update pdf_table_no to 2 for activity_id between 1 and 5
        DB::table('jas_activities')
            ->whereBetween('activity_id', [1, 5])
            ->update(['pdf_table_no' => 2]);

        // Update pdf_table_no to 1 for activity_id between 6 and 10
        DB::table('jas_activities')
            ->whereBetween('activity_id', [6, 10])
            ->update(['pdf_table_no' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, revert the changes if needed
        DB::table('jas_activities')
            ->whereBetween('activity_id', [1, 5])
            ->update(['pdf_table_no' => null]);

        DB::table('jas_activities')
            ->whereBetween('activity_id', [6, 10])
            ->update(['pdf_table_no' => null]);
    }
}
