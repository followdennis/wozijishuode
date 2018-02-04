<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    protected $cate_key_val = [];
    public function __construct()
    {

    }
    public function nav(){
        $category = new Category();
        return $category->getList();
    }
    //定义键值对的 cate拼音
    public function getCategoryArr(){
        $category = new Category();
        $list = $category->getListData();
        $cate_arr = [];
        foreach($list as $cate){
            $this->cate_key_val = [];
            $this->Ancestry($cate['id'],$list);
            $cate_arr[$cate['id']] = implode('_',$this->cate_key_val);
        }
        return $cate_arr;
    }
    //热门文章
    public function hot(){

    }
    //热门标签
    public function tags(){

    }
    //推荐
    public function recommend(){

    }
    //友情链接
    public function friendLink(){

    }
    //遍历树结构
    public function treeLoop($arr = array(),$level = 0){
        if(empty($arr)){
            return '数据不能为空';
        }

        foreach($arr as $item){
            if($item['is_leaf']){
                $this->cate_key_val[$item['id']] = $item['pinyin'];
            }else{
                $this->treeLoop($item['children'],$level+1);

            }
        }
    }
    public function Ancestry($id = 0,$arr = []){
        foreach($arr as $key => $val){
            if($val['id'] == $id){
                $parent_id = $val['parent_id'];
                array_unshift($this->cate_key_val,$val['pinyin']);
                if($parent_id >  0){
                    unset($arr[$id]);
                    $this->Ancestry($parent_id,$arr);
                }
            }
        }
    }

    //第二种tree算法,通过child来拼接
    public function tree($arr = [],$parent_id = 0){
        $children = array_filter($arr,function($val) use($parent_id){
            return $val['parent_id'] == $parent_id;
        });
        $newArr = [];
        foreach($children as $child){
            $grandson = $this->tree($arr,$child['id']);
            if(count($grandson) > 0 ){
                $child['is_leaf'] = 0;
                $child['children'] = $grandson;
            }else{
                $child['is_leaf'] = 1;
            }
            $newArr[] = $child;
        }
        return $newArr;
    }
}
