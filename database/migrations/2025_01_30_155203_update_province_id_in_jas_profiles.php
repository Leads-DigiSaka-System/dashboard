<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Get the actual foreign key constraint name
        $constraintName = $this->getForeignKeyConstraint();

        // Drop the foreign key constraint if it exists
        if ($constraintName) {
            Schema::table('jas_profiles', function (Blueprint $table) use ($constraintName) {
                $table->dropForeign($constraintName);
            });
        }

        // Drop the column if it exists
        if (Schema::hasColumn('jas_profiles', 'province_id')) {
            Schema::table('jas_profiles', function (Blueprint $table) {
                $table->dropColumn('province_id');
            });
        }

        // Re-add the province_id column
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable()->after('location');
        });
    }

    public function down()
    {
        // Drop the column if it exists before rolling back
        if (Schema::hasColumn('jas_profiles', 'province_id')) {
            Schema::table('jas_profiles', function (Blueprint $table) {
                $table->dropColumn('province_id');
            });
        }

        // Re-add the province_id column with a foreign key (if needed)
        Schema::table('jas_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')
                  ->references('id')->on('provinces')
                  ->onDelete('cascade');
        });
    }

    private function getForeignKeyConstraint()
    {
        $databaseName = env('DB_DATABASE');
        $tableName = 'jas_profiles';
        $columnName = 'province_id';

        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $databaseName)
            ->where('TABLE_NAME', $tableName)
            ->where('COLUMN_NAME', $columnName)
            ->whereNotNull('CONSTRAINT_NAME')
            ->value('CONSTRAINT_NAME');
    }
};
