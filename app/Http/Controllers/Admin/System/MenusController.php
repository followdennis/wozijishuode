<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\System\Menus;
use App\Services\Tree;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class MenusController extends AdminController
{
    //
    protected $menuModel;
    public function __construct(Request $request,Menus $menus)
    {
        parent::__construct($request);
        $this->menuModel = $menus;
    }

    public function index(){
        return view('admin.system.menu.menu');
    }
    public function get_list(Request $request){
        $data_list = $this->menuModel->getList();
        $json =  Datatables::of($data_list)
            ->editColumn('is_show',function($record){
                if($record->is_show == 1){
                    return '是';
                }else{
                    return '否';
                }
            })
            ->addColumn('action',function($record){
                $add_menu =  '<a data-id="'.$record->id.'" class="btn btn-sm green item_add"><i class="fa fa-plus"></i> 添加子菜单 </a>';
                $edit_menu = '<a  data-id="'.$record->id.'" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>';
                $del_menu = '<a href="javascript:;" data-id="'.$record->id.'" class="btn dark btn-sm red menu_del"><i class="fa fa-trash-o"></i> 删除 </a>';

                return $add_menu.$edit_menu.$del_menu;
            })
            ->make(true);
            $json = htmlspecialchars_decode($json);//防止无法解析其中的引号
            preg_match('/{.*/',$json,$out);//把json的请求头过滤掉
            $m = $out[0];
            $new = json_decode($m,true);
            $arr = $new['data'];//这个数据有可能为空，所以要加个判断
            if(!empty($arr)){
                $tree = new Tree();
                $tree->init($arr);
                $str = "\$spacer\$name";
                $tree_new = $tree->get_menu_tree(0,$str);
                $new['data'] = $tree_new;
            }
            return response()->json($new);
    }
    public function add(Request $request)
    {
        if($request->isMethod('post')){

            $params = $request->all();
            $menu_data = [
                'unique_code'=>Uuid::uuid1()->toString(),
                'parent_id'  => intval($params['parent_id']),
                'name' =>strval(trim($params['display_name'])),
                'icon' => strval(trim($params['icon'])),
                'sort' => intval($params['sort']),
                'is_show' =>isset($params['is_show']) ? 1 : 0,
                'route_params' => $params['route_params'],
            ] ;
            $permission_data = [
                'name' =>trim($params['permissions_name']),
                'display_name' => trim($params['permissions_display_name']),
                'description' => trim($params['permissions_description'])
            ];
            //新增
            $data = $this->menuModel->addMenu($menu_data,$permission_data);
            return response()->json($data);
//            return response()->json(['state'=>1,'action'=>'add']);
        }else{
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $menu_list = $this->menuModel->getAllList();
            $array = array();
            foreach($menu_list as $r) {
                $r['cname'] =  $r['name'];
                $r['selected'] = $r['id'] == $request->get('parent_id') ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);
            $data['select_categorys'] = $select_categorys;
            return  view('admin.system.menu.add',$data);
        }
    }
    /**
     * 菜单编辑
     * @param Menu $menu
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = intval($request->get('id'));
        if($request->isMethod('post')){
            $params = $request->all();
            $menu_data = [
                'unique_code'=>Uuid::uuid1()->toString(),
                'parent_id'  => intval($params['parent_id']),
                'name' =>strval(trim($params['display_name'])),
                'icon' => strval(trim($params['icon'])),
                'sort' => intval($params['sort']),
                'is_show' =>isset($params['is_show']) ? 1 : 0,
                'route_params' => $params['route_params'],
            ] ;
            $permission_data = [
                'name' =>trim($params['permissions_name']),
                'display_name' => trim($params['permissions_display_name']),
                'description' => trim($params['permissions_description'])
            ];

            //编辑
            $data = $this->menuModel->updateMenu($id,$menu_data,$permission_data);
            return response()->json($data);
        }else{
            $tree = new Tree();
            $tree->icon = array('└ ','├ ','│');
            $menu_list = $this->menuModel->getAllList();
            $array = array();
            $menu_info = $this->menuModel->getInfoById($id);
            foreach($menu_list as $r) {
                $r['cname'] =  $r['name'];
                $r['selected'] = $r['id'] == $menu_info->parent_id ? 'selected' : '';
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
            $tree->init($array);
            $select_categorys = $tree->get_tree(0, $str);


            $data['select_categorys'] = $select_categorys;
            $data['info'] = $menu_info;
            return  view('admin.system.menu.edit',$data);
        }

    }

    /**
     * 软删除菜菜
     * @param Request $request
     * @param Menu $menu
     * @return array
     */
    public function del(Request $request)
    {
        $id = intval($request->get('id'));
        $menu_info = $this->menuModel->getInfoById($id);
        if(!empty($menu_info)){
            $del_status = $this->menuModel->delMenu($id);
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
}
