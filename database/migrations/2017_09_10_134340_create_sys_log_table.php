<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSysLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_log', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_type')->default(0)->comment('用户类型 0:管理员,1:普通用户');
            $table->integer('user_id')->comment('用户id');
            $table->string('user_name',20)->comment('用户名字');
            $table->string('login_ip',15)->comment('登陆ip');
            $table->string('login_address',30)->default('')->comment('登陆ip所对应的地址');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_log');
    }
}
