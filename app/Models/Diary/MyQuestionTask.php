<?php

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;

class MyQuestionTask extends Model
{
    //
    protected $table = 'my_question_task';
    protected $guarded=[];
    protected $primaryKey = 'task_id';
}
