<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleUserLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_user_like', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->default(0)->comment('文章id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('user_name',20)->nullable()->comment('用户名');
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
        Schema::dropIfExists('article_user_like');
    }
}
