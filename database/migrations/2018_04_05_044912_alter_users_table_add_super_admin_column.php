<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddSuperAdminColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'super_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('super_admin')->default(0)->after('password');
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
        if (Schema::hasColumn('users', 'super_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('super_admin');
            });
        }
    }
}
