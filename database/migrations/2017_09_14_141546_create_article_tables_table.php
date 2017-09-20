<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20)->comment('表的名字,中文名');
            $table->string('table_name')->comment('表名字，不带前缀');
            $table->string('alias')->comment('表的别名');
            $table->tinyInteger('is_show')->comment('是否展示');
            $table->string('description',255)->nullable()->comment('表的描述');
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
        Schema::dropIfExists('article_tables');
    }
}
