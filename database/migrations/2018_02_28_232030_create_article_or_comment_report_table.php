<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleOrCommentReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_or_comment_report', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('举报类型 1：文章举报 2：评论举报,3：给站长的留言');
            $table->integer('article_id')->default(0)->comment('被举报文章id');
            $table->integer('comment_id')->default(0)->comment('被举报评论id');
            $table->string('description')->comment('举报描述');
            $table->integer('user_id')->default(0)->comment('举报人id');
            $table->string('user_name',30)->nullable()->comment('举报人姓名');
            $table->mediumInteger('process_user_id')->default(0)->comment('处理人id');
            $table->string('process_user_name',30)->nullable()->comment('处理人姓名');
            $table->timestamp('process_time')->nullable()->comment('处理时间');
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
        Schema::dropIfExists('article_or_comment_report');
    }
}
