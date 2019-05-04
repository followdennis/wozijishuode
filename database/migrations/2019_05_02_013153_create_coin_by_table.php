<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinByTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //虚拟币买入表
        Schema::create('coin_buy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->default(0)->comment("用户id");
            //币种
            $table->tinyInteger("coin_type")->default(0)->comment("虚拟币种类");
            //数量
            $table->float('count',10,2)->default(0)->comment('买入数量,可以是两位小数');
            //总额
            $table->float('total_money',10,4)->default(0)->comment('购买总额');
            //单价，一个虚拟币的购买价格
            $table->float('unit_price',10,4)->default(0)->comment('购买单价');
            //市场价
            $table->float('market_price',10,4)->default(0)->comment('市场价');
            //买入时间
            $table->timestamp('buy_time')->nullable()->comment('买入时间');
            //可售数量
            $table->float('left_count',10,2)->default(0)->comment('可售数量');
            //卖出数量，卖出总额，卖出平均价格，差价，卖出利润率，卖出总利润，等，通过计算获得

            $table->string("remark")->nullable()->comment("小记");
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
        Schema::dropIfExists('coin_buy');
    }
}
