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
        }else{
            $data->total = 0;
            $article_list = [];
            return [$data,$article_list];
        }
    }
    public function getDataByKeyWords($keywords = null){
        $data = ArticleAll::where('is_show',1)->where(function($query)use($keywords){
            if(empty($keywords)){
                $query->where('click',-100);
            }else{
                $query->where('title','like',"%".$keywords."%");
            }
        })
            ->orderBy('click','desc')
            ->paginate(20);
        $paginate = new \stdClass();
        $paginate->total = $data->total();
        $paginate->currentPage = $data->currentPage();
        $paginate->hasMore = $data->hasMorePages();
        $paginate->from = $data->lastPage();
        $paginate->to = $data->lastItem();
        $paginate->perPage = $data->perPage();
        return [$paginate,$data];
    }

    /**
     * @param array $cate_key_val 由 cate_id 查找cate_pinyin
     * @return mixed
     */
    public function latestHotArticle($cate_key_val = []){
        $sub = \DB::table('article')->where('is_show',1)->select('id','title','cate_id','click')->orderBy('post_time','desc')->take('200');
        $results = \DB::table(\DB::Raw('('.$sub->toSql().')'.' as '.\DB::getTablePrefix().'temp'))
            ->mergeBindings($sub)
            ->orderBy('click','desc')
            ->take(8)->get()->map(function($item) use($cate_key_val){
              $item->cate_pinyin = isset($cate_key_val[$item->cate_id])?$cate_key_val[$item->cate_id]:'default' ;
              return $item;
            });
        return $results;
    }
    public function autoLoad($keywords = null){
        if(!$keywords){
            return [];
        }
        $data = \DB::table('search_keywords')->where('is_show',1)
            ->select('keywords')
            ->where('keywords','like','%'.$keywords.'%')
            ->orderBy('click','desc')
            ->take(8)->get()->map(function($item){
                return ['title'=>$item->keywords];
            })->unique()->toArray();
        return $data;
    }

    /**
     * 扫描全库
     * @param null $keywords
     * @return array
     */
    public function autoLoad2($keywords = null){
        if(!$keywords){
            return [];
        }
        $data = \DB::table('article')->where('is_show',1)
            ->select('title')
            ->where('title','like','%'.$keywords.'%')
            ->orderBy('click','desc')
            ->take(8)->get()->map(function($item){
                return ['title'=>$item->title];
            })->toArray();
        return $data;
    }

}