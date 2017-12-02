<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('author', function (Blueprint $table) {
            $table->increments('id');
            $table->engine = "InnoDB";
            $table->string('name',50)->comment('作者名字');
            $table->string('pinyin',150)->nullable()->comment('作者拼音');
            $table->string('py',25)->nullable()->comment('作者名字简拼');
            $table->text('description')->nullable()->comment('简介');
            $table->tinyInteger('is_show')->deafult(0)->comment('是否显示');
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
        Schema::dropIfExists('author');
    }
}
