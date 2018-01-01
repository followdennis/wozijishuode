<?php

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyQuestion extends Model
{
    use SoftDeletes;
    //
    protected $table = 'my_question';
    protected $guarded = [];
    public function getList(){
        return self::orderBy('sort','desc')->orderBy('id','desc');
    }
}
