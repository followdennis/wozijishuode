<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    //
    protected $table='article_index';


    public function getIds($cate_id = 5){
        $record = DB::table($this->table)
            ->select('id','cate_id')
            ->orderBy('id','desc')
            ->when($cate_id,function($query) use($cate_id){
                $query->where('cate_id',$cate_id);
            });
        return $record;
    }
    public function getArticleList($ids = []){

    }
    /**
     * @param $id
     */
    public function getArticleById($id){

    }

}
