<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('week')->nullable()->comment('每周的开始');
            $table->tinyInteger('is_exists')->default(0)->comment('库中是否有对应文章,0:无,1有');
            $table->string('keywords')->comment('搜索词');
            $table->tinyInteger('is_show')->default(1)->comment('是否在前台展示');
            $table->integer('click',false,true)->default(0)->comment('点击量');
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
        Schema::dropIfExists('search_keywords');
    }
}
