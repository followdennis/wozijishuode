<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('plan_id')->default(0)->comment('计划任务id');
            $table->string('name')->comment('子任务名称');
            $table->string('desc')->nullable()->comment('子任务描述');
            $table->text('content')->nullable()->comment('子任务具体内容');
            $table->tinyInteger('status')->default(0)->comment('子任务完成状态');
            $table->tinyInteger('is_satisfy')->default(0)->comment('是否满意，是否符合预期');
            $table->string('advice')->nullable()->comment('改进建议');
            $table->tinyInteger('importance')->default(0)->comment('重要性');
            $table->integer('quantization')->default(0)->comment('量化值');
            $table->string('quantization_unit')->nullable()->comment('如 代码行数');
            $table->timestamp('start_time')->nullable()->comment('开始时间');
            $table->timestamp('end_time')->nullable()->comment('结束时间');
            $table->integer('day_num')->default(0)->comment('天数');
            $table->integer('true_day_num')->default(0)->comment('实际天数');
            $table->integer('sort')->default(0)->comment('排序');

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
        Schema::dropIfExists('plan_task');
    }
}
