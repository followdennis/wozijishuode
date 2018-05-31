<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\SearchKeyWords;
use App\Models\ArticleManage\Tags;
use App\Repository\Foreground\SearchRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends CommonController
{
    //
    protected $searchRepo;
    public function __construct(Request $request,SearchRepository $search)
    {
        parent::__construct($request);
        $this->searchRepo = $search;
    }

    public function search_keywords(Request $request,SearchKeyWords $searchKeyWords){

        $kw = trim($request->get('keywords'));
        list($paginate,$list) = $this->searchRepo->getDataByKeyWords($kw);
        $is_exists = $paginate->total == 0 ? 0:1;
        $searchKeyWords->updateWordsClick($kw,$is_exists);
        $this->hot_words();
        $cate_key_val = $this->getCateKeyVal();
        $this->latest_hot_article($cate_key_val);
        if($paginate->total == 0){
            return view('foreground.search.search_keywords',['kw'=>$kw,'is_exists'=>0]);
        }

        foreach($list as $article){
            $article->article_id = \Hashids::encode($article->id);
            $article->cate_pinyin = isset($cate_key_val[$article->cate_id])?$cate_key_val[$article->cate_id]:'default' ;
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
            $article->title = str_replace($kw,'<font style="color:red">'.$kw.'</font>',$article->title);
        }
        return view('foreground.search.search_keywords',['kw'=>$kw,'articles'=>$list,'is_exists'=>1]);
    }
    public function more(Request $request){
        $kw = trim($request->get('kw'));
        $page = $request->get('page',1);
        if($page>10){
            $page = 10;
            $request->merge(['page'=>$page]);
        }
        $more = $this->searchRepo->more($kw);
        return response()->json($more);
    }

    public function search_tag(Request $request,Tags $tags,$tag = null){
        list($paginate,$article_list) = $this->searchRepo->getDataByTag($tag);
        $tags->updateClick($tag);
        $this->hot_words();
        $top_tag = Tags::orderBy('click','desc')->take(10)->select('name')->get();
        $this->message = '标签';
        if($paginate->total == 0){
            return view('foreground.search.search_tag',['tag'=>$tag,'is_exists'=>0,'top_tag'=>$top_tag]);
        }
        $cate_key_val = $this->getCateKeyVal();
        foreach($article_list as $article){
            $article->article_id = \Hashids::encode($article->id);
            $article->cate_pinyin = $cate_key_val[$article->cate_id];
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
        }
        return view('foreground.search.search_tag',['tag'=>$tag,'articles'=>$article_list,'is_exists'=>1,'top_tag'=>$top_tag]);
    }
    /**
     *  热词
     */
    public function hot_words(){
        $searchModel = new SearchKeyWords();
        $data = $searchModel->hotSearch();
        return view()->share(['words'=>$data]);
    }

    /**
     * @return mixed
     * 搜索界面的最新热文
     */
    public function latest_hot_article($cate_key_val = []){
        $latest = $this->searchRepo->latestHotArticle($cate_key_val);
        return view()->share(['latest_hot'=>$latest]);
    }

    /**
     * 自动完成
     * 2018-04-29 by gavin
     */
    public function autoload(Request $request){
        $kw = trim($request->get('keyword'));
        $data = $this->searchRepo->autoLoad($kw);
        return response()->json(['data'=>$data]);
    }

    /**
     * 自动完成  全库搜索
     */
    public function autoload2(Request $request){
        $kw = trim($request->get('keyword'));
        if(preg_match("/\'/",$kw)){
            return response()->json(['data'=>[]]);
        }
        $data = $this->searchRepo->autoLoad2($kw);
        return response()->json(['data'=>$data]);
    }

}
