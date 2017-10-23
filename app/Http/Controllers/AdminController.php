<?php

namespace App\Http\Controllers;

use App\Models\System\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware(function($request,$next){
            $this->treeModel =new Tree();
            $this->menusModel = new Menus();
            $user_id = Auth::user()->id;
            $data['menus'] = $this->menu($user_id);

            view()->share($data);
            return $next($request);
        });

    }

    public function menu($user_id){
        $list = $this->menusModel->getAllMenuList();
//        var_dump(Session::all());
//        $list2 = $this->menusModel->getMenuListById($user_id);

//        $list = collect($list2)->toArray();
        $new_list = $this->treeModel->tree($list);
        $new_list = $this->treeModel->makehtml($new_list);
        $menu = $this->treeModel->str;
        return $menu;
    }

}
