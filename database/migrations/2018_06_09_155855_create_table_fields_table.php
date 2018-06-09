<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('project_id')->default(0)->comment('项目id');
            $table->smallInteger('requirement_id')->default(0)->comment('需求id');
            $table->smallInteger('table_name_id')->default(0)->comment('表名称id');
            $table->string('field_name')->comment('字段名称');
            $table->smallInteger('user_id')->default(0)->comment('创建人id');
            $table->smallInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('table_fields');
    }
}
