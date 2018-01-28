<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->mediumInteger('score')->default(0)->comment('积分');
            $table->tinyInteger('level')->default(0)->comment('等级');
            $table->string('thumb')->nullable()->comment('头像地址');
            $table->text('description')->nullable()->comment('简介');
            $table->mediumInteger('collection',false,true)->default(0)->comment('收藏数量');
            $table->integer('comments',false,true)->default(0)->comment('评论次数');
            $table->tinyInteger('is_forbidden')->default(0)->comment('是否禁言');
            $table->mediumInteger('like',false,true)->default(0)->comment('点赞数量');
            $table->mediumInteger('follow',false,true)->default(0)->comment('关注数量');
            $table->integer('money',false,true)->default(0)->comment('余额');
            $table->string('qr')->nullable()->comment('二维码');
            $table->string('qq',10)->nullable()->comment('qq号');
            $table->string('phone',11)->nullable()->default(0)->comment('电话号码');
            $table->string('wechat',25)->nullable()->comment('微信号码');
            $table->string('pay',50)->nullable()->comment('支付宝账号');
            $table->string('address')->nullable()->comment('地址');
            $table->tinyInteger('province')->default(0)->comment('省份编号');
            $table->mediumInteger('city')->default(0)->comment('城市编号');
            $table->tinyInteger('sex')->default(0)->comment('性别，1男2女 0 未知');
            $table->timestamp('birth_time')->nullable()->comment('出生日期');
            $table->rememberToken();
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
        Schema::dropIfExists('common_users');
    }
}
