<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/8
 * Time: 21:23
 */
namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Tags;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TagsController extends AdminController
{
    protected $tagsModel;
    public function __construct(Request $request,Tags $tags)
    {
        parent::__construct($request);
        $this->tagsModel = $tags;
    }
    public function index(){
        return view('admin.tags.index');
    }
    public function get_list(Request $request){
        $record = $this->tagsModel->getList();
        return DataTables::of($record)
            ->addColumn('action',function($record){
                $id = \Hashids::encode($record->id);
                $edit_tags = '<a  data-id="'.$id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_tags = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                $article = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm blue item_more"><i class="fa fa-trash-o"></i> 对应文章 </a>';
                return $edit_tags.$del_tags.$article;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function ($query) use($request){
                if($request->filled('keyword')){
                    $kw = trim($request->get('keyword'));
                    $query->where('name','like',"%$kw%");
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
                'description'=>$params['description'],
                'pinyin' => trim($params['pinyin']),
                'py'=>trim($params['py']),
                'is_show'=>intval($params['is_show']),
                'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ];
            $status = $this->tagsModel->updateData($data,$id);
            if($status){
                return response()->json(['status'=>1,'msg'=>'编辑标签成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'编辑标签失败']);
            }
        }else{
            $data = $this->tagsModel->getInfoById($id);
            return view('admin.tags.edit',['info'=>$data,'hsid'=>$hsid]);
        }
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'description'=>$params['description'],
                'py'=>pinyin_abbr($params['name']),
                'tables_id'=>0,
                'is_show'=>intval($params['is_show']),
                'pinyin'=>pinyin_permalink($params['name'],''),
                'updated_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ];
            $status = $this->tagsModel->insertData($data);
            if($status){
                return response()->json(['status'=>1,'msg'=>'添加标签成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'添加标签失败']);
            }
        }
        return view('admin.tags.add');
    }
    public function del(Request $request){
        $id = $request->get('id');
        $id = \Hashids::decode($id)[0];
        $status = $this->tagsModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }
}