<?php

namespace App\Repository;


use App\Models\Plan\Plan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PlanRepository extends Model
{
    //计划任务 仓库
    public function getPlanList($page = 15){
        $user_id =  Auth::user()->id;
        $pageData = Plan::where('user_id',$user_id)->select([
            'id',
            'name',
            'desc',
            'content',
            'day',
            'start_time',
            'end_time',
            'true_start_time',
            'true_end_time',
            'importance',
            'status',
            'satisfaction',
            'sub_task_num',
            'sub_task_finished_num'
        ])->orderBy('sort','desc')->paginate();
        return $pageData;
    }
    public function  addPlan($params = []){
        $params['user_id']= Auth::user()->id;
        return Plan::insert($params);
    }
    public function  editPlan($id,$params){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->update($params);
    }
    public function  delPlan($id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->delete();
    }

    public function  showPlan($plan_id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->find($plan_id);
    }

    /**
     * plan task
     */
    public function getPlanTaskList( $page = 15){
        $user_id =  Auth::user()->id;
        $pageData = Plan::where('user_id',$user_id)->select([
            'name',
            'desc',
            'content',
            'day',
            'status',
            'is_satisfy',
            'advice',
            'importance',
            'quantization',
            'quantization_unit',
            'start_time',
            'end_time',
            'day_num',
            'true_day_num',
            'created_at',
            'updated_at'
        ])->orderBy('sort','desc')->paginate($page);
        return $pageData;
    }
    public function  addPlanTask(){
        $params['user_id']= Auth::user()->id;
        return Plan::insert($params);
    }
    public function  editPlanTask($id,$params){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->update($params);
    }
    public function  delPlanTask($id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->delete();
    }

    public function  showPlanTask($plan_id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->find($plan_id);
    }
    /**
     * plan task job
     */
    public function getPlanTaskJobList($page = 15){
        $user_id =  Auth::user()->id;
        $pageData = Plan::where('user_id',$user_id)->select([
            'name',
            'content',
            'day',
            'status',
            'quantization',
            'asses',
            'date',
            'quantization',
            'created_at',
            'updated_at'
        ])->orderBy('sort','desc')->paginate($page);
        return $pageData;
    }
    public function  addPlanTaskJob(){
        $params['user_id']= Auth::user()->id;
        return Plan::insert($params);
    }
    public function  editPlanTaskJob($id,$params){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->update($params);
    }
    public function  delPlanTaskJob($id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->where('id',$id)->delete();
    }

    public function  showPlanTaskJob($plan_id){
        $user_id = Auth::user()->id;
        return Plan::where('user_id',$user_id)->find($plan_id);
    }
}
