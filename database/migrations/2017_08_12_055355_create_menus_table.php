<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30)->comment('菜单名称');
            $table->string('url',100)->nullable()->comment('路由');
            $table->string('pinyin',50)->nullable()->comment('拼音：全拼');
            $table->string('py',25)->nullable()->comment('拼音:简拼');
            $table->string('description',255)->nullable();
            $table->smallInteger('sort')->default(0)->comment('排序值');
            $table->smallInteger('parent_id')->detault(0)->comment('父id');
            $table->tinyInteger('is_show')->default(1)->show('是否展示，1：展示,0:不展示');
            $table->string('unique_code',36)->nullable();
            $table->smallInteger('permission_id')->default(0)->comment('授权id');
            $table->string('route_params',100)->nullable()->comment('路由变量');
            $table->string('icon',30)->nullable()->comment('小图标');
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
        Schema::dropIfExists('menus');
    }
}
