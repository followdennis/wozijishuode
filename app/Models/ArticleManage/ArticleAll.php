<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/13
 * Time: 22:46
 */
namespace App\Models\ArticleManage;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class ArticleAll extends Model
{
    use SoftDeletes;
    protected $table = 'article';

    public function getList(){
        $record = DB::table($this->table)
            ->select('id','title','author','author_id','description','tags_name','inner_link_name','inner_link_id','cate_name','cate_id','is_show','click','like','created_at')
            ->whereNull('deleted_at')
            ->orderBy('id','desc');
        return $record;
    }
    public function delData($id = 0){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $status = DB::table($this->table)->where('id',$id)->update(['deleted_at'=>$now,'is_show'=>0]);//1表示删除
        return $status;
    }
    public function getInfoById($id){
        return DB::table($this->table)
            ->select([
                'id',
                'title',
                'keywords',
                'author',
                'author_id',
                'tags_id',
                'tags_name',
                'inner_link_id',
                'inner_link_name',
                'is_show',
                'post_time',
                'cate_name',
                'description',
                'cate_id',
                'click',
                'like',
                'created_at',
                'updated_at'
            ])->
            whereNull('deleted_at')->find($id);//这里的0表示显示文章
    }
    //更新
    public function editData($params = []){
        return self::where('id',$params['id'])->update($params);
    }
    public function insertData($params = []){
        $params = array_add($params,'created_at',Carbon::now()->format('Y-m-d H:i:s'));
        return self::insert($params);
    }
    //修改显示状态
    public function changeShow($condition = [],$update = []){
        $one = \DB::table($this->table)->where($condition)->first();
        if($one){
            //laravel 的小bug post_time 字段会自动填充
            if($one->post_time != null){
                $update['post_time'] = $one->post_time;
            }
            return \DB::table($this->table)->where($condition)->update($update);
        }
        return false;
    }
    //查询tag_ids
    public function getTagIdsById($id = 0){
        $article = self::where('id',$id)->select('tags_id')->first();
        $tag_ids_arr = [];
        if(!empty($article->tags_id)){
            $tag_ids_arr = explode(',',$article->tags_id);
        }
        return $tag_ids_arr;
    }
    public function cate(){
        return $this->hasOne('App\Models\Foreground\Category','id','cate_id')->withDefault(function($cate){
            $cate->pinyin = 'default';
            $cate->name = '无';
        });
    }
}