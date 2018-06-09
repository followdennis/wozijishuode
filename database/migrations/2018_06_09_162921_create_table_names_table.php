<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_names', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('project_id')->default(0)->comment('项目id');
            $table->smallInteger('requirement_id')->default(0)->comment('需求id');
            $table->string('name')->nullable()->comment('表名称');
            $table->smallInteger('sort')->default(0)->comment('排序');
            $table->string('user_id')->default(0)->comment('用户id');
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
        Schema::dropIfExists('table_names');
    }
}
