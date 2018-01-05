<?php

namespace App\Models\Diary;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyReflect extends Model
{
    //
    protected $table='my_reflect';
    protected $guarded = [];
    //获取最新的数据
    public function getLatest($task_id = 0){
        if($task_id>0){
            $reflects = self::where('task_id',$task_id)->get();
        }else{
            $today = Carbon::today()->toDateTimeString();
            $max_task_id = DB::table('my_question_task')->where('today',$today)->max('task_id');
            $reflects = self::where('task_id',$max_task_id)->whereRaw('to_days(created_at)=to_days(now())')->get();
        }

        $result = [];
        foreach ($reflects as $k =>$v){
            $result[$v->question_id] = [
                'description'=>$v->description,
                'num'=>$v->num,
                'num_desc'=>$v->num_desc,
                'assess'=>$v->assess,
                'task_id'=>$v->task_id,
                'created_at'=>Carbon::parse($v->created_at)->toDateString()
            ];
        }
        return $result;
    }
    //添加或编辑今日任务
    public function updateData($condition =[],$create = []){
        return self::updateOrCreate($condition,$create);
    }
}
