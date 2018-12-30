<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('name')->comment("计划任务名称");
            $table->string('desc')->nullable()->comment("任务简单描述");
            $table->text('content')->nullable()->comment("具体内容");
            $table->integer('day')->nullable()->comment("预计完成天数");
            $table->timestamp('start_time')->nullable()->comment("预计开始时间");
            $table->timestamp('end_time')->nullable()->comment("预计结束时间");
            $table->timestamp('true_start_time')->nullable()->comment("实际开始时间");
            $table->timestamp('true_end_time')->nullable()->comment("实际结束时间");
            $table->tinyInteger('importance')->default(0)->comment("重要性");
            $table->tinyInteger('status')->default(0)->comment("完成状态");
            $table->string('satisfaction')->nullable()->comment("完成满意度");
            $table->smallInteger('sub_task_num')->default(0)->comment("子任务数量");
            $table->smallInteger('sub_task_finished_num')->default(0)->comment("子任务完成数量");
            $table->smallInteger('sort')->default(0)->comment("排序");

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
        Schema::dropIfExists('plan');
    }
}
