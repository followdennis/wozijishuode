<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Models\Menus;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Tree;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class IndexController extends AdminController
{
    //
    public function __construct(Request $request)
    {
        parent::__construct($request);

    }

    //后台功能实现
    public function index(Request $request){
        $data['name'] = 'bb';
//        $list = $this->menusModel->getAllList();
//        $tree = new Tree();
//        $new_list = $tree->tree($list);
//        $tree->makehtml($new_list);
//        $data['menu'] = $tree->str;

        return view('admin.main.index',$data);
    }
    public function add_role(){


//        $admin = new Role();
//        $admin->name = 'admin';
//        $admin->display_name = 'User Administrator';
//        $admin->description = 'User is allowed to manage and edit other users';
//        $admin->save();

//        $user = User::where('name','admin')->first();
//        $user->attachRole(2);
        //这个添加方法也可以
//        $user->roles()->attach($admin->id); //只需传递id即可

//        $editUser = new Permission();
//        $editUser->name = 'edit-user';
//        $editUser->display_name = 'Edit Users';
//        $editUser->description = 'edit existing users';
//        $editUser->save();

          //给角色添加权限
//        $owner = Role::where('name','admin')->first();
//        $owner->attachPermission(1);
        //另一种写法，多权限
//        $admin = Role::where('name','admin')->first();
//        $admin->perms()->sync([1,2]);

        //检查权限角色
       $user = User::find(2);
//
//       if($user->hasRole('owner')){
//           echo 'yes';
//       }else{
//           echo 'no';
//       }

        if($user->hasRole('admin')){
            echo 'yes';
        }else{
            echo 'no';
        }
        if($user->can('edit-user')){
            echo 'yes permission';
        }else{
            echo 'no permission';
        }

//        $user->hasRole(['owner', 'admin'], true); //同时具有角色的时候，才显示true
//        $user->can(['edit-user', 'create-post'], true); // false //同时具有多个权限的时候才显示true
        echo "<br/>".Auth::user()->name."<br/>";
        if(Auth::user()->can('create-post')){
            echo 'i have perms';
        }else{

            echo 'i don.t have';
        }
    }
    public function file_upload(){
        return view('admin.carousel.index');
    }

    public function upload(Request $request){

        if($request->ajax()){

//            $data['data'] = ['name'=>'xiaoming','Id'=>'123','error'=>'','msg'=>'成功'];
//            Log::info('abc');
//            return response()->json($data);
        }
        else
        {

            $data['data'] = ['name'=>'xiaoming','Id'=>'123','error'=>'','msg'=>'成功'];

            return response()->json($data);
        }

    }
}
