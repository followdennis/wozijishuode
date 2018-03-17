<?php

namespace App\Models\Foreground;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleOrCommentReport extends Model
{
    //
    use SoftDeletes;
    protected $table = 'article_or_comment_report';
    protected $guarded = [];
    public function getList(){
        return self::orderBy('id','desc');
    }
    public function delData($id = 0){
        return self::where('id',$id)->delete();
    }
    public function updateData($params = []){
        return self::where('id',$params['id'])->update($params);
    }
    public function article(){
        return $this->hasOne('App\Models\ArticleManage\ArticleAll','id','article_id');
    }
    public function comment(){
        return $this->hasOne('App\Models\ArticleManage\Comments','id','comment_id')->withDefault([
            'article_id'=>0,
            'comment'=>'无'
        ]);
    }

}
