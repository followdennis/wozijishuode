<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\ArticleAll;
use App\Models\ArticleManage\Tags;
use App\Models\Foreground\Category;
use App\Models\System\FriendLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    protected $cate_key_val = [];
    public function __construct(Request $request)
    {
        $this->middleware(function($request,$next){
            $this->tags();
            $this->hot();
            $this->recommend();
            $is_login = Auth::guard('front')->check() ? 1:0;

            view()->share(['is_login'=>$is_login]);
            return $next($request);
        });

    }
    public function nav(){
        $category = new Category();
        return $category->getList();
    }
    //定义键值对的 cate拼音
    public function getCategoryArr(){
        $category = new Category();
        $list = $category->getListData();
        $cate_arr = [];
        foreach($list as $cate){
            $this->cate_key_val = [];
            $this->Ancestry($cate['id'],$list);
            $cate_arr[$cate['id']] = implode('_',$this->cate_key_val);
        }
        return $cate_arr;
    }
    public function getCateKeyVal(){
        $arr = Category::where('is_show',1)->pluck('pinyin','id')->toArray();
        return $arr;
    }
    //面包屑导航
    public function breadCrumb($cate_id = 23,$article_title = '标题'){
        $category = new Category();
        $list = $category->getListData();
        $cate_arr = $this->getAncestry($list,$cate_id);
        array_unshift($cate_arr,[
            'name'=>'首页',
            'pinyin'=>'/',
            'prefix'=>''
        ]);
        array_push($cate_arr,[
            'name'=> $article_title,
            'pinyin'=>'/',
            'is_title'=>1
        ]);
        return $cate_arr;
    }
    public function getAncestry($list = [],$cate_id){
        static $bread_arr = [];
        foreach($list as $k => $item){
            if($cate_id == $item['id']){
                array_unshift($bread_arr,$item);
                if($item['parent_id'] > 0){
                    $this->getAncestry($list,$item['parent_id']);
                }
            }
        }
        return $bread_arr;
    }
    //热门文章
    public function hot(){
        $cates = $this->getCategoryArr();
        $hots = ArticleAll::where('is_show',1)->orderBy('id','desc')->orderBy('click','desc')->take(8)->get();
        foreach($hots as $hot){
            $hot->cate_pinyin = isset($cates[$hot->cate_id]) ? $cates[$hot->cate_id]: 'default';
        }
        return view()->share(['hots'=>$hots]);
    }
    //热门标签
    public function tags(){
        $style = [
            'label label-default',
            'label label-primary',
            'label label-success',
            'label label-info',
            'label label-warning',
            'label label-danger'
        ];
        $tags = Tags::where('is_show',1)->orderBy('created_at','desc')->orderBy('click','desc')->select('id','name')->take(20)->get();
        foreach($tags as $tag){
            $key = $tag->id%6;
            $tag->style = $style[$key];
        }
        return view()->share(['tags'=>$tags]);
    }
    //推荐
    public function recommend(){
        $sub = \DB::table('article')->where('is_show',1)->select('id','title','cate_id')->orderBy('id','desc')->take('100');
        $results = \DB::table(\DB::Raw('('.$sub->toSql().')'.' as '.\DB::getTablePrefix().'temp'))
            ->mergeBindings($sub)
            ->inRandomOrder()
            ->take(8)->get();
        $cates = $this->getCategoryArr();
        foreach($results as $hot){
            $hot->cate_pinyin = isset($cates[$hot->cate_id]) ? $cates[$hot->cate_id]: 'default';
        }
        return view()->share(['recommend'=>$results]);
    }
    //友情链接
    public function friendLink(){
        $links = FriendLink::where('is_front',1)->orderBy('sort','desc')->select(['name','link_url','description'])->take(5)->get();
        return view()->share(['friend_links'=>$links]);
    }
    //遍历树结构
    public function treeLoop($arr = array(),$level = 0){
        if(empty($arr)){
            return '数据不能为空';
        }

        foreach($arr as $item){
            if($item['is_leaf']){
                $this->cate_key_val[$item['id']] = $item['pinyin'];
            }else{
                $this->treeLoop($item['children'],$level+1);
            }
        }
    }
    public function Ancestry($id = 0,$arr = []){
        foreach($arr as $key => $val){
            if($val['id'] == $id){
                $parent_id = $val['parent_id'];
                array_unshift($this->cate_key_val,$val['pinyin']);
                if($parent_id >  0){
                    unset($arr[$id]);
                    $this->Ancestry($parent_id,$arr);
                }
            }
        }
    }

    //第二种tree算法,通过child来拼接
    public function tree($arr = [],$parent_id = 0){
        $children = array_filter($arr,function($val) use($parent_id){
            return $val['parent_id'] == $parent_id;
        });
        $newArr = [];
        foreach($children as $child){
            $grandson = $this->tree($arr,$child['id']);
            if(count($grandson) > 0 ){
                $child['is_leaf'] = 0;
                $child['children'] = $grandson;
            }else{
                $child['is_leaf'] = 1;
            }
            $newArr[] = $child;
        }
        return $newArr;
    }
}
