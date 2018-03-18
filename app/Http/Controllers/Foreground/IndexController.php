<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\Comments;
use App\Models\Foreground\Article;
use App\Models\Foreground\ArticleUserLike;
use App\Models\Foreground\Category;
use App\Repository\Foreground\ArticleRepository;
use App\Services\FrontCateService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends CommonController
{
    //
    protected $cateModel;
    protected $articleModel;
    protected $articleRepository;
    protected $articleIndexModel;
    protected $cateService;
    public function __construct(Request $request,Category $category,Article $article,\App\Repository\ArticleRepository $articleRepository,
                                \App\Models\ArticleManage\Article $articleIndex,FrontCateService $cateService)
    {
        parent::__construct($request);
        $this->cateModel = $category;
        $this->articleModel = $article;
        $this->articleRepository = $articleRepository;
        $this->articleIndexModel = $articleIndex;
        $this->cateService = $cateService;
    }

    public function index(Request $request,ArticleRepository $articleRepository,$page = 1){
        if($page>100){
            $page = 100;
        }
        $request->merge(['page'=>$page]);
        $nav = $this->nav();
        $cates = $this->getCategoryArr();
//        $article_list = $this->articleModel->getArticleList();
        list($paginate,$article_list) = $articleRepository->getArticleList();
        //友情链接
        $this->friendLink();
        foreach($article_list as $article){
            $article->article_id = \Hashids::encode($article->id);
            $article->cate_pinyin = isset($cates[$article->cate_id]) ? $cates[$article->cate_id]: 'default';
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
        }
        return view('foreground.index',['nav'=>$nav,'articles'=>$article_list,'current_route'=>'','is_exists'=>1]);
    }

    public function lists(Request $request,$cate = null,$page = 1){
        if($page>100){
            $page = 100;
        }
        $request->merge(['page'=>$page]);
        $nav = $this->nav();
        $cate_key_val = $this->cateModel->getKeyVal();
        $cate_id = $this->cateService->getCateIdByCate($cate,$cate_key_val);
        $articles = $this->articleModel->getArticleList($cate_id);
        foreach($articles as $article){
            $article->article_id = \Hashids::encode($article->id);
            $article->cate_pinyin = isset($cate) ? $cate: 'default';
            $article->tags_name = empty($article->tags_name)?[]:explode(',',$article->tags_name);
        }
        if($cate_id == 0){
            return redirect(url('/'));
        }
        return view('foreground.ch',[
            'nav'=>$nav,
            'articles'=>$articles,
            'current_route'=>$cate,
            'is_exists'=>1,
        ]);
    }
    public function detail(Request $request,Comments $comments,$cate = 'default',$id = 0){
        $id = intval($id);
        $cate_key_val = $this->cateModel->getKeyVal();
        $cate_id = $this->cateService->getCateIdByCate($cate,$cate_key_val);

        $check_article_exists = $this->articleIndexModel->checkArticleExists($cate_id,$id);
        $this->detail_recommend();
        //判断文章是否已展示
        if(!$check_article_exists){
            $article['article_id'] = 0;
            return view('foreground.detail',['is_exist'=>0,'breads'=>[['name'=>'首页','pinyin'=>'','prefix'=>'']],'article'=>$article]);
        }

        $this->next($cate,$cate_id,$id);//下一页
        $this->prev($cate,$cate_id,$id);//上一页
        $article = $this->articleRepository->getArticleData($id);
        $article['article_id'] = \Hashids::encode($article['id']);
        $comments = $comments->getCommentsList($id);
        $bread = $this->breadCrumb($cate_id,$article['title']);
        if(!empty($article['tags_name'])){
            $article['tags_name'] = explode(',',$article['tags_name']);
        }
        return view('foreground.detail',['article'=>$article,'breads'=>$bread,'comments'=>$comments,'is_exist'=>1]);
    }
    //获取详情底部推荐2018-03-03 15:50:22 by libo
    public function detail_recommend(){
        $recommends = $this->articleModel->getRecommends();
        return view()->share(['bottom_recommend'=>$recommends]);
    }

    /**
     * 文章列表点赞功能
     * @param Request $request
     */
    public function article_like(Request $request){
        $this->validate($request,[
            'article_id'=>'required|hashid',
        ]);
        $params = $request->all();
        $article_id = \Hashids::decode($params['article_id'])[0];
        $user_id = \Auth::guard('front')->user()->id;
        $user_hash_id = \Hashids::encode($user_id);
        $user_name = \Auth::guard('front')->user()->name;

        if($request->cookie('article'.$params['article_id'].'user'.$user_hash_id)){
            return response()->json(['state'=>2,'msg'=>'您已经赞过此评论']);
        }
        $data = [
            'article_id'=>$article_id,
            'user_id'=>$user_id,
            'user_name'=>$user_name,
            'created_at'=>Carbon::now()->toDateTimeString()
        ];
        $insert = ArticleUserLike::insert($data);
        $count_change = $this->articleRepository->articleLikeChange($article_id);
        if($count_change && $insert){
            $forever = 30*24*60;
            $cookie = cookie('article'.$params['article_id'].'user'.$user_hash_id,1,$forever);
            return response()->json(['state'=>1,'msg'=>'点赞成功','like_count'=>$count_change],200)->withCookie($cookie);
        }else{
            return response()->json(['state'=>0,'msg'=>'点赞失败','like_count'=>'0'],500);
        }
    }
    /**
     * 翻页功能
     * @param $cate
     * @param $cate_id
     * @param $id
     * @return mixed
     */
    public function next($cate,$cate_id,$id){
        //检查是否存在
        $new_id = $this->articleIndexModel->getNextOrPrev($cate_id,$id,1,'id');
        if(!$new_id){
            return view()->share(['next'=>'没有了','next_url'=>'#']);
        }else{
            $head = $this->articleRepository->getArticleTitle($new_id->id);
            return view()->share(['next'=>$head->title,'next_url'=>url($cate.'/'.$head->id.'.html')]);
        }
    }
    public function prev($cate,$cate_id,$id){
        $new_id = $this->articleIndexModel->getNextOrPrev($cate_id,$id,-1,'id');
        if(!$new_id){
            return view()->share(['prev'=>'没有了','prev_url'=>'#']);
        }else{
            $head = $this->articleRepository->getArticleTitle($new_id->id);
            return view()->share(['prev'=>$head->title,'prev_url'=>url($cate.'/'.$head->id.'.html')]);
        }
    }

}
