<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i = 1; $i< 11 ; $i++){
            Schema::create('article_head_'.$i, function (Blueprint $table) use($i){
                $table->increments('id');
                $table->tinyInteger('table_head_id')->default($i)->comment('head table 的id');
                $table->string('title',255)->comment('文章标题');
                $table->string('author',20)->nullable()->comment('作者');
                $table->smallInteger('author_id')->unsigned()->nullable()->comment('作者id');
                $table->string('description',255)->nullable()->comment('文章描述');
                $table->string('tags_name',40)->nullable()->comment('标签,可以是多标签');
                $table->string('tags_id',20)->nullable()->comment('可以多标签id');
                $table->string('inner_link_name',10)->nullable()->comment('内部链接，是唯一的');
                $table->mediumInteger('inner_link_id')->default(0)->comment('与内链对应的id');
                $table->string('img',255)->comment('图片路径')->nullable();
                $table->string('cate_name',20)->nullable()->comment('分类名');
                $table->tinyInteger('is_show')->default(0)->comment('是否展示');
                $table->timestamp('post_time')->nullable()->comment('发布时间');
                $table->tinyInteger('type')->default(0)->comment('文章类型，用于手机微信的标记');
                $table->smallInteger('cate_id')->unsigned()->nullable()->default(0)->comment('分类id');
                $table->smallInteger('click')->unsigneg()->default(0)->comment('点击次数');
                $table->smallInteger('like')->unsigned()->default(0)->comment('赞');
                $table->tinyInteger('recommend')->default(0)->comment('推荐,0,默认 1 推荐');
                $table->integer('comments_count')->default(0)->comment('评论次数');
                $table->softDeletes();
                $table->timestamps();
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
        for($i = 1; $i< 6; $i++){
            Schema::dropIfExists('article_head_'.$i);
        }
    }
}
