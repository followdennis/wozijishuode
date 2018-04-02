<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\AdminController;
use App\Models\SystemLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class SystemLogController extends AdminController
{
    //
    public function index(){
        return view('admin.system.log.index');
    }
    public function lists(Request $request,SystemLog $systemLog){
        $data = $systemLog->getList();
        return DataTables::of($data)
            ->editColumn('user_type',function($record){
                if($record->user_type == 1){
                    return '前台用户';
                }else if($record->user_type == 0){
                    return '后台用户';
                }else{
                    return '可疑用户';
                }
            })
            ->editColumn('is_login',function($record){
                if($record->is_login == 1){
                    return '登陆';
                }else if($record->is_login == 2){
                    return '退出登陆';
                }else{
                    return '可疑状态';
                }
            })
            ->filter(function($query) use($request){
                if($request->filled('keyword')){
                    $user_name = $request->get('keyword');
                    $query->where('user_name','like','%'.$user_name.'%');
                }
                if($request->filled('user_type')){
                    $user_type = $request->get('user_type');
                    $query->where('user_type',$user_type);
                }
                if($request->filled('is_login')){
                    $is_login = $request->get('is_login');
                    $query->where('is_login',$is_login);
                }
                if($request->filled('start_date')){
                    $start = Carbon::parse($request->get('start_date'))->toDateTimeString();
                    $query->where('created_at','>=',$start);
                }
                if($request->filled('end_date')){
                    $end = Carbon::parse($request->get('end_date'))->endOfDay();
                    $query->where('created_at','<=',$end);
                }
            })->make(true);
    }
}
