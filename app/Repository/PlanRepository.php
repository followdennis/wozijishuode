<?php

namespace App\Repository;


use App\Models\Plan\Plan;
use App\Models\Plan\PlanTask;
use App\Models\Plan\PlanTaskJob;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PlanRepository extends Model
{
    //计划任务 仓库
    public function getPlanList($id = 0,$query = '',$importance = 0,$page = 15){
        $user_id =  Auth::user()->id;
        $pageData = Plan::withCount(['tasks','tasks as finished_tasks_count'=>function($query){
            $query->where('status',1);//完成的数量
        }])->where('user_id',$user_id)->where(function($sub) use( $id ){
            if( $id> 0){
                $sub->where('id',$id);
            }
        })->where(function($sub) use( $query ){
            if( $query != ''){
                $sub->where('name','like','%'.$query.'%');
            }
        })->when($importance,function($query) use( $importance){
            return $query->where('importance',intval($importance));
        })->orderBy('sort','desc')->paginate();
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
    public function getPlanTaskList($id = 0 ,$plan_id = 0, $query = '', $importance = 0,$page = 15){
        $user_id =  Auth::user()->id;
        $pageData = PlanTask::withCount(['days'])
            ->where('user_id',$user_id)->where(function($sub) use( $id) {
            if( $id > 0 ){
                $sub->where('id',$id);
            }
        })->where(function($query)use($plan_id){
            if(!$plan_id){
//                $query->where('plan_id',8);
            }else{
                $query->where('plan_id',$plan_id);
            }

        })->with('days')->where(function($sub) use($query){
            if( $query != ''){
                $sub->where('name','like','%'.$query.'%');
            }
        })->when( $importance ,function($query) use ($importance){
            $query->where('importance',intval($importance));
        })
            ->orderBy('sort','desc')
            ->orderBy('importance','desc')->orderBy('sort','desc')->orderBy('status','asc')->paginate();
        //添加量化值的总数
        foreach($pageData->items() as $item){
             if( $item->days()->count()){
                 $item->quantization_sum = $item->days()->sum('quantization');
             }else {
                 $item->quantization_sum = 0;
             }
        }
        return $pageData;
    }

    /**
     *  搜索子任务（tasklist)
     * @param $params
     * @return mixed
     */
    public function queryTaskList($plan_id = 0,$query){
        $user_id =  Auth::user()->id;
        $pageData = PlanTask::withCount(['days'])
            ->select(['id','plan_id','name'])
            ->where('user_id',$user_id)
            ->when($plan_id ,function($sub) use($plan_id){
                $sub->where('plan_id',$plan_id);
            })
            ->where(function($subQuery) use ($query){
                if( trim($query) ){
                    $subQuery->where('name','like','%'.$query .'%');
                }
            })
            ->orderBy('importance','desc')->orderBy('sort','desc')->orderBy('status','asc')->paginate();

        return $pageData;
    }
    public function  addPlanTask($params){
        $params['user_id']= Auth::user()->id;
        $params['created_at'] = Carbon::now()->format('Y-m-m H:i:s');
        return PlanTask::insert($params);
    }
    public function  editPlanTask($id,$params){
        $user_id = Auth::user()->id;
        return PlanTask::where('user_id',$user_id)->where('id',$id)->update($params);
    }
    public function  delPlanTask($id){
        $user_id = Auth::user()->id;
        return PlanTask::where('user_id',$user_id)->where('id',$id)->delete();
    }

    public function  showPlanTask($plan_id){
        $user_id = Auth::user()->id;
        return PlanTask::where('user_id',$user_id)->find($plan_id);
    }
    /**
     * plan task job
     */
    public function getPlanTaskJobList($plan_id = 0,$plan_task_id = 0,$query = '',$page = 15){
        $user_id =  Auth::user()->id;
        $pageData = PlanTaskJob::with(['task' => function( $sub){
                $sub->select('id','name as task_name'); //这个地方必须查找id 才能取出值
             }])
            ->where('user_id',$user_id)
            ->when($query,function($sub) use( $query){
                $sub->where('name','like','%'.$query.'%');
            })
            ->when($plan_id,function($sub) use($plan_id){
                 $sub->where('plan_id',$plan_id);
            })
            ->when($plan_task_id,function($sub) use( $plan_task_id){
                $sub->where('plan_task_id',$plan_task_id);
            })
            ->orderBy('id','desc')->paginate($page);
        return $pageData;
    }
    public function  addPlanTaskJob($params){
        $params['user_id']= Auth::user()->id;
        return PlanTaskJob::create($params);
    }
    public function  editPlanTaskJob($id,$params){
        $user_id = Auth::user()->id;
        return PlanTaskJob::where('user_id',$user_id)->where('id',$id)->update($params);
    }
    public function  delPlanTaskJob($id){
        $user_id = Auth::user()->id;
        return PlanTaskJob::where('user_id',$user_id)->where('id',$id)->delete();
    }

    public function  showPlanTaskJob($plan_id){
        $user_id = Auth::user()->id;
        return PlanTaskJob::where('user_id',$user_id)->find($plan_id);
    }
}
