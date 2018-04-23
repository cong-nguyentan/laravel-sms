<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterRolesTableAddWeightColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('roles', 'weight')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->tinyInteger('weight')->default(1)->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('roles', 'weight')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->dropColumn('weight');
            });
        }
    }
}
