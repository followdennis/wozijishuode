<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    //
    use SoftDeletes;
    protected $table = 'plan';
    protected $guarded = [];
    protected $except = ['name'];

    /**
     * plan_task 关联
     */
    public function tasks(){
        return $this->hasMany('App\Models\Plan\PlanTask','plan_id','id')->orderBy('id','desc');
    }


}
