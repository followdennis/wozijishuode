<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class Tree extends Model
{
    //
    public $arr = array();
    public $icon = array('└─ ','├─ ','│　 ');
    public $ret = '';
    public $nbsp = "&nbsp;&nbsp;";
    public $str;


    public function init($arr=array()) {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }
    public function makehtml($arr = array(),$level = 0){
        if(!is_array($arr)){
            return false;
        }
        $route = Route::currentRouteName();
        $route = trim($route,'/');


        if($level == 0){
//            $this->str .= "<ul class=\"sidebar-menu\" id=\"nav-accordion\">";
            $this->str = "<ul class=\"sidebar-menu \" id=\"nav-accordion\">

                <p class=\"centered\"><a href=\"http://www.wozijishuode.com/back\"><img src=\"http://www.wozijishuode.com/admin/assets/img/ui-sam.jpg\" class=\"img-circle\" width=\"60\"></a></p>
                <h5 class=\"centered\">Marcel Newman</h5>";
        }else{
            $this->str .= "<ul class='treeview-menu '>";
        }
        foreach($arr as $k => $v){
            @extract($v);
            if(!empty($route_params))
            {
                parse_str($route_params,$route_params);
            }
            $route_name = trim($route_name,'/');
            $menu_url = '';

            if($route_name != '' && Route::has($route_name))
            {
                if(!empty($route_params)){
                    $menu_url = $route_name ? route($route_name,$route_params) : '';
                }else{
                    $menu_url = $route_name ? route($route_name) : '';
                }
            }

            //本身叶子节点节点选中
            $class_active = '';
            if(!empty($route) && $route_name == $route){
               $class_active = " class='active' ";
            }
            $ul_open = '';
            $li_active = '';
            if(!empty($route) && in_array(1,$this->checkChildrenClick($v,$route))){
                $ul_open = " menu-open ";
                $li_active = ' active ';
            }
            if(isset($v['children'])){

                $this->str .= "<li class='treeview".$li_active."'><a href='".$menu_url."'>
                        <i class='fa ".$v['icon']."'></i> <span>".$v['name']."</span>
                        <i class='fa fa-angle-left pull-right'></i>
                    </a>";
                $this->makehtml($v['children'],$level+1);
                $this->str.= "</li>";
            }else{
                $this->str .= "<li ".$class_active.">
                            <a href='".$menu_url."'>
                                <i class='fa ".$v['icon']."'></i>".$v['name']."
                            </a></li>";
            }
        }
        $this->str .= "</ul>";
    }

    public function checkChildrenClick($arr,$current_route,$recursion=false){
        global $selected;
        if($recursion == false){
            $selected = [];
        }
        if(isset($arr['children']) && is_array($arr['children'])){
            foreach($arr['children'] as $id => $item){
                if($current_route == trim($item['route_name'])){
                    $selected[] = 1;
                }else{
                    $selected[] = 0;
                }
                if(isset($arr['children']) && is_array($arr['children'])){
                    $this->checkChildrenClick($item,$current_route,true);
                }
            }
        }
        return $selected;
    }
    public function checkChildrenSelected($tree_part,$current_route,$recursion=false)
    {
        global $selected;
        if($recursion == false)
        {
            $selected = [];
        }

        return $selected;
    }
    public function tree($arr , $parentId = 0 ,$level = 0, $pk = 'id'){

        $children = array_filter($arr ,function($val) use($parentId){
            return $val['parent_id'] == $parentId;
        });

        $pc = [];
        foreach($children as $child){
            $cpid = $child[$pk];
            $grandson = $this->tree($arr,$cpid,$level+1,$pk);
            $newChild = $child;
            $newChild['text'] = $child['name'];
            $newChild['level'] = $level;
            if(!empty($grandson)){
                $newChild['children'] = $grandson;
            }
            array_push($pc,$newChild);
        }
        return $pc;
    }

    public function tree2($data , $id = 0,$lev = 0, $pk = 'cate_id'){
        static $son = array();
        foreach($data as $key => $val){
            if($val['parent_id'] == $id){
                $val['lev'] = $lev;
                $son[] = $val;
                $this->tree2($data, $val['cate_id'] , $lev+1);
            }
        }
        return $son;
    }

    /**
     * 菜单列表中使用的tree
     * @param $data
     * @param int $id
     * @param int $lev
     * @param string $pk
     * @return array
     */
    public function tree_menu($data , $id = 0,$lev = 0, $pk = 'id'){
        static $son = array();
        foreach($data as $key => $val){
            if($val['parent_id'] == $id){
                $val['lev'] = $lev;
                $son[] = $val;
                $this->tree_menu($data, $val['id'] , $lev+1);
            }
        }
        return $son;
    }

    /**
     * @param $myid
     * @param $str 格式如  "\$spacer\$name"
     * @param int $sid
     * @param string $adds
     * @param string $str_group
     * @return array
     */
    public function get_menu_tree($myid, $str, $sid = 0, $adds = '', $str_group = '') {
        $number = 1;
        //一级栏目
        static $son = array();
        $child = $this->get_child($myid);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $value) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[0];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[2] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                $selected = $id == $sid ? 'selected' : '';
                @extract($value);
                $parent_id == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
//                $this->ret .= $nstr;
                $data = $value;
                $data['name'] = $nstr;
                $son[] = $data;
                $nbsp = $this->nbsp;
                $this->get_menu_tree($id, $str, $sid, $adds . $k . $nbsp, $str_group);
                $number++;
            }
        }
        return $son;
    }

    /**
     * 得到树型结构
     * @param int ID，表示获得这个ID下的所有子级
     * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
     * @param int 被选中的ID，比如在做树型下拉框的时候需要用到
     * @return string
     */
    public function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = ''){
        $number=1;
        $child = $this->get_child($myid);

        if(is_array($child)){
            $total = count($child);
            foreach($child as $id=>$value){
                $j=$k='';
                if($number==$total){
                    $j .= $this->icon[0];
                }else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[2] : '';
                }
                $spacer = $adds ? $adds.$j : '';
                $selected = $id==$sid ? 'selected' : '';
                @extract($value);
                $parent_id == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $nbsp = $this->nbsp;
                $this->get_tree($id, $str, $sid, $adds.$k.$nbsp,$str_group);
                $number++;
            }
        }
        return $this->ret;
    }
    /**
     * 寻找祖先
     */
    public function Ancestry($data,$pid,$pk = 'cate_id'){
        static $ancestry = [];
        foreach($data as $key => $val){
            if($val[$pk] == $pid){
                //下面两行调换会改变顺序
                $this->Ancestry($data, $val['parent_id']);
                $ancestry[] = $val;
            }
        }
        return $ancestry;
    }

    public function get_child($myid) {
        $a = $newarr = array();
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {
                if ($a['parent_id'] == $myid)
                    $newarr[$id] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 结构化之后的数据
     */
    public function get_children(){

    }
}
