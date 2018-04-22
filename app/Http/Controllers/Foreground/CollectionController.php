<?php

namespace App\Http\Controllers\Foreground;

use App\Models\Foreground\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\HashidsManager;

class CollectionController extends Controller
{
    //文章收藏功能
   protected $collectionModel;
   protected $user_id;
    public function __construct(Collection $collection)
   {
       $this->collectionModel = $collection;
   }

    public function index(Request $request){

    }

    /**
     *  2018-04-22
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request){
        $this->validate($request,[
            'article_id'=>'required|hashid'
        ]);
        $article_id = \Hashids::decode($request->get('article_id'))[0];
        $user_id = Auth::guard('front')->user()->id;
        $response = $this->collectionModel->insertData($user_id,$article_id);
        return response()->json($response);
    }
    public function del(Request $request){
        $this->validate($request,[
            'article_id'=>'required|hashid'
        ]);
        $article_id = \Hashids::decode($request->get('article_id'))[0];
        $user_id = Auth::guard('front')->user()->id;
        $status = $this->collectionModel->delData($user_id,$article_id);
        if($status){
            return response()->json(['code'=>1,'msg'=>'收藏取消成功']);
        }else{
            return response()->json(['code'=>0,'msg'=>'收藏取消失败']);
        }
    }
}
