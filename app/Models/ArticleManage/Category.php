<?php

namespace App\Models\ArticleManage;

use App\Services\Utils;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;
    protected $table='category';

    public function getList(){
        return self::select('*');
    }
    //获取分类选项
    public function getCateList(){
        $list_arr = self::select(['id','name','parent_id'])->get();
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
        return $list;
    }
    public function getFieldList(){
        return self::select('id','name','parent_id')->get();
    }
    public function getAllList(){
        $list_arr = self::orderBy('is_show','desc')->get();
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
            if(empty($list)){
                $list = [];
            }
        }

        return $list;
    }
    public function getInfoById($id){
        return self::find($id);
    }
    public function insertData($data){
        return \DB::table($this->table)->insert($data);
    }
    public function delData($id){
        return self::destroy($id);
    }
    public function updateData($data,$id){
        return self::where('id',$id)->update($data);
    }
}
