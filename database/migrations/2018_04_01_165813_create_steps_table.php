<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content')->comment('主要的修改记录');
            $table->tinyInteger('is_show')->default(0)->comment('是否展示到更新列表');
            $table->tinyInteger('type')->default(0)->comment('0:项目更新日志，1:大步骤，2:小步骤');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->tinyInteger('level')->default(0)->comment('重要性,满分为10为宜');
            $table->tinyInteger('is_finish')->default(0)->comment('是否处理');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
