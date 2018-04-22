<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagsArticles extends Model
{
    //
    protected $table = 'tags_articles';
    protected $guarded = [];

    public function delData($tag_id = [],$article_id = 0){
        return self::whereIn('tag_id',$tag_id)->where('article_id',$article_id)->delete();
    }
    public function delDataByArticleId($id = 0){
        return self::where('article_id',$id)->delete();
    }

}
