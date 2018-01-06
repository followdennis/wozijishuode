<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyQuestionTaskIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_question_task', function (Blueprint $table) {
            $table->increments('task_id');
            $table->integer('user_id',false,true)->default(0)->comment('用户id');
            $table->timestamp('today')->comment('今天的0点时间');
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
        Schema::dropIfExists('my_question_task');
    }
}
