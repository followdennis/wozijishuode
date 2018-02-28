<?php

namespace App\Models\Foreground;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CommentUserLike extends Model
{
    //
    protected $table='comment_user_like';
    protected $guarded = [];
    public function addCommentUser($params = []){
        $where = ['comment_id'=>$params['comment_id'],'user_id'=>$params['user_id'],'article_id'=>$params['article_id']];
        $model = self::where($where)->first();
        if($model){
            //已经点赞过了
            return false;
        }else{
            $where['user_name'] = $params['user_name'];
            $where['created_at'] = Carbon::now()->toDateTimeString();
            return self::insert($where);
        }
    }
}
