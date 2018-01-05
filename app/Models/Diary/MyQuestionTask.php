<?php

namespace App\Models\Diary;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MyQuestionTask extends Model
{
    //
    protected $table = 'my_question_task';
    protected $guarded=[];
    protected $primaryKey = 'task_id';

    public function getList(){
        return self::get()->map(function($item){
            return ['taskId'=>$item->task_id,'today'=>Carbon::parse($item->today)->toDateString()];
        });
    }
}
