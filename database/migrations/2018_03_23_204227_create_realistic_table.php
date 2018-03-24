<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealisticTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   //统计总计的点击量和各个分类的点击量
        Schema::create('click_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('today')->nullable()->comment('记录今天的日期');
            $table->integer('total',false,true)->default(0)->comment('总的点击量');
            for($i = 1; $i<= 50;$i++){
                $table->integer('cate_'.$i,false,true)->default(0)->comment('各个分类对应的点击量');
            }
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
        Schema::dropIfExists('click_statistics');
    }
}
