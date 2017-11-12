@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('CUSTOM_SCRIPT')

@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 main-chart">
          article
            <div class="row row_left">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box red">

                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>分类列表 </div>

                            <div class="actions">
                                <button type="button" data-url="http://www.wozijishuode.com/back/category/add" class="btn btn-default btn-sm category_add">
                                    <i class="fa fa-plus"></i> 添加分类
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline pull-right" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="标签名称">
                                </div>
                                <button type="submit" class="btn btn-primary red">搜索</button>
                            </form>
                            <div id="main_table_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="dataTables_length" id="main_table_length"><label>每页显示
                                                <select name="main_table_length" aria-controls="main_table" class="form-control input-sm">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select> 项结果</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 pull-right"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="dataTables_scroll">
                                            <div class="dataTables_scrollHead " style="overflow: hidden; position: relative; border: 0px; width: 100%;">
                                                <div class="dataTables_scrollHeadInner " >
                                                    <table class="table table-striped table-bordered table-hover order-column dataTable no-footer " role="grid">
                                                        <thead>
                                                        <tr role="row ">
                                                            <th  style="width: 34px;" >排序</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 35px;" aria-label="ID">ID</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="菜单名称">标题</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="拼音">分类</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="简拼">作者</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="描述">点击量</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="显示">赞</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="显示">创建时间</th>
                                                            <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 235px;" aria-label="操作">操作</th>
                                                        </tr></thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
                                                <table class="table table-striped table-bordered table-hover order-column dataTable no-footer " style="width: 100%;" id="main_table" role="grid" aria-describedby="main_table_info"><thead>
                                                    <tr role="row" style="height: 0px;">
                                                        <th style="width: 34px;padding-top: 0px;  padding-bottom: 0px; border-top-width: 0px; border-bottom-width: 0px; height: 0px;" >
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($list as $k => $data)
                                                    <tr role="row" class="odd">
                                                        <td>{{ $data->id }}</td>
                                                        <td>{{ $data->title }}</td>
                                                        <td>{{ $data->cate_name }}</td>
                                                        <td>{{ $data->author }}</td>
                                                        <td>{{ $data->click }}</td>
                                                        <td>{{ $data->like }}</td>
                                                        <td>{{ $data->created_at }}</td>
                                                        <td>
                                                            <a data-id="1" class="btn btn-sm green item_add">
                                                                <i class="fa fa-plus"></i> 添加子分类 </a>
                                                            <a data-id="1" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>
                                                            <a href="javascript:;" data-id="1" class="btn dark btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a></td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="main_table_processing" class="dataTables_processing panel panel-default" style="display: none;">正在加载数据，请稍后...</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="dataTables_info" id="main_table_info" role="status" aria-live="polite">显示第 {{ $page->firstItem() }} 至 {{ $page->lastItem() }} 项结果，共 {{ $page->total() }} 项</div></div>
                                    <div class="col-sm-10">
                                        <div class="dataTables_paginate paging_simple_numbers" id="main_table_paginate">
                                            {{ $page->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div><!-- /col-lg-9 END SECTION MIDDLE -->


        <!-- **********************************************************************************************************************************************************
        RIGHT SIDEBAR CONTENT
        *********************************************************************************************************************************************************** -->
    </div><! --/row -->
@endsection

