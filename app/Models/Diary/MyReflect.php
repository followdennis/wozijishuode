<?php

namespace App\Models\Diary;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MyReflect extends Model
{
    //
    protected $table='my_reflect';
    //获取最新的数据
    public function getLatest(){
        $max_task_id = DB::table($this->table)->whereNull('deleted_at')->max('task_id');
        $reflects = self::where('task_id',$max_task_id)->whereRaw('to_days(created_at)=to_days(now())')->get();
        $result = [];
        foreach ($reflects as $k =>$v){
            $result[$v->question_id] = [
                'description'=>$v->description,
                'num'=>$v->num,
                'num_desc'=>$v->num_desc,
                'assess'=>$v->assess,
                'createdAt'=>Carbon::parse($v->createdAt)->toDateString()
            ];
        }
        return $result;
    }
}
