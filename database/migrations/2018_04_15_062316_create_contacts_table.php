<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('name');
                $table->string('phone', 20);
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
                $table->unique(['user_id', 'phone']);
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
        if (Schema::hasTable('contacts')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('contacts');

            Schema::enableForeignKeyConstraints();
        }
    }
}
