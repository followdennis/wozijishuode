<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;

class ArticleHead extends Model
{
    //
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
    public function getInfo($id){
        $head_id = get_article_head_id($id);
        return \DB::table($this->table.$head_id)->where('id',$id)->get();
    }
}
