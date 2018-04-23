<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPermissionsMapControllerActionTableAddDefineMenuFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('permissions_map_controller_action', 'parent_id')) {
            Schema::table('permissions_map_controller_action', function (Blueprint $table) {
                $table->integer('parent_id')->unsigned()->nullable()->after('permission_id');
                $table->integer('menu_order')->default(1)->unsigned()->after('action');
                $table->foreign('parent_id')->references('id')->on('permissions_map_controller_action')->onDelete('restrict')->onUpdate('restrict');
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
        if (Schema::hasColumn('permissions_map_controller_action', 'parent_id')) {
            Schema::table('permissions_map_controller_action', function (Blueprint $table) {
                Schema::disableForeignKeyConstraints();

                $table->dropColumn('parent_id');
                $table->dropColumn('menu_order');

                Schema::enableForeignKeyConstraints();
            });
        }
    }
}
