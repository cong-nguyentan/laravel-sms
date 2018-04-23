<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPermissionsTableAddGroupPermissionsFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('permissions', 'group_master')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->integer('group_master')->unsigned()->nullable()->after('name');
                $table->integer('group_order')->default(1)->unsigned()->after('group_master');
                $table->foreign('group_master')->references('id')->on('permissions')->onDelete('restrict')->onUpdate('restrict');
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
        if (Schema::hasColumn('permissions', 'group_master')) {
            Schema::table('permissions', function (Blueprint $table) {
                Schema::disableForeignKeyConstraints();

                $table->dropForeign(['group_master']);
                $table->dropColumn('group_master');
                $table->dropColumn('group_order');

                Schema::enableForeignKeyConstraints();
            });
        }
    }
}
