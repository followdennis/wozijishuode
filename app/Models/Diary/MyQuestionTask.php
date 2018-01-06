<?php

namespace App\Models\Diary;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MyQuestionTask extends Model
{
    //
    protected $table = 'my_question_task';
    protected $guarded=[];
    protected $primaryKey = 'task_id';

    public function getList(){
        $user_id = Auth::user()->id;
        return self::where('user_id',$user_id)->orderBy('task_id','desc')->get()->map(function($item){
            $week = Carbon::parse($item->today)->dayOfWeek;
            $week = $this->getWeek($week);
            $date = Carbon::parse($item->today)->toDateString();
            return ['taskId'=>$item->task_id,'today'=>$date."\t".$week];
        });
    }
    public function getWeek($num = 0){
        switch($num){
            case 1 :$week = '星期一';
            break;
            case 2 :$week = '星期二';
                break;
            case 3 :$week = '星期三';
                break;
            case 4 :$week = '星期四';
                break;
            case 5 :$week = '星期五';
                break;
            case 6 :$week = '星期六';
                break;
            case 0 :$week = '星期日';
                break;
            default:$week = '星期日';
        }
        return $week;
    }
}
