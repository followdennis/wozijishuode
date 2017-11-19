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
use Illuminate\Support\Facades\DB;
class ArticleAll extends Model
{
    protected $table = 'article';

    public function getList(){
        $record = DB::table($this->table)
            ->select('id','title','author','author_id','description','tags_name','inner_link_name','inner_link_id','cate_name','cate_id','is_show','click','like','created_at')
            ->where('is_show',0)
            ->orderBy('id','desc');
        return $record;
    }
    public function delData($id = 0){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $status = DB::table($this->table)->where('id',$id)->update(['deleted_at'=>$now,'is_show'=>1]);//1表示删除
        return $status;
    }
    public function getInfoById($id){
        return DB::table($this->table)
            ->select([
                'id',
                'title',
                'author',
                'author_id',
                'tags_id',
                'inner_link_id',
                'inner_link_name',
                'cate_name',
                'cate_id',
                'click',
                'like',
                'created_at',
                'updated_at'
            ])
            ->where('is_show',0)->find($id);//这里的0表示显示文章
    }
}