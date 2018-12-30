<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTaskJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_task_job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('plan_id')->default(0)->comment('plan id');
            $table->integer('plan_task_id')->default(0)->comment('plan task id');
            $table->text('content')->nullable()->comment('详细一些的工作内容，甚至可以加上链接');
            $table->string('name')->comment('简介描述的工作内容');
            $table->integer('quantization')->default(0)->comment('量化内容，比如代码行数,完成度等');
            $table->string('asses')->nullable()->comment('自我评价');
            $table->timestamp('date')->nullable()->comment('填写日期');

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
        Schema::dropIfExists('plan_task_job');
    }
}
