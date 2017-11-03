<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\System\FriendLink;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FriendLinkController extends AdminController
{
    //
    protected $friendModel;
    public function __construct(Request $request,FriendLink $friendLink)
    {
        parent::__construct($request);
        $this->friendModel = $friendLink;
    }
    public function index(){
        return view('admin.system.friendLink.index');
    }
    public function get_list(Request $request){
        $list = $this->friendModel->getList();
        $sort = $request->get('sort');
        return Datatables::of($list)
            ->addColumn('action',function($record){
                $id = \Hashids::encode($record->id);
                $edit_link = '<a  data-id="'.$id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_link = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                return $edit_link.$del_link;
            })
            ->editColumn('created_at',function($record){
                return Carbon::parse($record->created_at)->format('Y-m-d');
            })
            ->editColumn('is_front',function($record){
                if($record->is_front){
                    return '是';
                }else{
                    return '否';
                }
            })
            ->filter(function($query) use ( $request){
                if($request->has('keyword')){
                    $keyword = trim($request->get('keyword'));
                    $query->where('name','like',"%$keyword%");
                }
                $query->orderBy('sort','desc');
            })
            ->make(true);
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'link_url'=>$params['link_url'],
                'description'=>strval($params['description']),
                'sort'=>intval($params['sort']),
                'is_front'=>isset($params['is_front']) ? 1:0,
                'created_at'=>Carbon::now()->format('Y-m-d H:i:s')
            ];
            $status = $this->friendModel->insertData($data);
            if($status){
                return response()->json(['status'=>1,'msg'=>'添加链接成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'添加链接失败']);
            }
        }
        return view('admin.system.friendLink.add');
    }
    public function edit(Request $request){
        $hsid = $request->get('id');
        $id = \Hashids::decode($hsid)[0];
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name'=>$params['name'],
                'link_url'=>$params['link_url'],
                'description'=>strval($params['description']),
                'sort'=>intval($params['sort']),
                'is_front'=>isset($params['is_front']) ? 1:0,
            ];
            $status = $this->friendModel->updateData($data,$id);
            if($status){
                return response()->json(['status'=>1,'msg'=>'编辑链接成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'编辑链接失败']);
            }

        }else{
            $data = $this->friendModel->getInfoById($id);
            return view('admin.system.friendLink.edit',['data'=>$data,'hsid'=>$hsid]);
        }
    }
    public function del(Request $request){
        $id = $request->get('id');
        $id = \Hashids::decode($id)[0];
        $status = $this->friendModel->delData($id);
        if($status){
            return response()->json(['status'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }
}
