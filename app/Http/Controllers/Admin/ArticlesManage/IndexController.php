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
use App\Models\ArticleManage\ArticleAll;
use App\Models\ArticleManage\ArticleHead;
use App\Models\ArticleManage\Category;
use App\Repository\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class IndexController extends AdminController
{

    protected $articleModel;
    protected $articleHeadModel;
    protected $categoryModel;
    protected $articleAllModel;
    public function __construct(Request $request,Article $articleModel,ArticleHead $articleHead,Category $category,ArticleAll $articleAll)
    {
        parent::__construct($request);
        $this->articleModel = $articleModel;
        $this->articleHeadModel = $articleHead;
        $this->categoryModel = $category;
        $this->articleAllModel = $articleAll;
    }

    public function index(Request $request){
        $cate_list = $this->categoryModel->getFieldList();
        return view('admin.articleManage.index',compact('cate_list'));
    }
    public function get_list(Request $request){
        $perPage = 10;
        $cate_id = $request->get('cateId');
        if($request->filled('perPage') && $request->get('perPage') < 101){
            $perPage = intval($request->get('perPage'));
        }
        $page = $this->articleAllModel->getList($cate_id)->paginate($perPage);

        $response = array(
            'list'   => $page->toArray()['data'],
            'page' => array(
                'total'        => $page->total(),
                'per_page'     => $page->perPage(),
                'current_page' => $page->currentPage(),
                'last_page'    => $page->lastPage(),
                'from'         => $page->firstItem(),
                'to'           => $page->lastItem()
            ),
            'links'=>$page->links('vendor.pagination.new')->toHtml()
        );
        return response()->json($response);
    }
//    public function get_list(Request $request){
//        $perPage = 10;
//        $cate_id = $request->get('cateId');
//        if($request->filled('perPage') && $request->get('perPage') < 101){
//            $perPage = intval($request->get('perPage'));
//        }
//        $page = $this->articleModel->getIds($cate_id)->paginate($perPage);
//        foreach($page as $k =>$v){
//            $ids_arr[] = $v->id;
//        }
//        $links = $page->links('vendor.pagination.new')->toHtml();
//        $list = ArticleRepository::getArticleRandList($ids_arr);
//        $from = $page->firstItem();
//        $to = $page->lastItem();
//        $total = $page->total();
//        return response()->json(compact('links','list','from','to','total'));
//    }
    public function show(Request $request){
        $id = $request->get('id');
        $time = microtime(true);
        $data = ArticleRepository::getArticleData($id);
        $end = microtime(true);
        echo $end-$time;
        return view('admin.articleManage.show',['data'=>$data]);
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