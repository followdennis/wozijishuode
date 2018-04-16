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
    public function getRecommends($is_login,$user_id,$browse,$article_id){
        if($is_login){
            $article_ids = \DB::table('browse')->where('user_id',$user_id)->groupBy('article_id')->select(['article_id'])->pluck('article_id')->toArray();
            $tag_ids = \DB::table('tags_articles')->whereIn('article_id',$article_ids)->groupBy('tag_id')->pluck('tag_id')->toArray();
        }else{
            $browse = array_count_values($browse);
            arsort($browse);
            $article_ids = array_keys($browse);
            $tag_ids = \DB::table('tags_articles')->whereIn('article_id',$article_ids)->groupBy('tag_id')->pluck('tag_id')->toArray();
        }

        return self::where('recommend',0)
            ->where('is_show',1)
            ->with('cate')
            ->where('id','<>',$article_id)
            ->where(function($query) use($tag_ids){
            if(!empty($tag_ids)){
                foreach($tag_ids as $tag_id){
                    $query->orWhereRaw("find_in_set('".$tag_id."',tags_id)");
                }
            }
        })->take(6)->select(
            ['id','title','author','author_id','description','tags_name','tags_id','cate_id','click','like','comments_count','post_time','img']
        )->get();
    }
    public function category(){
        return $this->belongsTo('App\Models\Foreground\Category','cate_id')->withDefault(function($category){
            $category->pinyin = 'default';
        });
    }
    public function cate(){
        return $this->hasOne('App\Models\Foreground\Category','id','cate_id')->withDefault(function($cate){
            $cate->pinyin = 'default';
        });
    }

}
