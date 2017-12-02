<?php

namespace App\Http\Controllers\Admin\ArticlesManage;

use App\Http\Controllers\AdminController;
use App\Models\ArticleManage\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AuthorController extends AdminController
{
    //
    protected $authorModel;
    public function __construct(Request $request,Author $author)
    {
        parent::__construct($request);
        $this->authorModel = $author;
    }
    public function index(){
        return view('admin.author.index');
    }
    public function get_list(Request $request){
        $list = $this->authorModel->getList();
        return DataTables::of($list)
            ->addColumn('action',function($record){
                $id = $record->id;
                $author_edit = '<a href="avascript:;" data-id="'.$id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $author_del = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                return $author_edit.$author_del;
            })
            ->editColumn('is_show',function($record){
               return $record->is_show == 1 ? '是': '否';
            })
            ->editColumn('created_at',function($record){
                return empty($record->created_at) ? '':Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->filter(function($query) use($request){
                $kw = $request->get('keyword');
                $query->when($kw,function($subQuery)use($kw){
                    $subQuery->where('name','like','%'.$kw.'%');
                });
            })
            ->make(true);
    }
    public function edit(Request $request){
        $id = $request->get('id');
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'description'=>trim($params['description']),
                'py'=>trim($params['py']),
                'pinyin'=>trim($params['pinyin']),
                'is_show'=>isset($params['is_show']) ? 1 :0
            ];
            $status = $this->authorModel->updateData($data,$id);
            if($status){
                return response()->json(['code'=>1,'msg'=>'编辑成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'编辑失败']);
            }
        }else{
            $data = $this->authorModel->getInfoById($id);
            return view('admin.author.edit',['info'=>$data]);
        }

    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'py'=>pinyin_abbr($params['name']),
                'pinyin'=>pinyin_permalink($params['name'],''),
                'description'=>trim($params['description']),
                'is_show'=>isset($params['is_show'])? 1:0,
                'created_at'=>Carbon::now()->toDateTimeString()
            ];
            $status = $this->authorModel->insertData($data);
            if($status){
                return response()->json(['code'=>1,'action'=>'add','msg'=>'添加成功']);
            }else{
                return response()->json(['code'=>0,'action'=>'add','msg'=>'添加失败']);
            }
        }else{
            return view('admin.author.add');
        }
    }
    public function del(Request $request){
        $id = $request->get('id');
        $status = $this->authorModel->delData($id);
        if($status){
            return response()->json(['code'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>0,'msg'=>'删除失败']);
        }
    }
}
