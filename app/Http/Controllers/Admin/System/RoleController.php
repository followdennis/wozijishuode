<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\Menus;
use App\Models\Role;
use App\Services\RoleMenu;
use App\Services\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class RoleController extends AdminController
{
    //
    public $roleModel;
    public $menusModel;
    public $rolemenuService;
    public function __construct(Request $request,Role $role,\App\Models\System\Menus $menus,RoleMenu $rolemenu)
    {
        parent::__construct($request);
        $this->roleModel = $role;
        $this->menusModel= $menus;
        $this->rolemenuService = $rolemenu;
    }

    public function index(){
        return view('admin.system.role.index');
    }
    public function get_list(Request $request){
        $data = $this->roleModel->getAllList();
        return Datatables::of($data)
            ->addColumn('action',function($record){
                $permission_man = '<a data-id="'.$record->id.'" data-name="'.$record->name.'" class="btn  btn-sm blue power_set"><i class="fa fa-gear"></i> 权限设置 </a>';
                $member_man = '<a href="'.route('role/member',['role_id'=>$record->id]).'" class="btn  btn-sm green"><i class="fa fa-user"></i> 成员管理 </a>';
                $role_edit = '<a data-id="'.$record->id.'" data-name="'.$record->name.'" class="btn  btn-sm purple item_edit"><i class="fa fa-edit"></i> 编辑 </a>';
                $role_del = '<a href="javascript:void(0);" data-id="'.$record->id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                return $permission_man.$member_man.$role_edit.$role_del;
            })
            ->filter(function($query) use($request){
                if($request->has('keyword')){
                    $keyword = trim($request->get('keyword'));
                    $query->where('name','like','%'.$keyword.'%');
                }
            })
            ->make(true);
    }
    public function add(Request $request){
        if($request->isMethod('post')){
            $params = $request->all();
            $status = $this->roleModel->insertRole($params);
            if($status)
            {
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }
            return response()->json($data);
        }else{
            return view('admin.system.role.add');
        }
    }
    /**
     * 检测角色名称唯一
     * @param Request $request
     * @param Role $role
     * @return string
     */
    public function checkRoleNameUnique(Request $request)
    {
        $id = intval($request->get('id'));
        $name = trim(strval($request->get('name')));
        $isExists = $this->roleModel->checkNameExists($name, $id);
        if($isExists === true )
        {
            return json_encode(false);
        }
        else
        {
            return json_encode(true);
        }
    }
    public function edit(Request $request){
        $id = $request->get('id');
        if($request->isMethod('post')){
            $params = $request->all();
            $status = $this->roleModel->updateRole($params);
            if($status)
            {
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }
            return response()->json($data);
        }else{
            $info = $this->roleModel->getInfoById($id);
            $data['info'] = $info;
            return view('admin.system.role.edit',$data);
        }
    }
    public function  del(Request $request){
        $id = intval($request->get('id'));
        info($id);
        $info = $this->roleModel->getInfoById($id);
        if(!empty($info)){
            $del_status = $this->roleModel->delRole($id);
            if($del_status){
                return response()->json(['status'=>1,'msg'=>'删除成功']);
            }else{
                return response()->json(['status'=>0,'msg'=>'删除失败']);
            }
        }else{
            return response()->json(['status'=>0,'msg'=>'删除失败']);
        }
    }
    /**
     * 设置角色权限
     * @param Request $request
     * @param Role $role
     * @param Menu $menu
     * @param RoleMenu $roleMenu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function power(Request $request)
    {
        $id = intval($request->get('id'));
        if($request->isMethod('post')){
            $id = $request->get('id');
            $permision_id = $request->get('permision_id');
            $state = $this->roleModel->saveRolePermision($id,$permision_id);
            if($state)
            {
                $data = ['status'=>1];
            }else{
                $data = ['status'=>0];
            }
            return response()->json($data);
        }else{
            //角色详情
            $info = $this->roleModel->getInfoById($id);
            //角色权限ids
            $role_permision_ids = $this->roleModel->getRolePermissionIds($id);
            //获取菜单及权限
            $role_menu_list = $this->menusModel->getAllList();
            $role_menus = [];

            //获取用户权限id列表
            $UserRolePermisionIds = $this->roleModel->getUserRolePermisions();

            foreach ($role_menu_list as $r)
            {
                //登录用户是否拥有权限或是管理员用户角色
                if(in_array($r['permission_id'],$UserRolePermisionIds) || Auth::user()->hasRole('管理员') || Auth::user()->is_admin == 1)
                {
                    $r['cname'] = $r['name'];
                    $r['checked'] = $this->rolemenuService->is_checked($r,$role_permision_ids) ? ' checked' : ''; //检查是否选中
                    $r['level'] = $this->rolemenuService->get_level($r['id'],$role_menu_list);
                    $r['parent_id_node'] = ($r['parent_id'])? ' data-tt-parent-id="'.$r['parent_id'].'"' : '';
                    $role_menus[$r['id']] = $r;
                }
            }
            $Roletree = new Tree();
            $Roletree->icon = array('└─ ','├─ ','│ ');
            $Roletree->nbsp = '&nbsp;&nbsp;&nbsp;';

            $str  = "<tr data-tt-id='\$id' \$parent_id_node>
							<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='permision_id[]' value='\$permission_id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$cname</td>
						</tr>";

            $Roletree->init($role_menus);
            $categorys_html = $Roletree->get_tree(0, $str);

            $data = [];
            $data['info'] = $info;
            $data['categorys_html'] = $categorys_html;
            return  view('admin.system.role.power',$data);
        }
    }
    /**
     * 成员管理
     * @param Request $request
     * @param Role $role
     * @param Site $site
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function member(Request $request)
    {
        $role_id = $request->get('role_id');
        // 实例化分页
        if($request->ajax()){
            info($role_id);
            $list = $this->roleModel->getRoleMemberList($role_id);
            return Datatables::of($list)
                ->addColumn('action',function($record){
                    return '<a href="javascript:void(0);" data-id="'.$record->id.'" data-role_id="'.$record->role_id.'" class="btn  btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a>';
                })
                ->filter(function($query) use($request){
                    if($request->has('keyword')){
                        $keyword = trim($request->get('keyword'));
                        $query->where('u.name','like','%'.$keyword.'%')
                            ->orWhere('u.nickname','%'.$keyword.'%');
                    }
                })
                ->make(true);
        }else{
            $data['role_id'] = $role_id;
            return view('admin.system.role.member',$data);
        }
    }
    /**
     * 删除成员
     */
    public function member_del(Request $request){
        $id = $request->get('id');
        $role_id = $request->get('role_id');
        $del_status = $this->roleModel->memberDel($id,$role_id);
        if($del_status){
            return response()->json(['status'=>1,'msg'=>'删除成员成功']);
        }else{
            return response()->json(['status'=>0,'msg'=>'删除成员失败']);
        }

    }

}
