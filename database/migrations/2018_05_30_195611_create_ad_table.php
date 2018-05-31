<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('position_id')->default(0)->comment('位置id');
            $table->tinyInteger('is_show')->default(0)->comment('是否展示 1 是 0 否');
            $table->string('description')->default('')->comment('位置描述');
            $table->string('style')->default('')->comment('样式定义');
            $table->text('content')->default('')->comment('广告代码,包含div和js');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('ad');
    }
}
