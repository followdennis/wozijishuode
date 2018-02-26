<?php

namespace App\Http\Controllers\Foreground;

use App\Models\ArticleManage\Comments;
use App\Repository\ArticleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    //
    protected $articleRep;
    function __construct(Request $request,ArticleRepository $articleRepo)
    {
        $this->articleRep = $articleRepo;
    }
    //添加留言
    public function add(Request $request){
        $this->validate($request,[
            'comment'=>'required|max:400',
            'article_id'=>'required|hashid',
            'comment_id'=>'required|integer',//顶层为0
            'top_comment_id'=>'required|integer',
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
            'parent_id'=>$params['comment_id'],//顶层为0，其余为对的comment_id
            'top_parent_id'=>$params['top_comment_id'],//顶层默认为0，为顶层的comment_id,
            'created_at'=>Carbon::now()->toDateTimeString()
        ];
        $result = Comments::insertGetId($data);
        //某个回复下有多少评论
        if($params['top_comment_id'] > 0){
            Comments::where(['id'=>$params['top_comment_id']])->increment('comment_count');
        }
        //文章有多少评论
        if($params['top_comment_id'] == 0){
            $this->articleRep->commentCountChange($article_id,1);//加1
        }
        if($result){
            return response()->json(['state'=>1,'message'=>'评论成功']);
        }else{
            return response()->json(['state'=>0,'message'=>'评论失败']);
        }
    }
    //2018-02-24 17:10 获取评论列表
    public function lists(Request $request){
        $this->validate($request,[
            'article_id'=>'required|hashid',
            'parent_id'=>'required|integer',
            'top_parent_id'=>'required|integer'
        ]);
        $article_id = \Hashids::decode($request->get('article_id'))[0];
        $params = $request->all();
        if(Auth::guard('front')->check()){
            $user_id = \Auth::guard('front')->user()->id;
        }else{
            $user_id = 0;
        }
        $lists = Comments::where(['article_id'=>$article_id,'top_parent_id'=>$params['top_parent_id']])->orderBy('created_at','desc')->paginate(10);
        $data = [
            'total' => $lists->total(),
            'currentPage' => $lists->currentPage(),
            'hasMore' => $lists->hasMorePages(),
            'from' => $lists->lastPage(),
            'to' => $lists->lastItem(),
            'perPage' => $lists->perPage(),
            'items'=>[]
        ];
        $items = $lists->map(function($item) use($user_id,$params){
            return [
                'article_id'=>$params['article_id'],
                'comment_id'=>$item->id,
                'user_id'=>\Hashids::encode($item->user_id),
                'user_name'=>$item->user_name,
                'comment'=>$item->comment,
                'like'=>$item->like,
                'top_parent_id'=>$item->top_parent_id,
                'parent_id'=>$item->parent_id,
                'created_at'=>Carbon::parse($item->created_at)->toDateTimeString(),
                'comment_count'=>intval($item->comment_count),
                'del_flag'=>$item->user_id == $user_id ? 1:0,
                'has_more'=>$item->comment_count > 0 ? 1:0,
                'open'=>false
            ];
        });
        if(!empty($items)){
            $data['items'] = $items;
        }
        return response()->json($data,200);
    }
    //删除留言
    public function del(Request $request){
        $this->validate($request,[
            'comment_id'=>'required|integer',
            'top_parent_id'=>'integer|required'
        ]);
        $top_parent_id = $request->get('top_parent_id');
        if($top_parent_id > 0){
            Comments::where(['id'=>$top_parent_id])->decrement('comment_count');
        }
        $user_id = Auth::guard('front')->user()->id;
        $comment_id = $request->get('comment_id');
        $comment = Comments::where('user_id',$user_id)->find($comment_id);
        $article_id = $comment->article_id;//获取文章id
        $result = $comment->delete();
        if($top_parent_id == 0){
            $this->articleRep->commentCountChange($article_id,-1);//减1
        }
        if($result){
            return response()->json(['state'=>1,'message'=>'删除成功'],200);
        }else{
            return response()->json(['state'=>0,'message'=>'删除失败'],500);
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
