<?php

namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    //
    use SoftDeletes;
    protected $table='article_index';


    public function getIds($cate_id = 0){
        $record = DB::table($this->table)
            ->select('id','cate_id')
            ->orderBy('id','desc')
            ->when($cate_id,function($query) use($cate_id){
                $query->where('cate_id',$cate_id);
            });
        return $record;
    }
    public function getArticleList($ids = []){

    }
    /**
     * @param $id
     */
    public function getArticleById($id){

    }
    //添加一条数据
    public function insertData($params = []){
        if(!isset($params['cate_id'])){
            return false;
        }
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $id = DB::table($this->table)->insertGetId(['cate_id'=>$params['cate_id'],'created_at'=>$now]);
        return $id;
    }
    public function updateData($params = []){
        return self::where('id',$params['id'])->update(['cate_id'=>$params['cate_id']]);
    }
    //删除
    public function delData($id){
        return self::where('id',$id)->update(['deleted_at'=>Carbon::now()->format('Y-m-d H:i:s'),'is_show'=>0]);
    }
    //修改显示状态
    public function changeShow($condition = [],$update){
        return self::where($condition)->update($update);
    }
    //检查文章是否存在
    public function checkArticleExists($cate_id,$id){
        return self::where('cate_id',$cate_id)->where('id',$id)->where('is_show',1)->first();
    }
}
