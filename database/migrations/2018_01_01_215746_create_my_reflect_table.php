<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyReflectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_reflect', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable()->comment('情况的解释，或是此时的想法');
            $table->integer('num',false,true)->default(0)->comment('可以是时间，以秒计算,或者是分数满分10分计,或者代码行数');
            $table->string('num_desc',128)->nullable()->comment('对数字的适当说明，可不填写');
            $table->tinyInteger('assess')->default(0)->comment('评估，1：是 2：否 3：不确定 0 没操作');
            $table->smallInteger('task_id',false,true)->default(0)->comment('任务id，统计某一天的数据');
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
        Schema::dropIfExists('my_reflect');
    }
}
