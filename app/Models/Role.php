<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use SoftDeletes;
    //
    protected $table = 'roles';
    public function getInfoById($id){
        return self::find($id);
    }
    public function getAllList(){
//        return DB::table($this->table)->orderBy('created_at','desc');
        return DB::table($this->table)
            ->where('deleted_at',null)
            ->orderBy('created_at','desc');
    }
    public function getList(){
        return DB::table($this->table)
            ->where('deleted_at',null)
            ->orderBy('created_at','desc')
            ->get()->toArray();
    }

    /**
     * 新增角色
     * @param $params
     * @return bool
     */
    public function insertRole($params)
    {
        $Role = new self();
        $Role->name = trim($params['name']);
        $Role->display_name = trim($params['display_name']);
        $Role->description = trim($params['description']);
        return $Role->save();
    }

    /**
     * 检查角色名称唯一性
     * @param $name
     * @param string $id
     * @return mixed
     */
    public function checkNameExists($name, $id = 0)
    {
        $info = DB::table($this->table)
            ->where('name', $name)
            ->whereNull('deleted_at')
            ->where(function($query) use($id)
            {

                if (intval($id) > 0)
                {
                    info($id);
                    $query->where('id', '<>', $id);
                }
            })
            ->first();
        if(!empty($info))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function updateRole($params){
        //角色权限cache
        if( Cache::has('role_permision_role_id:'.$params['id']) )
        {
            Cache::forget('role_permision_role_id:'.$params['id']);
        }
        //登录用户权限cache
        if( Cache::has('user_role_permision_user_id:'.Auth::user()['id']))
        {
            Cache::forget('user_role_permision_user_id:'.Auth::user()['id']);
        }
        $role = self::find($params['id']);
        $role->name = $params['name'];
        $role->display_name = $params['display_name'];
        $role->description = $params['description'];
        return $role->save();
    }
    public function delRole($id){
        return self::where('id',$id)->delete();
    }
    /**
     * 获取角色权限ids
     * @param $role_id
     * @return array
     */
    public function getRolePermissionIds($id)

    {
        //角色权限cache
        if( Cache::has('role_permision_role_id:'.$id) )
        {
            $ids = Cache::get('role_permision_role_id:'.$id);
        }else{
            $ids = DB::table('permission_role')->where('role_id',$id)->select('permission_id')->pluck('permission_id')->toArray();
            if(!$ids){
                $ids = [];
            }
            $left_time = Carbon::now()->addMinute(config('cache.left_time'));
            Cache::put('role_permision_role_id:'.$id,$ids,$left_time);
        }
        return $ids;
    }
    /**
     * 获取用户权限id列表
     * @param int $user_id 指定用户id [默认登录获取登录用户]
     * @return array
     */
    public function getUserRolePermisions($user_id = 0)
    {
        if($user_id == 0)
        {
            $user_id = Auth::user()['id'];
        }
        //登录用户权限cache
        if( Cache::has('user_role_permision_user_id:'.$user_id) )
        {
            $permision_ids = Cache::get('user_role_permision_user_id:'.$user_id);
        }else{
            //后面的groupby是必要的，当一个用户拥有多个角色的时候，是有可能出现重复重复权限id的
            $permision_ids = DB::table('role_user as ru')
                ->join('permission_role as pr','pr.role_id','=','ru.role_id')
                ->select('pr.permission_id as permission_id')
                ->where('ru.user_id',$user_id)
                ->groupBy('pr.permission_id')
                ->pluck('permission_id')->toArray();
            if(!$permision_ids){
                $permision_ids = [];
            }

            $left_time = Carbon::now()->addMinute(config('cache.left_time'));
            Cache::put('user_role_permision_user_id:'.$user_id,$permision_ids,$left_time);
        }
        return $permision_ids;
    }
    /**
     * 保存角色权限
     * @param $id
     * @param $permision_id
     * @return bool
     */
    public function saveRolePermision($id,$permision_id)
    {
        $info = $this->getInfoById($id);
        if(!empty($info))
        {
            $isRoleExistsPermisions = $this->isRoleExistsPermisions($id);

            //角色用户
            $user_ids = $this->getRoleUserids($id);
            foreach ($user_ids as $user_id)
            {
                if( Cache::has('user_role_permision_user_id:'.$user_id) )
                {
                    Cache::forget('user_role_permision_user_id:'.$user_id);
                }
            }

            DB::beginTransaction();

            $del_status = true;
            if($isRoleExistsPermisions)
            {
                $del_status = DB::table('permission_role')->where('role_id',$id)->delete();
            }
            $insert_status = true;
            if(!empty($permision_id))
            {
                $insert_data = [];
                foreach ($permision_id as $v)
                {
                    array_push($insert_data,['permission_id'=>$v,'role_id'=>$id]);
                }

                $insert_status = DB::table('permission_role')->insert($insert_data);
            }

            if($del_status && $insert_status)
            {
                DB::commit();
                //角色权限cache
                if( Cache::has('role_permision_role_id:'.$id) )
                {
                    Cache::forget('role_permision_role_id:'.$id);
                }
                //登录用户权限cache
                if( Cache::has('user_role_permision_user_id:'.Auth::user()['id']) )
                {
                    Cache::forget('user_role_permision_user_id:'.Auth::user()['id']);
                }
                return true;
            }else{
                DB::rollback();
                return false;
            }
        }
    }
    /**
     * 测试角色是否存在权限
     * @param $id
     * @return mixed
     */
    public function isRoleExistsPermisions($id){
        $info = DB::table('permission_role')->where('role_id',$id)->first();
        if(!empty($info))
        {
            return true;
        }else{
            return false;
        }
    }
    /**
     * 获取角色用户 user_id
     * @param $role_id
     * @return array
     */
    public function getRoleUserids($role_id)
    {
        $list = DB::table('role_user')->where('role_id',$role_id)->get();
        $user_ids = [];
        foreach ($list as $item){
            array_push($user_ids,$item->user_id);
        }
        return $user_ids;
    }
    /**
     * 用户列表
     */
    public function getRoleMemberList($role_id){
        $list = DB::table('role_user as ru')
            ->join('roles as r','ru.role_id','=','r.id')
            ->join('users as u','ru.user_id','=','u.id')
            ->select('u.id as id','u.name as login_name','u.nickname as name','r.name as role_name as role_name','ru.role_id as role_id')
            ->where('role_id',$role_id)
            ->whereNull('u.deleted_at')
            ->orderBy('u.id','DESC');
        return $list;
    }
    /**
     * 删除角色成员
     */
    public function memberDel($id,$role_id){
        return DB::table('role_user')->where(['user_id'=>$id,'role_id'=>$role_id])->delete();
    }
}
