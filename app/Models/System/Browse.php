<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Browse extends Model
{
    //
    protected $table = 'browse';
    public $guarded = [];

    /**
     *  2018-09-23 by gavin
     * 获取列表数据
     */
    public function getList(){
        $list = self::orderBy('id','desc');
        return $list;
    }
    public function del($id){
        return self::destroy($id);
    }
    /**
     * 获取用户名
     */
    public function user(){
        return $this->hasOne('App\Models\CommonUser','id','user_id')->withDefault(function($article){
            $article->name = '无对应用户';
        });
    }
    /**
     * 获取文章标题
     */
    public function article(){
        return $this->hasOne('App\Models\ArticleManage\ArticleAll','id','article_id')->withDefault(function($article){
            $article->title = '无对应文章';
        });
    }
}
