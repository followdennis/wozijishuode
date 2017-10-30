<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGetCreateIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('get_create_id', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('cate_id')->default(0)->comment('分类id');
            $table->tinyInteger('is_show')->default(0)->comment('是否展示');
            $table->timestamps();
            $table->index(['cate_id','id']);//复合索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('get_create_id');
    }
}
