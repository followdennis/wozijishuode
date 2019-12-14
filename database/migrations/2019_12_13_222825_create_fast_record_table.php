<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFastRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 快速记录生活重的一些想法和感悟
        Schema::create('fast_record', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->default('')->comment('记录类型');
            $table->string('desc')->nullable()->comment('描述');
            $table->text('content')->nullable()->comment('正文内容');
            $table->tinyInteger('week')->default(0)->comment('周');
            $table->mediumInteger('sort')->default(0)->comment('排序值');
            $table->tinyInteger('is_show')->default(1)->comment('是否展示，默认1');
            $table->tinyInteger('is_finish')->default(0)->comment('是否完成');
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
        Schema::dropIfExists('fast_record');
    }
}
