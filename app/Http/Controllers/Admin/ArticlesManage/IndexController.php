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

    public function edit(Request $request){
        $id = $request->get('id');
        echo $id;
        if($request->isMethod('post')){

        }else{
            return view('admin.articleManage.edit');
        }

    }
    public function del(Request $request){
        $id = $request->get('id');
        echo $id;
    }

}