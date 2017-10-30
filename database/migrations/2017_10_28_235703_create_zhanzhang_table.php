<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZhanzhangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zhanzhang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name')->comment('发消息人');
            $table->integer('user_id')->comment('发消息人id');
            $table->text('message')->comment('发给站长的消息');
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
        Schema::dropIfExists('zhanzhang');
    }
}
