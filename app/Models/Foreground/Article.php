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
            ->select(['id','title','author','tags_name','description','created_at','click','like','img'])
            ->when($cate_id,function($query) use($cate_id){
                $query->where('cate_id',$cate_id);
            },function($query){
                $query->where('cate_id',-1);
            })
            ->orderBy('id','desc')
            ->take(20)
            ->with('category')
            ->get();
        return $data;
    }

    public function category(){
        return $this->belongsTo('App\Models\Foreground\Category','cate_id')->withDefault(function($category){
            $category->pinyin = 'default';
        });
    }
}
