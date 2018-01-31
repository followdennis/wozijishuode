<?php

namespace App\Models\Foreground;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;
    protected $table = 'category';

    public function getList(){
        $data = self::where('is_show',1)->select('id','name','pinyin','parent_id')->get()->toArray();
        return $this->tree($data,0);

    }
    //效率很低
    public function tree($cates = array(),$parent_id = 0,$level = 0){
        $cate_arr = [];
        foreach($cates as $k =>$cate){
            if($cate['parent_id'] == $parent_id){
                $children = $this->tree($cates,$cate['id']);
                if(count($children) > 0){
                    $cate['children']  = $children;
                    $cate['is_leaf'] = 0;
                }else{
                    $cate['is_leaf'] = 1;
                }
                $cate_arr[] = $cate;
            }
        }
        return $cate_arr;
    }
}
