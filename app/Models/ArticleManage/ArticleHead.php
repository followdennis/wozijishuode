<?php

namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ArticleHead extends Model
{
    //分表处理
    protected $table='article_head_';

    public function getInfoById($id){
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->find($id);
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
}
