<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/1
 * Time: 23:43
 */
namespace App\Repository\Foreground;

use App\Models\Foreground\Article;

class ArticleRepository{

    public function getArticleList(){
        $list = Article::where('is_show',1)
            ->select(['id','title','author','tags_name','description','created_at','click','like','img','cate_id'])
            ->orderBy('id','desc')
            ->take(20)
            ->get();
        return $list;
    }
}