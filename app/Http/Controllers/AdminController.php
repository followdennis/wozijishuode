<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\System\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    protected $treeModel;
    protected $menusModel;
    public function __construct(Request $request)
    {
        $this->middleware(function($request,$next){
            $this->treeModel =new Tree();
            $this->menusModel = new Menus();
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
            $data['menus'] = $this->menu($user_id,$user_name);

            view()->share($data);
            return $next($request);
        });
    }

    public function menu($user_id,$username = ''){
        $list = $this->menusModel->getAllMenuList();
        $list_all = $this->menusModel->getAllMenuList(0);
        $role = new Role();
        $user_permission_ids = $role->getUserRolePermisions($user_id);
        $has_permission = [];
        foreach($list as $key => $item){
            if(in_array($item['permission_id'],$user_permission_ids)){
                $has_permission[$item['id']] = $item;
            }
        }

        $this->treeModel->username = $username;
        $parent_id =   Permission::where('permissions.name',Route::currentRouteName())
            ->leftJoin('menus','menus.permission_id','=','permissions.id')
            ->value('parent_id');

        $bread = $this->treeModel->Ancestry($list_all,$parent_id,'id');
        $this->treeModel->currentArr = $bread;
        $new_list = $this->treeModel->tree($has_permission);
        $new_list = $this->treeModel->makehtml($new_list);
        $menu = $this->treeModel->str;
        return $menu;
    }

}
