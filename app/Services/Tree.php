<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    //
    public $str;
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
}
