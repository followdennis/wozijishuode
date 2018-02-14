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
            ->select(['id','title','author','tags_name','description','created_at','click','post_time','like','img','cate_id'])
            ->orderBy('id','desc')
            ->paginate(20);
        $data = new \stdClass();
        $data->total = $list->total();
        $data->currentPage = $list->currentPage();
        $data->hasMore = $list->hasMorePages();
        $data->from = $list->lastPage();
        $data->to = $list->lastItem();
        $data->perPage = $list->perPage();
        return [$data,$list];
    }
}