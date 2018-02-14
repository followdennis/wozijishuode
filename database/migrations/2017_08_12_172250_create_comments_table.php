<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned()->default(0)->comment('文章id');
            $table->smallInteger('user_id')->unsigned()->default(0)->comment('用户id');
            $table->string('user_name',20)->unsigned()->default(0)->comment('用户名称');
            $table->text('comment')->comment('评论内容');
            $table->smallInteger('like')->unsigned()->default(0)->comment('赞');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父id');
            $table->tinyInteger('is_hidden')->default(0)->comment('是否屏蔽');
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
        Schema::dropIfExists('comments');
    }
}
