<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //币种名称
        Schema::create('coin_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string("coin_name")->comment("币种名称");
            $table->integer("sort")->default(0)->comment("排序值,由大到小");
            $table->string("alias")->nullable()->comment("别名");
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
        Schema::dropIfExists('coin_type');
    }
}
