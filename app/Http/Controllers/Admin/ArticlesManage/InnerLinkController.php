<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/8
 * Time: 21:23
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\InnerLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InnerLinkController extends AdminController
{
    protected $innerLinkModel;
    public function __construct(Request $request,InnerLink $innerlink)
    {
        parent::__construct($request);
        $this->innerLinkModel = $innerlink;
    }

    public function index(){
        return view('admin.innerlink.index');
    }
    public function get_list(Request $request){
        $record = $this->innerLinkModel->getList();
        return DataTables::of($record)
            ->addColumn('action',function($record){
                $id = \Hashids::encode($record->id);
                $article_id = $record->article_id;
                $edit = '<a  data-id="'.$id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                $article = '<a href="'.route('articles/show',['id'=>$article_id]).'"  class="btn  btn-sm blue item_more"><i class="fa fa-trash-o"></i> 对应文章 </a>';

                return $edit.$del.$article;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function ($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('name','like',"%$kw%");
                }
                if($request->filled('start_date')){
                    $start = trim($request->get('start_date'));
                    $query->where('created_at','>',$start);
                }
                if($request->filled('end_date')){
                    $end = trim($request->get('end_date'));
                    $query->where('created_at','<',"%$end%");
                }
            })->make(true);
    }
    public function edit(Request $request){
        $hsid = $request->get('id');
        $id = \Hashids::decode($hsid)[0];
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ];
            $status = $this->innerLinkModel->updateData($data,$id);
            if($status){
                return response()->json(['status'=>1,'msg'=>'编辑内链成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'编辑内链失败']);
            }
        }else{
            $data = $this->innerLinkModel->getInfoById($id);
            return view('admin.innerlink.edit',['info'=>$data,'hsid'=>$hsid]);
        }
    }
    public function del(Request $request){
        $id = $request->get('id');
        $id = \Hashids::decode($id)[0];
        $status = $this->innerLinkModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }
}