<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactImportDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contact_import_details')) {
            Schema::create('contact_import_details', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('contact_import_id')->unsigned();
                $table->text('detail');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                $table->foreign('contact_import_id')->references('id')->on('contact_imports')->onDelete('restrict')->onUpdate('restrict');
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
        if (Schema::hasTable('contact_import_details')) {
            Schema::disableForeignKeyConstraints();

            Schema::drop('contact_import_details');

            Schema::enableForeignKeyConstraints();
        }
    }
}
