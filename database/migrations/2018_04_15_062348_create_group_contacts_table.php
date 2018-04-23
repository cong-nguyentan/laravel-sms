<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('group_contacts')) {
            Schema::create('group_contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('name');
                $table->text('description');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
                $table->unique(['user_id', 'name']);
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
        if (Schema::hasTable('group_contacts')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('group_contacts');

            Schema::enableForeignKeyConstraints();
        }
    }
}
