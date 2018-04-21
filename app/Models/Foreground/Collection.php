<?php

namespace App\Models\Foreground;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    //
    use SoftDeletes;
    protected $guarded = [];
    public function insertData($user_id,$article_id){
       $model = self::where(['user_id'=>$user_id,'article_id'=>$article_id])->first();
       if($model){
           $model->click +=1;
           $model->save();
           return ['code'=>2,'msg'=>'您已经收藏过该文章了哦！'];
       }
       $status = self::create(['user_id'=>$user_id,'article_id'=>$article_id]);
       if($status){
           return ['code'=>1,'msg'=>'收藏成功'];
       }else{
           return ['code'=>0,'msg'=>'收藏失败'];
       }
    }
    public function getList($user_id){
        return self::where('user_id',$user_id);
    }
    public function delData($user_id,$article_id){
        return self::where('user_id',$user_id)->where('article_id',$article_id)->delete();
    }
    public function article(){
        return $this->hasOne('App\Foreground\Article','id','article_id')->withDefault(function($article){
            $article->title = "文章不存在或已经被删除";
            $article->cate_id = 0;
        });
    }
    public function user(){
        return $this->hasOne('App\Models\CommonUser','id','user_id')->withDefault(function($user){
            $user->name = '该用户不存在或者已经被注销';
            $user->id = 0;
        });
    }

}
