<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\Comments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //
    function __construct()
    {
    }
    //添加留言
    public function add(Request $request){
        $this->validate($request,[
            'comment'=>'required|max:400',
            'article_id'=>'required|hashid',
            'parent_id'=>'required|integer'
        ]);
        $params = $request->all();
        $user_id = Auth::guard('front')->user()->id;
        $user_name = Auth::guard('front')->user()->name;
        $article_id = \Hashids::decode($params['article_id'])[0];
        $data = [
            'user_id'=>$user_id,
            'user_name'=>$user_name,
            'comment'=>$params['comment'],
            'article_id'=>$article_id,
            'parent_id'=>$params['parent_id'],
        ];
        $result = Comments::insertGetId($data);
        if($result){
            return response()->json(['state'=>1,'message'=>'评论成功']);
        }else{
            return response()->json(['state'=>0,'message'=>'评论失败']);
        }
    }
    //删除留言
    public function del(Request $request){
        $this->validate($request,[
            'comment_id'=>'required|hashid'
        ]);
        $user_id = Auth::guard('front')->user()->id;
        $comment_id = \Hashids::decode($request->get('comment_id'))[0];
        $comment = Comments::where('user_id',$user_id)->find($comment_id);
        $result = $comment->delete();
        if($result){
            return response()->json(['state'=>1,'message'=>'删除成功']);
        }else{
            return response()->json(['state'=>0,'message'=>'删除失败']);
        }
    }
    //评论点赞
    public function like(Request $request){
        $this->validate($request,[
            'comment_id'=>'required|hashid',
            'article_id'=>'required|hashid'
        ]);
        $user_id = \Hashids::encode(Auth::guard('front')->user()->id);
        $params = $request->all();
        if($request->cookie('comment'.$params['comment_id'].'user'.$user_id)){
            return response()->json(['state'=>0,'msg'=>'您已经赞过此评论']);
        }
        $where = [
            'id'=>\Hashids::decode($params['comment_id'])[0],
            'article_id'=>\Hashids::decode($params['article_id'])[0]
        ];
        $result = Comments::where($where)->increment('like');
        $forever = 30*24*60;
        $cookie = cookie('comment'.$params['comment_id'].'user'.$user_id,1,$forever);
        if($result){
            return response()->json(['state'=>1,'msg'=>'赞'])->withCookie($cookie);
        }else{
            return response()->json(['state'=>0,'msg'=>'点赞失败']);
        }
    }
}
