<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShicimingjuTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shicimingju_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tags',30)->comment('标签名称')->nullable()->default('');
            $table->string('url',255)->comment('来源链接')->nullable()->default('');
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
        Schema::dropIfExists('shicimingju_tags');
    }
}
