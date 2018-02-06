<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\Article;
use App\Models\Foreground\Category;
use App\Repository\Foreground\ArticleRepository;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    //
    protected $cateModel;
    protected $articleModel;
    protected $articleRepository;
    protected $articleIndexModel;
    public function __construct(Category $category,Article $article,\App\Repository\ArticleRepository $articleRepository,\App\Models\ArticleManage\Article $articleIndex)
    {
        parent::__construct();
        $this->cateModel = $category;
        $this->articleModel = $article;
        $this->articleRepository = $articleRepository;
        $this->articleIndexModel = $articleIndex;
    }

    public function index(ArticleRepository $articleRepository){
        $nav = $this->nav();
        $cates = $this->getCategoryArr();
//        $article_list = $this->articleModel->getArticleList();
        $article_list = $articleRepository->getArticleList();
        foreach($article_list as $article){
            $article->cate_pinyin = isset($cates[$article->cate_id]) ? $cates[$article->cate_id]: 'default';
        }
        return view('foreground.index',['nav'=>$nav,'articles'=>$article_list,'current_route'=>'']);
    }

    public function lists( $cate = null){
        $nav = $this->nav();
        if(!empty($cate)){
            $cate_pinyin = last(explode('_',$cate));
            $cate_key_val = $this->cateModel->getKeyVal();
            $cate_id = isset($cate_key_val[$cate_pinyin]) ?$cate_key_val[$cate_pinyin]: 0;
        }else{
            $cate_id = 0;
        }
        $articles = $this->articleModel->getArticleList($cate_id);
        foreach($articles as $article){
            $article->cate_pinyin = isset($cate) ? $cate: 'default';
        }
        if($cate_id == 0){
            return redirect(url('/'));
        }
        return view('foreground.ch',['nav'=>$nav,'articles'=>$articles,'current_route'=>$cate]);
    }
    public function detail(Request $request,$cate = 'default',$id = 0){
        $id = intval($id);
        if(!empty($cate)){
            $cate_pinyin = last(explode('_',$cate));
            $cate_key_val = $this->cateModel->getKeyVal();
            $cate_id = isset($cate_key_val[$cate_pinyin]) ?$cate_key_val[$cate_pinyin]: 0;
        }else{
            $cate_id = 0;
        }
        $check_article_exists = $this->articleIndexModel->checkArticleExists($cate_id,$id);
        //判断文章是否已展示
        if(!$check_article_exists){
            return view('foreground.detail',['is_exist'=>0,'breads'=>[['name'=>'首页','pinyin'=>'','prefix'=>'']]]);
        }
        $article = $this->articleRepository->getArticleData($id);
        $bread = $this->breadCrumb($cate_id,$article['title']);
        if(!empty($article['tags_name'])){
            $article['tags_name'] = explode(',',$article['tags_name']);
        }
        return view('foreground.detail',['article'=>$article,'breads'=>$bread,'is_exist'=>1]);
    }

}
