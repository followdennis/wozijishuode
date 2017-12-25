<?php

namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Article;
use App\Repository\ArticleRepository;
use Illuminate\Http\Request;

class ArticleOnlineMassController extends AdminController
{
    //
    protected $articleRepos;
    public function __construct(Request $request,ArticleRepository $articleRepository)
    {
        parent::__construct($request);
        $this->articleRepos = $articleRepository;
    }

    public function index(){
        return view('admin.articleMass.index');
    }
    public function lists(Request $request){
        $record = Article::where(function($query) use($request){
            if($request->filled('cateId')){
                $cate_id = $request->get('cateId');
                $query->where('cate_id',$cate_id);
            }
            $query->where(['is_show'=>1]);
        })->select('id')->orderBy('id','desc')->paginate(10);
        $ids = $record->toArray()['data'];
        $ids = array_flatten($ids);
        $data = $this->articleRepos->getArticlesByIds($ids);
        return response()->json($data);
    }
    public function edit(){
        echo 'edit';
    }
}
