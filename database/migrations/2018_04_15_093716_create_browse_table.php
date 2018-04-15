<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrowseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('browse', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_login')->default(0)->comment('是否登陆 0:未登陆 1:一登陆');
            $table->integer('user_id')->default(0)->comment('用户id,未登陆时为0');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->string('ip',20)->nullable()->comment('ip');
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
        Schema::dropIfExists('browse');
    }
}
