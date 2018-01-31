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
            ->get()->map(function($item){
                return [
                    'id'=>$item->id,
                    'title'=>$item->title,
                    'author'=>$item->author,
                    'tags_name'=>$item->tags_name,
                    'description'=>$item->description,
                    'created_at'=>is_null($item->created_at)? '':Carbon::parse($item->created_at)->toDateString(),
                    'click'=>$item->click,
                    'like'=>$item->like,
                    'img'=>$item->img,
                    'have_img'=>is_null($item->img)? 0 : 1
                ];
            })
            ->toArray();
        return $data;
    }
}
