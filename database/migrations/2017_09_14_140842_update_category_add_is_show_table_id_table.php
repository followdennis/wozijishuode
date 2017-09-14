<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCategoryAddIsShowTableIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            //
            $table->tinyInteger('is_show')->default(1)->after('parent_id')->comment('是否显示分类');
            $table->smallInteger('tables_id')->default(0)->after('parent_id')->comment('关联articles_table');
            $table->string('alias')->nullable()->comment('分类的别名');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            //
            $table->dropColumn(['is_show','tables_id','alias']);
        });
    }
}
