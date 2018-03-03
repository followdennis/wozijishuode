<?php

namespace App\Models\Foreground;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use SoftDeletes;
    protected $table = 'article';

    public function getArticleList($cate_id = 0){
        $data = self::where('is_show',1)
            ->select(['id','title','author','tags_name','description','created_at','post_time','click','like','img','comments_count'])
            ->when($cate_id,function($query) use($cate_id){
                $query->where('cate_id',$cate_id);
            },function($query){
                $query->where('cate_id',-1);
            })
            ->orderBy('id','desc')
            ->paginate(20);
        return $data;
    }
    public function getRecommends(){
        return self::where('recommend',1)->where('is_show',1)->take(6)->select(
            ['id','title','author','author_id','description','tags_name','tags_id','click','like','comments_count','post_time','img']
        )->get();
    }
    public function category(){
        return $this->belongsTo('App\Models\Foreground\Category','cate_id')->withDefault(function($category){
            $category->pinyin = 'default';
        });
    }
}
