<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFriendLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friend_link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('网站名称');
            $table->string('link_url',255)->comment('网站地址');
            $table->string('description',255)->nullable()->comment('站点描述');
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
        Schema::dropIfExists('friend_link');
    }
}
