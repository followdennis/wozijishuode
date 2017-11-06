<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name',50)->comment('分类名称');
            $table->string('pinyin',100)->nullable()->comment('拼音:全拼');
            $table->string('py',100)->nullable()->comment('拼音:简拼');
            $table->smallInteger('parent_id')->unsigned()->default(0);
            $table->string('description',255)->nullable()->comment('描述');
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
        Schema::dropIfExists('category');
    }
}
