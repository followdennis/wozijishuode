<?php

namespace App\Http\Controllers\WeChat;

use App\Models\ArticleManage\ArticleAll;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function index(){
        $data = ArticleAll::paginate(10);
        $item = [];
        foreach($data as $k => $v){
            array_push($item,[
                'id'=>$v->id,
                'title'=>$v->title,
                'cate_name'=>$v->cate_name
            ]);
        }
        return response()->json($item);
    }
}
