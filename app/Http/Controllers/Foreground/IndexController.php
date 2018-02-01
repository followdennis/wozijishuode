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
    public function __construct(Category $category,Article $article)
    {
        parent::__construct();
        $this->cateModel = $category;
        $this->articleModel = $article;
    }

    public function index(ArticleRepository $articleRepository){
        $nav = $this->nav();
//        $article_list = $this->articleModel->getArticleList();
        $article_list = $articleRepository->getArticleList();

//        $category = Article::find(58574)->category;
//        dd($category->pinyin);
        return view('foreground.index',['nav'=>$nav,'articles'=>$article_list]);
    }

    public function lists(){
        $nav = $this->nav();
        return view('foreground.ch',['nav'=>$nav]);
    }
    public function detail(){
        return view('foreground.detail',['cate_name'=>'ddd']);
    }
    public function search(){
        return view('foreground.search',['cate_name'=>'bb']);
    }
}
