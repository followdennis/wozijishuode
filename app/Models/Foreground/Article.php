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

    public function getArticleList(){
        $data = self::where('is_show',1)
            ->select(['id','title','author','tags_name','description','created_at','click','like','img'])
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
