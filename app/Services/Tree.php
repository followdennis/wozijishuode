<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

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
    public function makehtml($arr = array()){
        if(!is_array($arr)){
            return false;
        }
        $this->str .= "<ul class='treeview-menu'>";
        foreach($arr as $k => $v){
            if(isset($v['children'])){
                $this->str .= "<li class='treeview'><a href='#'>
                        <i class='fa fa-circle-o'></i> <span>".$v['name']."</span>
                        <i class='fa fa-angle-left pull-right'></i>
                    </a>";
                $this->makehtml($v['children']);
                $this->str.= "</li>";
            }else{
                $this->str .= "<li>
                            <a href='#'>
                                <i class='fa fa-circle-o'></i>".$v['name']."
                            </a></li>";
            }
        }
        $this->str .= "</ul>";

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
     * 菜单中使用的tree
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
}
