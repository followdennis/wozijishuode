<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\Tags;
use App\Repository\Foreground\SearchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends CommonController
{
    //
    protected $searchRepo;
    public function __construct(SearchRepository $search)
    {
        $this->searchRepo = $search;
    }

    public function search_keywords(Request $request){
        $kw = trim($request->get('keywords'));
        list($paginate,$list) = $this->searchRepo->getDataByKeyWords($kw);
        if($paginate->total == 0){
            return view('foreground.search.search_keywords',['kw'=>$kw,'is_exists'=>0]);
        }
        $cate_key_val = $this->getCateKeyVal();

        foreach($list as $article){
            $article->cate_pinyin = $cate_key_val[$article->cate_id];
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
        }
        return view('foreground.search.search_keywords',['kw'=>$kw,'articles'=>$list,'is_exists'=>1]);
    }

    public function search_tag(Request $request,$tag = null){
        list($paginate,$article_list) = $this->searchRepo->getDataByTag($tag);
        $top_tag = Tags::orderBy('click','desc')->take(10)->get();
        $this->message = '标签';
        if($paginate->total == 0){
            return view('foreground.search.search_tag',['tag'=>$tag,'is_exists'=>0,'top_tag'=>$top_tag]);
        }
        $cate_key_val = $this->getCateKeyVal();
        foreach($article_list as $article){
            $article->cate_pinyin = $cate_key_val[$article->cate_id];
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
        }
        return view('foreground.search.search_tag',['tag'=>$tag,'articles'=>$article_list,'is_exists'=>1,'top_tag'=>$top_tag]);
    }
}
