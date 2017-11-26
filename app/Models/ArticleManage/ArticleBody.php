<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleBody extends Model
{
    //
    protected $table='article_body_';

    public function getInfoById($id,$select = '*'){
        $body_id = get_article_body_id($id);
        return DB::table($this->table.$body_id)->where('id',$id)->select($select)->first();
    }
    public function updateData($params = []){
        $body_id = get_article_body_id($params['id']);
        return DB::table($this->table.$body_id)->where('id',$params['id'])->update($params);
    }

}
