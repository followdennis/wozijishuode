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
use App\Models\ArticleManage\ArticleBody;
use App\Models\ArticleManage\ArticleHead;
use App\Models\ArticleManage\Category;
use App\Repository\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;


class IndexController extends AdminController
{

    protected $articleModel;
    protected $articleHeadModel;
    protected $categoryModel;
    protected $articleAllModel;
    protected $articleBodyModel;
    public function __construct(Request $request,Article $articleModel,ArticleHead $articleHead,Category $category,ArticleAll $articleAll,ArticleBody $articleBody)
    {
        parent::__construct($request);
        $this->articleModel = $articleModel;
        $this->articleHeadModel = $articleHead;
        $this->categoryModel = $category;
        $this->articleAllModel = $articleAll;
        $this->articleBodyModel = $articleBody;
    }

    public function index(Request $request){
        $cate_list = $this->categoryModel->getFieldList();
        return view('admin.articleManage.index',compact('cate_list'));
    }

    public function get_list(Request $request){
        $record = $this->articleAllModel->getList();
        return DataTables::of($record)
            ->addColumn('action',function($record){
                $id = $record->id;
                $edit_article = '<a href="'.route('articles/edit',['id'=>$id]).'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_article = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                return $edit_article.$del_article;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function ($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('title','like',"%$kw%");
                }
                $cate_id = $request->get('cate_id');
                $query->when($cate_id,function($subQuery)use($cate_id){
                    $subQuery->where('cate_id',$cate_id);
                });
            })->make(true);
    }
//    /**
//     * 2017-11-19 弃用
//     * 自定义的通过ajax实现的翻页效果
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function get_list(Request $request){
//        $perPage = 10;
//        $cate_id = $request->get('cateId');
//        if($request->filled('perPage') && $request->get('perPage') < 101){
//            $perPage = intval($request->get('perPage'));
//        }
//        $page = $this->articleAllModel->getList($cate_id)->paginate($perPage);
//
//        $response = array(
//            'list'   => $page->toArray()['data'],
//            'page' => array(
//                'total'        => $page->total(),
//                'per_page'     => $page->perPage(),
//                'current_page' => $page->currentPage(),
//                'last_page'    => $page->lastPage(),
//                'from'         => $page->firstItem(),
//                'to'           => $page->lastItem()
//            ),
//            'links'=>$page->links('vendor.pagination.new')->toHtml()
//        );
//        return response()->json($response);
//    }
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
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();

        }
        return view('admin.articleManage.add');
    }

    public function edit(Request $request){
        $id = $request->get('id');

        if($request->isMethod('post')){

        }else{
            $articleRepo = new ArticleRepository($this->articleAllModel,$this->articleBodyModel);
            $data = $articleRepo->getInfoByArticle($id);//为数组值
            $patten = array("\r\n", "\n", "\r");//替换文本中的换行符
            $data['content']=trim(str_replace($patten, "", $data['content']));
            $data['created_at'] = Carbon::parse($data['created_at'])->format('Y-m-d H:i:s');
            return view('admin.articleManage.edit',compact('data'));
        }

    }
    public function del(Request $request){
        $id = $request->get('id');
        $status = $this->articleAllModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }

}