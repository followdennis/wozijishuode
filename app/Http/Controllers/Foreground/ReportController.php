<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\ArticleOrCommentReport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    //
    public function __construct()
    {
    }
    //投诉或留言添加添加2018-02-28 23:37:00 by dennis
    public function add(Request $request){
        $this->validate($request,[
            'description'=>'required|max:255',
            'type'=>'required|integer',// 1 文章举报 2 评论举报
            'article_id'=>'required|hashid',
            'comment_id'=>'required|integer',
        ]);
        $params = $request->all();
        $data = [
            'type'=>$params['type'],
            'description'=>$params['description'],
            'article_id'=>\Hashids::decode($params['article_id'])[0],
            'comment_id'=>$params['comment_id'],
            'user_id'=>Auth::guard('front')->user()->id,
            'user_name'=>Auth::guard('front')->user()->name,
        ];
        $result = ArticleOrCommentReport::create($data);
        if($result){
            return response()->json(['state'=>1,'msg'=>'发布成功'],200);
        }else{
            return response()->json(['state'=>0,'msg'=>'发布失败'],500);
        }
    }
}
