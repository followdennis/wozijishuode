<?php

namespace App\Services;


class RoleMenu
{
    //
    /**
     *  检查指定菜单是否有权限
     * @param array $data menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    public function is_checked($menu_role,$role_permision_ids)
    {
        if(in_array($menu_role['permission_id'],$role_permision_ids))
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    public function get_level($id,$array=array(),$i=0)
    {
        foreach($array as $n=>$value){
            if($value['id'] == $id)
            {
                if($value['parent_id']== '0') return $i;
                $i++;
                return $this->get_level($value['parent_id'],$array,$i);
            }
        }
    }
}
