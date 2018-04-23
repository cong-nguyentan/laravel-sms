<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPermissionsMapControllerActionTableAddShowInMenuColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('permissions_map_controller_action', 'show_in_menu')) {
            Schema::table('permissions_map_controller_action', function (Blueprint $table) {
                $table->tinyInteger('show_in_menu')->default(-1)->after('action');
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
        if (Schema::hasColumn('permissions_map_controller_action', 'show_in_menu')) {
            Schema::table('permissions_map_controller_action', function (Blueprint $table) {
                $table->dropColumn('show_in_menu');
            });
        }
    }
}
