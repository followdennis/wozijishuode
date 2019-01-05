<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTask extends Model
{
    //
    use SoftDeletes;
    protected $table = 'plan_task';
    protected $guarded = [];

    /**
     * 天数统计
     */
    public function days(){
        return $this->hasMany('App\Models\Plan\PlanTaskJob','plan_task_id','id');
    }
}
