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
        $data = ['is_show'=>0,'deleted_at'=>Carbon::now()->format('Y-m-d H:i:s')];
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->where('id',$id)->update($data);
    }
    //修改显示状态
    public function changeShow($condition = [],$update = []){
        $head_id = get_article_head_id($condition['id']);
        $update = ['updated_at'=>Carbon::now()->toDateTimeString(),'is_show'=>$update['is_show']];
        return \DB::table($this->table.$head_id)->where($condition)->update($update);
    }
    public function likeCount($article_id = 0){
        $head_id = get_article_head_id($article_id);
        return \DB::table($this->table.$head_id)->whereNull('deleted_at')->where('id',$article_id)->increment('like');
    }
}
