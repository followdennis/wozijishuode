<?php

namespace App\Http\Controllers\Admin\Plan;

use App\Http\Controllers\AdminController;
use App\Repository\PlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanTaskJobController extends AdminController
{
    //
    protected $planRep;
    protected $req;
    public function __construct(Request $request,PlanRepository $plan)
    {
        parent::__construct($request);
        $this->req = $request;
        $this->planRep = $plan;
    }
    public function index()
    {
        return view('admin/plan/planTaskJob/index');
    }
    public function get_list()
    {
        $query = $this->req->get('query','');
        $plan_id = $this->req->get('plan_id',0);
        $pageData = $this->planRep->getPlanTaskJobList($plan_id,$query);
        $res = setPageData($pageData);
        return response()->json($res);
    }

    public function show()
    {
        $id = $this->req->get('id',0);
        $info = $this->planRep->showPlanTaskJob($id);
        if($info){
            $code = 0;
            $msg = '成功';
        } else{
            $code = -1;
            $msg = '失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg,'data'=>$info]);
    }
    public function edit()
    {
        $params = $this->req->all();
        $id = $this->req->get('id');
        $res = $this->planRep->editPlanTaskJob($id,$params);
        if($res){
            $code = 0;
            $msg = '编辑成功';
        }else{
            $code = -1;
            $msg = '编辑失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg]);
    }

    public function add()
    {
        $params = $this->req->all();
        $res = $this->planRep->addPlanTaskJob($params);
        if($res){
            $code = 0;
            $msg = '新增成功';
        }else{
            $code = -1;
            $msg = '新增失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg]);

    }
    public function del(){
        $id = $this->req->get('id');
        $res = $this->planRep->delPlanTaskJob($id);
        if($res){
            $code = 0;
            $msg = '删除成功';
        }else{
            $code = -1;
            $msg = '删除失败';
        }
        return response()->json(['code'=>$code,'msg'=>$msg]);
    }

}
