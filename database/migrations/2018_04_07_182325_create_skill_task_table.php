<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_task', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->comment('技能名称');
            $table->string('description',255)->nullable()->comment('技能简介');
            $table->text('content')->nullable()->comment('技能简介');
            $table->float('estimate_time',7,1)->nullable()->default(0)->comment('预估时间');//
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('end_time')->nullable()->comment('结束时间');
            $table->float('true_time',7,1)->nullable()->comment('实际时间（h）');//浮点部分需要注意
            $table->tinyInteger('is_finish')->default(0)->comment('是否完成');
            $table->tinyInteger('assess_value')->default(0)->comment('评估价值');
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
        Schema::dropIfExists('skill_task');
    }
}
