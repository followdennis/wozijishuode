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
    protected $appends = ['hash_id'];
    //自定义属性 hashId
    public function getHashIdAttribute(){
        return $this->attributes['hash_id'] = \Hashids::encode($this->id);
    }
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
        if($browse){
            $browse = array_count_values($browse);
            arsort($browse);
            $browse = array_keys($browse);
        }
        if($is_login){
            $article_ids = \DB::table('browse')->where('user_id',$user_id)
                ->whereRaw('DATE_SUB(CURDATE(), INTERVAL 60 DAY) <= date(created_at)') //最近60天的数据
                ->groupBy('article_id')->orderByRaw('count(*) desc')->select('article_id')->pluck('article_id')->toArray();

            if(count($article_ids) < 15 && $browse){
                $article_ids = array_merge($article_ids,$browse);
                $article_ids = array_unique($article_ids);
                $article_ids = array_slice($article_ids,0,20);//筛选最新的20篇文章
            }

            $tag_ids = \DB::table('tags_articles')->whereIn('article_id',$article_ids)->groupBy('tag_id')->pluck('tag_id')->toArray();
        }else{
            $article_ids = $browse;
            $tag_ids = \DB::table('tags_articles')->whereIn('article_id',$article_ids)->groupBy('tag_id')->pluck('tag_id')->toArray();
        }
        return self::where('is_show',1)
            ->with('cate')
            ->where('id','<>',$article_id)
            ->where(function($query) use($tag_ids){
            if(!empty($tag_ids)){
                foreach($tag_ids as $tag_id){
                    $query->orWhereRaw("find_in_set('".$tag_id."',tags_id)");
                }
            }
        })
            ->orderBy('click','desc')
            ->take(6)->select(
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
    public function tags(){
        return $this->belongsToMany('App\Models\ArticleManage\Tags','tags_articles','article_id','tag_id')->wherePivot('deleted_at',null);
    }

}
