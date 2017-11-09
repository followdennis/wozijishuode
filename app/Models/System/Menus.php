<?php

namespace App\Models\System;

use App\Models\Permission;
use App\Services\Utils;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Menus extends Model
{
    //
    use SoftDeletes;
    protected $table = 'menus';

    /**
     * 获取左侧菜单列表
     * @return array
     */
    public function getAllMenuList($is_show = 1){
        return self::leftJoin('permissions as p',function($query){
                $query->on('menus.permission_id','=','p.id');
             })
            ->select('menus.*','p.name as route_name','p.id as permission_id')
            ->when($is_show,function($query) use($is_show){
                $query->where('menus.is_show',$is_show);
            })
            ->get()
            ->toArray();
    }
    public function getMenuListById($user_id = 0){
        return DB::table('users as u')
            ->whereNull('u.deleted_at')
            ->where('u.id',$user_id)
            ->leftJoin('role_user as ru','ru.user_id','=','u.id')
            ->leftJoin('permission_role as pr','pr.role_id','=','ru.role_id')
            ->leftJoin('permissions as p','p.id','=','pr.permission_id')
            ->leftJoin('menus as m','m.permission_id','=','p.id')
            ->where('m.is_show','=',1)
            ->select('m.*','p.name as route_name')
            ->get()
            ->toArray();
    }

    //对象方式获取
    public function getList(){
        $data = DB::table($this->table." as m")
            ->leftJoin('permissions as p',function($query){
                $query->on('p.id','=','m.permission_id');
            })
            ->select('m.*','p.name as permission_name','p.display_name as permission_display_name','p.description as permission_description')
            ->whereNull('deleted_at')
            ->orderBy('sort','desc')
            ->orderBy('created_at');
        return $data;
    }
    //数组方式获取
    public function getAllList(){
//        return self::all()->toArray();
        if(Cache::has('menu_permision_list'))
        {
            $list = Cache::get('menu_permision_list');
        }else {
            $list_arr = DB::table($this->table . " as m")
                ->leftJoin('permissions as p', 'm.permission_id', '=', 'p.id')
                ->select('m.*', 'p.name as permissions_name', 'p.display_name as permissions_display_name', 'p.description as permissions_description')
                ->where('m.deleted_at', null)
                ->orderBy('m.sort', 'desc')
                ->orderBy('m.id', 'desc')
                ->get();
            $list = [];
            if(!empty($list_arr))
            {
                $list_to_arr = $list_arr->toArray();
                foreach ($list_to_arr as $r) {
                    if(is_object($r))
                    {
                        $list[] = Utils::objectToArray($r);
                    }else{
                        $list[] = $r;
                    }
                }
            }
            $left_time = Carbon::now()->addMinute(config('cache.left_time'));
            Cache::put('menu_permision_list',$list,$left_time);
        }
        return $list;
    }
    /**
     * 添加菜单
     * @param $menu_data  菜单信息
     * @param $permission_data 权限信息
     * @return mixed
     */
    public function addMenu($menu_data,$permission_data)
    {
        $data['action'] = 'add';

        if(trim($permission_data['name']) != ''){ //路由不为空
            if(\Route::has(trim($permission_data['name']))) //路由是否已经配置
            {
                $route = route($permission_data['name']);
                preg_match_all("/\{([\w+]+)\}/",$route,$route_var);  //正则不包括 route中的可选参数 ?
                $var_field = [];
                if(!empty($route_var[1])) //存在路由变量
                {
                    parse_str($menu_data['route_params'], $get_params_var);
                    foreach ($route_var[1] as $var)
                    {
                        if(!array_key_exists($var,$get_params_var))

                        {
                            array_push($var_field,$var);
                        }
                    }
                    if(!empty($var_field))
                    {
                        $data['state'] = -3; //缺少路由参数值标值
                        $data['miss_route_var_text'] = "配置路由：".$route."\n 请补充'路由数参'项，缺少变量值：".implode(',',$var_field) ; //缺少路由变量
                    }
                }
            }
        }

        if(!isset($data['state']))
        {

            $permission_id = false;
            $menu_insert_status = true;
            $permission_info = [];
            $permissions = new Permission();

            $now_time = Carbon::now()->format('Y-m-d H:i:s');
            DB::beginTransaction();
            //权限 新建
            $exist_permission = $permissions->where('name',$permission_data['name'])->first();
            $permission_data['created_at'] = $now_time;
            $permission_data['updated_at'] = $now_time;
            if($exist_permission){
                $permission_id = $exist_permission->id;

                $menu_update['updated_at']= $now_time;
                $menu_update['name'] = $menu_data['name'];
                $menu_update['deleted_at'] = null;
                $menu_insert_status = self::withTrashed()->where('permission_id',$permission_id)->update($menu_update);
            }else{
                $permission_id = $permissions->insertGetId($permission_data);
                $menu_data['permission_id'] = $permission_id;

                //菜单 添加
                $menu_data['created_at'] = $now_time;
                $menu_data['updated_at'] = $now_time;
                $menu_insert_status = self::insertGetId($menu_data);
            }
            if ($permission_id && $menu_insert_status) {
                DB::commit();
                if (Cache::has('menu_permision_list')) {
                    Cache::forget('menu_permision_list');
                }
                $data['state'] = 1;
            } else {
                DB::rollback();
                $data['state'] = -2; //添加失败
            }
        }

        return $data;
    }
    public function getInfoById($menu_id){
        return DB::table($this->table.' as m')
            ->leftJoin('permissions as p','m.permission_id','=','p.id')
            ->select('m.*','p.name as permissions_name','p.display_name as permissions_display_name','p.description as permissions_description')
            ->where('m.id',$menu_id)
            ->where('m.deleted_at',null)
            ->orderBy('m.sort', 'asc')
            ->orderBy('m.id', 'desc')
            ->first();
    }

    /**
     *  编辑菜单
     * @param $id
     * @param $menu_data
     * @param $permission_data
     * @return mixed
     */
    public function updateMenu($id,$menu_data,$permission_data)
    {
        $data['action'] = 'edit';

        if(trim($permission_data['name']) != ''){
            if(\Route::has(trim($permission_data['name']))) //路由是否已经配置
            {
                $route = route($permission_data['name']);//由route_uri 修改为route
                preg_match_all("/\{([\w+]+)\}/",$route,$route_var);  //正则不包括 route中的可选参数 ?
                $var_field = [];
                if(!empty($route_var[1])) //存在路由变量
                {
                    parse_str($menu_data['route_params'], $get_params_var);
                    foreach ($route_var[1] as $var)
                    {
                        if(!array_key_exists($var,$get_params_var))
                        {
                            array_push($var_field,$var);
                        }
                    }
                    if(!empty($var_field))
                    {
                        $data['state'] = -3; //缺少路由参数值标值
                        $data['miss_route_var_text'] = "配置路由：".$route."\n 请补充'路由数参'项，缺少变量值：".implode(',',$var_field) ; //缺少路由变量
                    }
                }
            }
        }
        if(!isset($data['state'])){
            $info = $this->getInfoById($id);

            $now_time = Carbon::now()->format('Y-m-d H:i:s');

            $permissions = new Permission();

            DB::beginTransaction();
            //菜单
            $menu_data['updated_at'] = $now_time;
            $update_menu_status = self::where('id',$id)->update($menu_data);

            //权限
            $permission_data['updated_at'] = $now_time;
            $update_permission_status = $permissions->where('id',$info->permission_id)->update($permission_data);

            if($update_menu_status && $update_permission_status)
            {
                $data['state'] = 1;
                DB::commit();
                if(Cache::has('menu_permision_list'))
                {
                    Cache::forget('menu_permision_list');
                }
            }
            else
            {
                DB::rollback();
                $data['state'] = -2; //添加失败
            }
        }
        return $data;
    }
    public function delMenu($id){
//        $del_status = self::where('id',$id)->delete();
        $menu = self::where('id',$id)->find($id);
        $menu->delete();
        if($menu->trashed()){
            if($menu->trashed()){
                if(Cache::has('menu_permision_list'))
                {
                    Cache::forget('menu_permision_list');
                }
                return true;
            }else{
                return false;
            }
        }
    }
    /**
     * 检验菜单是否存在
     */
    public function checkMenuExists($route){
        if(empty($route)){
            return false;
        }
        $info =  DB::table($this->table." as m")
        ->leftJoin('permissions as p','m.permission_id','=','p.id')
            ->where('p.name','=',$route)
            ->first();

        if(empty($info)){
            return false;
        }else{
            return true;
        }
    }

}
