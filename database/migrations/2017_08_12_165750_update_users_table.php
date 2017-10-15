<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('nickname',30)->nullable()->after('name')->comment('昵称');
            $table->tinyInteger('sex')->default(0)->after('name')->comment('性别,1:男，2：女，0默认未知');
            $table->string('address',255)->nullable()->default('')->after('name')->comment('地址');
            $table->string('phone',13)->nullable()->after('name')->comment('电话');
            $table->string('qq',12)->nullable()->after('name')->comment('qq');
            $table->string('img',255)->nullable()->after('name')->comment('头像地址,非缩略图');
            $table->string('thumb',255)->nullable()->after('name')->comment('头像缩略图');
            $table->text('description')->nullable()->after('name')->comment('自我介绍');
            $table->string('ip')->nullable()->comment('登陆的ip');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('nickname');
            $table->dropColumn('sex');
            $table->dropColumn('address');
            $table->dropColumn('phone');
            $table->dropColumn('qq');
            $table->dropColumn('img');
            $table->dropColumn('thumb');
            $table->dropColumn('description');
            $table->dropColumn('ip');


        });
    }
}
