<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/7
 * Time: 22:31
 */

namespace App\Repository\Foreground;


use App\Models\ArticleManage\ArticleAll;
use App\Models\ArticleManage\Tags;
use App\Models\ArticleManage\TagsArticles;

class SearchRepository
{
    public function getDataByTag($tag_name = ''){
        $tag_ids = Tags::where('name','like',$tag_name.'%')->select('id')->get()->toArray();
        $data = new \stdClass();
        if(!empty($tag_ids)){
            $article_ids = TagsArticles::whereIn('tag_id',$tag_ids)->select('article_id')->paginate(20);
            $ids = [];
            foreach($article_ids as $item){
                array_push($ids,$item['article_id']);
            }
            $article_list = ArticleAll::where('is_show',1)->whereIn('id',$ids)->get();
            $data->total = $article_ids->total();
            $data->currentPage = $article_ids->currentPage();
            $data->hasMore = $article_ids->hasMorePages();
            $data->from = $article_ids->lastPage();
            $data->to = $article_ids->lastItem();
            $data->perPage = $article_ids->perPage();

            return [$data,$article_list];
        }
    }
    public function getDataByKeyWords(){

    }
}