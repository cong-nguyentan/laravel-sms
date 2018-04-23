<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsMapControllerActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('permissions_map_controller_action')) {
            Schema::create('permissions_map_controller_action', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('permission_id')->unsigned();
                $table->string('controller');
                $table->string('action');
                $table->timestamps();
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('restrict')->onUpdate('restrict');
                $table->unique(['controller', 'action']);
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
        if (Schema::hasTable('permissions_map_controller_action')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('permissions_map_controller_action');

            Schema::enableForeignKeyConstraints();
        }
    }
}
