<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinSoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_sold', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id")->default(0)->comment("用户id");
            $table->integer("coin_buy_id")->default(0)->comment("关联买入表id");
            //卖出数量
            $table->float('count',10,2)->default(0)->comment('卖出数量');
            $table->float('sold_money',10,4)->default(0)->comment('卖出总额');
            $table->float('sold_price',10,4)->default(0)->comment('卖出单价');
            $table->float('price_diff',10,4)->default(0)->comment('差价');
            $table->float('profit_margin',7,4)->default(0)->comment('利润率');
            $table->float('gross_profit',7,4)->default(0)->comment('总利润');
            $table->timestamp("sold_time")->nullable()->comment("卖出时间");
            $table->string("remark")->nullable()->comment("小记录");
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
        Schema::dropIfExists('coin_sold');
    }
}
