<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tags extends Model
{
    use SoftDeletes;
    //
    protected $table='tags';
    protected $guarded = [];
    //获取单条数据
    public function getInfoById($id){
        $info = self::find($id);
        return $info;
    }
    //获取列表数据
    public function getList(){
        return self::orderBy('id','desc');
    }
    //获取数据列表
    public function getAllList(){
        return self::select('id','name')->get();
    }
    //删除
    public function delData($id){
        return self::destroy($id);
    }
    //添加数据
    public function insertData($params = []){
        return self::insert($params);
    }
    //编辑数据
   public function updateData($params,$id){
        return self::where('id',$id)->update($params);
   }
   public function changeArticleCount($tag_id = [],$num = 1){
        if($num >0 ){
            return self::whereIn('id',$tag_id)->increment('article_count');
        }else{
            return self::whereIn('id',$tag_id)->decrement('article_count');
        }
   }

}
