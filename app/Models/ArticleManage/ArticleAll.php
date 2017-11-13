<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/11/13
 * Time: 22:46
 */
namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ArticleAll extends Model
{
    protected $table = 'article';

    public function getList(){
        $record = DB::table($this->table)
            ->select('id','title','author','author_id','description','tags_name','inner_link_name','inner_link_id','cate_name','cate_id','is_show','click','like','created_at')
            ->orderBy('id','desc');
        return $record;
    }
}