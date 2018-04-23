<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contact_imports')) {
            Schema::create('contact_imports', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->string('import_file_name');
                $table->string('store_file_name');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
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
        if (Schema::hasTable('contact_imports')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('contact_imports');

            Schema::enableForeignKeyConstraints();
        }
    }
}
