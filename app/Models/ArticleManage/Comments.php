<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    //
    use SoftDeletes;
    protected $table = 'comments';
    protected $guarded = [];
    public function getInfoById($id){
        return self::find($id);
    }
    public function getAllList(){
        return self::orderBy('id','desc');
    }
    //删除数据
    public function delData($id){
        return self::destroy($id);
    }
    //是否禁言
    public function updateData($id,$is_hidden = 0){
        return self::where('id',$id)->update(['is_hidden'=>$is_hidden]);
    }
    //获取留言列表
    public function getCommentsList($article_id = 0){
        return self::where('is_hidden',0)->where('parent_id',0)->where('article_id',$article_id)->take(10)->get();
    }
}
