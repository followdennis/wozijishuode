<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTaskJob extends Model
{
    //
    use SoftDeletes;
    protected $table = 'plan_task_job';

    protected $guarded = [];

    /**
     * 所属的父级子任务
     */
    public function task(){
        return $this->belongsTo('App\Models\Plan\PlanTask','plan_task_id','id')
//            ->select('id',' as task_name')
            ->withDefault([
                'id'=>0,
                'task_name'=> '无父级任务'
            ]);
    }
}
