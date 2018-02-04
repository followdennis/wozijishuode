<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('标签名字');
            $table->string('pinyin',40)->nullable()->comment('标签拼音');
            $table->string('py',10)->nullable()->comment('标签简拼');
            $table->string('tables_id',10)->comment('数据表的id,可以有多个表');
            $table->string('description',255)->nullable()->comment('描述');
            $table->tinyInteger('click')->default(0)->comment('点击次数');
            $table->tinyInteger('article_count')->default(0)->comment('对应的文章数量');
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
        Schema::dropIfExists('tags');
    }
}
