<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\Role;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use Yajra\Datatables\Datatables;

class UserController extends AdminController
{
    //
    protected $userModel;
    protected $roleModel;
    public function __construct(Request $request,User $user,Role $role)
    {
        parent::__construct($request);
        $this->userModel = $user;
        $this->roleModel = $role;
    }

    public function index(){
        return view('admin.system.user.index');
    }
    public function get_list(){
        $data_list = $this->userModel->getList();
        $user_id = Auth::user()->id;
        return Datatables::of($data_list)
            ->editColumn('thumb',function($record){
                if(empty($record->thumb)){
                    return '暂无';
                }else{
                    return '这是头像';
//                    return '<img src="public/headImg/head_img.jpeg" >';
                }
            })
            ->editColumn('sex',function($record){
                if($record->sex == 1){
                    return '男';
                }elseif($record->sex == 2){
                    return '女';
                }else{
                    return '未知';
                }
            })
            ->addColumn('action',function($record) use($user_id){
                $id = Hashids::encode($record->id);
                $edit_menu = '<a  data-id="'.$id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                if($record->is_admin || $user_id == $record->id){
                    $del_menu = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm default"><i class="fa fa-trash-o"></i> 删除 </a>';
                }else{
                    $del_menu = '<a href="javascript:;" data-id="'.$id.'" class="btn  btn-sm red menu_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                }
                return $edit_menu.$del_menu;
            })
            ->make(true);
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name' => $params['name'],
                'email' => $params['email'],
                'password' => bcrypt($params['password']),
                'py'=>pinyin_abbr($params['name']),
                'pinyin'=>pinyin_permalink($params['name'],'')
            ];
            $role_ids = $params['role_id'];
            $insert_user = $this->userModel->insertUser($data,$role_ids);
            if($insert_user){
                return response()->json(['status'=>1,'action'=>'add']);
            }else{
                return response()->json(['status'=>0,'action'=>'add']);
            }

        }else{

            $role_list = $this->roleModel->getList();
            $role_list_arr = obj_to_array($role_list);
//            $array = array();
//            foreach($role_list_arr as $r) {
//                $r['cname'] =  $r['name'];
//                $r['selected'] = $r['id'] == $request->get('parent_id') ? 'selected' : '';
//                $array[] = $r;
//            }
//            $data['select_categorys'] = $array;
            $data['role_list'] = $role_list;
            return  view('admin.system.user.add',$data);
        }
    }
    public function edit(Request $request){
        $hashid = $request->get('id');
        $id = Hashids::decode($hashid)[0];
        if($request->isMethod('post')){
            $params = $request->all();
            $data = [
                'name' => trim($params['name']),
                'email' => trim($params['email']),
                'password' => bcrypt($params['password']),
                'py'=>pinyin_abbr($params['name']),
                'pinyin'=>pinyin_permalink($params['name'],''),
                'nickname'=>$params['nickname']
            ];
            $role_ids = $params['role_id'];
            $insert_user = $this->userModel->updateUser($data,$role_ids,$id);
            if($insert_user){
                return response()->json(['status'=>1,'action'=>'add']);
            }else{
                return response()->json(['status'=>0,'action'=>'add']);
            }
        }else{
            $role_list = $this->roleModel->getList();
            $user_role = $this->userModel->userRoles($id);
            $user_info = $this->userModel->getInfoById($id);
            $role_list_arr = obj_to_array($role_list);
            //循环的时候，是可以将对象的值进行改变的
            foreach($role_list as  $v){
                $v->selected = in_array($v->id,$user_role) ? "selected":'';
            }
            $data['role_list'] = $role_list;
            $data['info'] =$user_info;
            $data['user_id'] = $hashid;
            return  view('admin.system.user.edit',$data);
        }
    }
    public function del(Request $request){

        $id = $request->get('id');
        $id = Hashids::decode($id)[0];
        $menu_info = $this->userModel->getInfoById($id);
        if(!empty($menu_info)){
            $del_status = $this->userModel->delUser($id);
            if($del_status)
            {
                $data = ['status'=>true,'msg'=>'删除成功'];
            }else{
                $data = ['status'=>false,'msg'=>'删除失败'];
            }
        }else{
            $data = ['status'=>false,'msg'=>'删除失败'];
        }
        return response()->json($data);
    }
    /**
     * 检查新用户是否存在
     */
    public function check_exists(Request $request){
        $email = '';
        $name = '';
        $id = $request->get('user_id');

        if(strlen($id) > 15){
            $id = Hashids::decode($id)[0];
        }
        if($request->has('email')){
            $email = $request->get('email');
        }
        if($request->has('name')){
            $name = $request->get('name');
        }
        $is_exist = $this->userModel->checkUserExists($name,$email,$id);
        if($is_exist){
            return json_encode(false);
        }else{
            return json_encode(true);
        }
    }
}
