<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\Article;
use App\Models\Foreground\Category;
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

    public function index(){
        $nav = $this->nav();
        $article_list = $this->articleModel->getArticleList();

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
