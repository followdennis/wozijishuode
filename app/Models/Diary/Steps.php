<?php

namespace App\Models\Diary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Steps extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    public function getList(){
        $user_id = Auth::user()->id;
        return self::where(['user_id'=>$user_id])->orderBy('id','desc')->select('*');
    }
    public function insertData($params){
        return self::insert($params);
    }
    public function updateData($con,$update = []){
        return self::where($con)->update($update);
    }
    public function delData($id){
        $user_id = Auth::user()->id;
        return self::where(['user_id'=>$user_id])->whereIn('id',$id)->delete();
//        return self::where(['user_id'=>$user_id])->destroy($id);
    }
}
