<?php

namespace App\Http\Controllers\Admin\Diary;

use App\Http\Controllers\AdminController;
use App\Models\Diary\MyQuestion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuestionController extends AdminController
{
    //自建问题
    protected $questionModel;
    public function __construct(Request $request,MyQuestion $myquestion)
    {
        parent::__construct($request);
        $this->questionModel = $myquestion;
    }

    public function index(){
        return view('admin/diary/question/index');
    }
    public function lists(Request $request){
        $perPage = !empty($request->get('perPage')) ? intval($request->get('perPage')) : 10;
        $data = $this->questionModel->where(function($query)use($request){
            if($request->filled('query')){
                $kw = $request->get('query');
                $query->where('question','like','%'.$kw.'%');
            }
        })->paginate($perPage);
        $results = [
            'total'=>$data->total(),
            'perPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'from' => $data->firstItem(),
            'to' => $data->lastItem(),
            'items' => []
        ];
        $item = $data->map(function($item){
            return [
                'id'=>$item->id,
                'question'=>$item->question,
                'sort'=>$item->sort,
                'createdAt'=>Carbon::parse($item->created_at)->toDateString()
            ];
        });
        if(empty($item) || count($item)<=0){
            return response()->json($results);
        }
        $results['items'] = $item;
        return response()->json($results,200);
    }
    public function add(Request $request){
        $this->validate($request,[
            'question'=>'required|max:255',
            'sort'=>'integer'
        ]);
        $data = [
            'question'=>trim($request->get('question')),
            'sort'=>intval($request->get('sort')),
            'created_at'=>Carbon::now()
        ];
        $status = $this->questionModel->insertData($data);
        if($status){
            return response()->json(['state'=>1,'msg'=>'新增成功']);
        }else{
            return response()->json(['state'=>0,'msg'=>'新增失败']);
        }
    }
    public function edit(Request $request){

        $this->validate($request,[
            'question'=>'required|max:255',
            'sort'=>'required|integer',
            'id'=>'required|integer'
        ]);
        $id = $request->get('id');
        $data =[
            'question'=> trim($request->get('question')),
            'sort'=>intval($request->get('sort'))
        ];
        $status = $this->questionModel->where('id',$id)->update($data);
        if($status){
            return response()->json(['state'=>1,'msg'=>'编辑成功']);
        }else{
            return response()->json(['state'=>0,'msg'=>'编辑失败']);
        }
    }
    public function del(Request $request){
        $this->validate($request,[
            'id'=>'required|array'
        ]);
        $ids = $request->get('id');
        $status = $this->questionModel->whereIn('id',$ids)->delete();
        if($status){
            return response()->json(['state'=>1,'msg'=>'删除成功']);
        }else{
            return response()->json(['state'=>0,'msg'=>'删除失败']);
        }
    }

}
