<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterContactsTableAddContactImportIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('contacts', 'contact_import_id')) {
            Schema::table('contacts', function (Blueprint $table) {
                $table->integer('contact_import_id')->nullable()->unsigned()->after('user_id');
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
        if (Schema::hasColumn('contacts', 'contact_import_id')) {
            Schema::disableForeignKeyConstraints();
            Schema::table('contacts', function (Blueprint $table) {
                $table->dropForeign('contact_import_id');
                $table->dropColumn('contact_import_id');
            });
            Schema::enableForeignKeyConstraints();
        }
    }
}
