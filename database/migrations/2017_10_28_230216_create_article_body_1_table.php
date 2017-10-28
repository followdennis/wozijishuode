<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleBody1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        for($i = 1; $i< 11; $i++){
            Schema::create('article_body_'.$i, function (Blueprint $table) use($i) {
                $table->increments('id');
                $table->engine = 'InnoDB';
                $table->tinyInteger('table_id')->default($i)->comment('body表id');
                $table->integer('article_id')->default(0)->comment('文章id');
                $table->text('content')->nullable()->comment('文章内容');
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        for($i = 1; $i< 11; $i++){
            Schema::dropIfExists('article_body_'.$i);
        }
    }
}
