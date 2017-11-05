<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ArticleBody extends Model
{
    //
    protected $table='article_body_';

    public function getInfoById($id){
        $body_id = get_article_body_id($id);
        return DB::table($this->table.$body_id)->where('id',$id)->first();
    }

}
