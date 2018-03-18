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
    public function getListData(){
        $data = self::where('is_show',1)->select('id','name','pinyin','parent_id')
            ->get()
            ->map(function($item){
                return ['id'=>$item->id,'name'=>$item->name,'pinyin'=>$item->pinyin,'parent_id'=>$item->parent_id,'prefix'=>'ch/'];
            })
            ->toArray();
        return $data;
    }
    public function getKeyVal($key = 'pinyin',$val = 'id'){
        return self::where('is_show',1)->pluck($val,$key);
    }
    public function getCateDescription($id){
        return self::where('is_show',1)->select('description')->find($id);
    }
    //(限制层级后，效率提升)
    public function tree($cates = array(),$parent_id = 0,$level = 0){
        $cate_arr = [];
        foreach($cates as $k =>$cate){
            if($cate['parent_id'] == $parent_id){
                if($level < 1){
                    $children = $this->tree($cates,$cate['id'],$level +1);
                    if(count($children) > 0){
                        $cate['children']  = $children;
                        $cate['is_leaf'] = 0;
                    }else{
                        $cate['is_leaf'] = 1;
                    }
                }else{
                    $cate['is_leaf'] = 1;
                }
                $cate_arr[] = $cate;
            }
        }
        return $cate_arr;
    }

}
