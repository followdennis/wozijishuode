<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/8
 * Time: 21:24
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Comments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CommentsController extends AdminController
{

    protected $commentsModel;
    public function __construct(Request $request,Comments $comments)
    {
        parent::__construct($request);
        $this->commentsModel = $comments;
    }

    public function index(){
        return view('admin.comments.index');
    }
    public function get_list(Request $request){
        $record = $this->commentsModel->getAllList()->with('commonUser','article')->where(function($query) use($request){
            if($request->filled('user_name')){
                $name = trim($request->get('user_name'));
                $query->whereHas('commonUser',function($subQuery) use($name){
                    $subQuery->where('name','like','%'.$name.'%');
                });
            }
            if($request->filled('title')){
                $title = trim($request->get('title'));
                $query->whereHas('article',function($subQuery) use($title){
                    $subQuery->where('title','like','%'.$title.'%');
                });
            }
        });

        return DataTables::of($record)
            ->addColumn('title',function($record){
                return $record->article->title;
            })
            ->addColumn('user_name',function($record){
                return $record->commonUser->name;
            })
            ->addColumn('action',function($record){
                $id = \Hashids::encode($record->id);
                $real_id = $record->article->id;
                if($record->is_hidden == 1){
                    $is_hidden = '<a  data-id="'.$id.'" data-is_hidden="'.$record->is_hidden.'" class="btn btn-sm default item_hide"><i class="fa fa-edit"></i>展示</a>';
                }else{
                    $is_hidden = '<a  data-id="'.$id.'" data-is_hidden="'.$record->is_hidden.'" class="btn btn-sm green item_hide"><i class="fa fa-edit"></i>屏蔽</a>';
                }
                $del_tags = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                $article = '<a href="'.route('articles/show',['id'=>$real_id]).'"  class="btn  btn-sm blue item_more"><i class="fa fa-trash-o"></i> 对应文章 </a>';
                return $is_hidden.$del_tags.$article;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function ($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('comment','like',"%$kw%");
                }
                if($request->filled('sort_order')){
                    $order_flag = $request->get('sort_order');
                    if($order_flag == 1){
                        $query->orderBy('like','desc');
                    }else if($order_flag == 2){
                        $query->orderBy('like','asc');
                    }else{
                        $query->orderBy('id','desc');
                    }
                }
            })->make(true);
    }
    public function del(Request $request){
        $id = $request->get('id');
        $id = \Hashids::decode($id)[0];
        $status = $this->commentsModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除评论成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除评论失败']);
        }
    }
    //是否屏蔽
    public function hide_message(Request $request){
        $is_hidden = $request->get('is_hide');
        $id = $request->get('id');
        $id = \Hashids::decode($id)[0];
        $set_status = $this->commentsModel->updateData($id,$is_hidden);
        if($set_status){
            return response()->json(['status'=>1,'msg'=>'设置成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'设置失败']);
        }
    }
}