<?php

namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ArticleHead extends Model
{
    //分表处理
    protected $table='article_head_';

    public function getInfoById($id,$select = '*'){
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->select($select)->find($id);
    }
    public function getHeadList($ids = []){
        $last = last($ids);
        $head_id = get_article_head_id($last);
        return \DB::table($this->table.$head_id)->whereIn('id',$ids)->get();
    }
    //获取分布在不同表中的数据
    public function getHeadRandList($ids = []){
        $collect = collect([]);
        foreach($ids as $id){
            $head_id = get_article_head_id($id);
            $record = \DB::table($this->table.$head_id)->where('id',$id)->get();
            $collect = $collect->merge($record);
        }
        return $collect;
    }
    public function getInfo($id){
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->where('id',$id)->get();
    }
    //更新操作
    public function updateData($params = []){
        $head_id = get_article_head_id($params['id']);
        $params = array_add($params,'updated_at',Carbon::now()->format('Y-m-d H:i:s'));
        return \DB::table($this->table.$head_id)->where('id',$params['id'])->update($params);
    }
    //添加数据
    public function insertData($params = []){
        $head_id = get_article_head_id($params['id']);
        $params = array_add($params,'created_at',Carbon::now()->format('Y-m-d H:i:s'));
        return \DB::table($this->table.$head_id)->insert($params);
    }
    //删除数据
    public function delData($id){
        //is_show的条件不需要
        $data = ['deleted_at'=>Carbon::now()->format('Y-m-d H:i:s')];
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->where('id',$id)->update($data);
    }
    //修改显示状态
    public function changeShow($condition = [],$update = []){
        $head_id = get_article_head_id($condition['id']);
        $one = \DB::table($this->table.$head_id)->where($condition)->first();
        if($one){
            if($one->is_show == 0 && $update['is_show'] == 1){
                $update['post_time'] = Carbon::now()->toDateTimeString();
            }
            return \DB::table($this->table.$head_id)->where($condition)->update($update);
        }
        return false;
    }
    public function likeCount($article_id = 0){
        $head_id = get_article_head_id($article_id);
        return \DB::table($this->table.$head_id)->whereNull('deleted_at')->where('id',$article_id)->increment('like');
    }
    public function commentCount($article_id = 0,$flag = 1){
        $head_id = get_article_head_id($article_id);
        $model = \DB::table($this->table.$head_id)->whereNull('deleted_at')->where('id',$article_id);
        if($flag > 0){
            return $model->increment('comments_count');
        }else{
            return $model->decrement('comments_count');
        }
    }
    //浏览次数加1
    public function view_count($article_id){
        $head_id = get_article_head_id($article_id);
        return \DB::table($this->table.$head_id)->whereNull('deleted_at')->where('id',$article_id)->increment('click',1);
    }
}
