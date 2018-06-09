<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('project_id')->default(0)->comment('项目id');
            $table->smallInteger('module_id')->default(0)->comment('需求模块id');
            $table->string('name',255)->nullable()->comment('模块功能名称名称');
            $table->text('description')->comment('需求/进展描述');
            $table->text('content')->comment('需求/进展内容');
            $table->tinyInteger('type')->default(0)->comment('类型0:需求 1:进展');
            $table->tinyInteger('user_id')->default(0)->comment('创建人');
            $table->timestamp('start_time')->nullable()->comemnt('需求/进度开始时间');
            $table->timestamp('end_time')->nullable()->comment('需求结束时间');
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
        Schema::dropIfExists('requirements');
    }
}
