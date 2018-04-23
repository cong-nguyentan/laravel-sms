<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupContactRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('group_contact_relations')) {
            Schema::create('group_contact_relations', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('group_id')->unsigned();
                $table->integer('contact_id')->unsigned();
                $table->foreign('group_id')->references('id')->on('group_contacts')->onDelete('restrict')->onUpdate('restrict');
                $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('restrict')->onUpdate('restrict');
                $table->unique(['group_id', 'contact_id']);
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
        if (Schema::hasTable('group_contact_relations')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('group_contact_relations');

            Schema::enableForeignKeyConstraints();
        }
    }
}
