<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->treeModel =new Tree();
        $this->menusModel = new Menus();
        $data['menus'] = $this->menu();
        view()->share($data);
    }

    public function menu(){
        $list = $this->menusModel->getAllList();

        $new_list = $this->treeModel->tree($list);
        $new_list = $this->treeModel->makehtml($new_list);
        $menu = $this->treeModel->str;
        return $menu;
    }

}
