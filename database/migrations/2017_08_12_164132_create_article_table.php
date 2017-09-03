<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->comment('文章标题');
            $table->string('author',20)->nullable()->comment('作者');
            $table->smallInteger('author_id')->unsigned()->nullable()->comment('作者id');
            $table->string('description',255)->nullable()->comment('文章描述');
            $table->text('content')->comment('文章内容');
            $table->string('tags',20)->nullable()->comment('标签');
            $table->string('img',255)->comment('图片路径')->nullable();
            $table->string('cate_name',20)->nullable()->comment('分类名');
            $table->smallInteger('cate_id')->unsigned()->nullable()->comment('分类id');
            $table->smallInteger('click')->unsigneg()->default(0)->comment('点击次数');
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
        Schema::dropIfExists('article');
    }
}
