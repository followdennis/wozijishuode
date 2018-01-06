<?php

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class MyQuestion extends Model
{
    use SoftDeletes;
    //
    protected $table = 'my_question';
    protected $guarded = [];
    public function getList(){
        $user_id = Auth::user()->id;
        return self::where('user_id',$user_id)->orderBy('sort','desc')->orderBy('id','desc');
    }
    public function insertData($data = array()){
        return self::insert($data);
    }
}
