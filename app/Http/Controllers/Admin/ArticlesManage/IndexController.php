<?php
/**
 * Created by PhpStorm.
 * User: libo
 * Date: 2017/11/4
 * Time: 9:07
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Article;
use App\Models\ArticleManage\ArticleHead;
use App\Repository\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class IndexController extends AdminController
{

    protected $articleModel;
    public function __construct(Request $request,Article $articleModel)
    {
        parent::__construct($request);
        $this->articleModel = $articleModel;
    }

    public function index(Request $request,ArticleHead $articlehead){
        $time = microtime(true);
        $page = $this->articleModel->getIds(7)->paginate(10);
        foreach($page as $k =>$v){
            $ids_arr[] = $v->id;
        }
        $list = ArticleRepository::getArticleRandList($ids_arr);
        $end = microtime(true);
        $exhaust = $end-$time;
        return view('admin.articleManage.index',['list'=>$list,'page'=>$page]);
    }
    public function show(Request $request){
        $id = $request->get('id');
        $time = microtime(true);
        $data = ArticleRepository::getArticleData($id);
        $end = microtime(true);
        echo $end-$time;
        return view('admin.articleManage.show',['data'=>$data]);
    }
    public function get_list(){

    }
    public function add(){

    }

    public function edit(){
        $time = microtime(true);
        $id = 52364;
        $id = $request->get('id');
        $head_id = get_article_head_id($id);
        $body_id = get_article_body_id($id);
//        $record = \DB::table('article_head_'.$head_id." as h")
//            ->leftJoin('article_body_'.$body_id." as b",'h.id','=','b.id')
//            ->select('h.id','h.title','h.cate_name','h.click','b.content')
//            ->where('h.id',$id)
//            ->first();
        $record1 = \DB::table('article_head_'.$head_id)->where('id',$id)->first();
        $record2 = \DB::table('article_body_'.$body_id)->where('id',$id)->first();

        $data = [
            'id'=>$record1->id,
            'title'=>$record1->title,
            'cate_name'=>$record1->cate_name,
            'click'=>$record1->click,
            'content'=>$record2->content
        ];
        echo "<pre>";
        print_r($data);
        $end = microtime(true);
        echo $end-$time;
    }
    public function del(){

    }

}