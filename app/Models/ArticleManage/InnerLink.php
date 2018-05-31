<?php

namespace App\Models\ArticleManage;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InnerLink extends Model
{
    //
    use SoftDeletes;
    protected $table = 'inner_link';
    protected $guarded = [];
    public function getInfoById($id){
        return self::find($id);
    }
    //获取列表数据
    public function getList(){
        return self::orderBy('id','desc');
    }
    public function getListData($query){
        return self::where('name','like','%'.$query.'%')
            ->with(['article'=>function($query){
                $query->select(['id','cate_id','title'])->with('cate:id,pinyin,name');
            }])
            ->select(['id','name','article_id','created_at'])->take(10)->orderBy('id','desc')->get()
            ->map(function($item){
//                $title = mb_substr($item->article->title,0,5,'utf-8');
                $title = str_limit($item->article->title,12);
                return ['id'=>$item->id,
                    'text'=>$item->name." &nbsp;".$title."&nbsp;".$item->article->cate->name,
                    'article_id'=>$item->article_id,
                    'pinyin'=>$item->article->cate->pinyin,
                    'a'=>"<a href='/{$item->article->cate->pinyin}/{$item->article_id}.html'>{$item->name}</a>"
                ];
            });
    }
    //删除
    public function delData($id){
        return self::destroy($id);
    }
    //编辑数据
    public function updateData($params,$id){
        return self::where('id',$id)->update($params);
    }
    //创建或者更新

    public function article(){
        return $this->hasOne('App\Models\ArticleManage\ArticleAll','id','article_id')->withDefault(function($article){
            $article->title = '无对应文章';
        });
    }
}
