<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSysLogAddIsLogInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_log', function (Blueprint $table) {
            //
            $table->tinyInteger('is_login')->default(0)->after('login_address')->comment('是否登陆,1：登陆，2：退出');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_log', function (Blueprint $table) {
            //
            $table->dropColumn('is_login');
        });
    }
}
