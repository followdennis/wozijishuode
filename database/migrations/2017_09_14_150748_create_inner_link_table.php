<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnerLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inner_link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->comment('内链名字');
            $table->integer('article_id')->comment('文章id');
            $table->tinyInteger('tables_id')->comment('数据表的id');
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
        Schema::dropIfExists('inner_link');
    }
}
