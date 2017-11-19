{{--弃用自己写的ajax无刷新翻页功能--}}
@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <style>
        #dataTables_scrollBody th{
            border-bottom: 1px solid #ddd;
        }
    </style>
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>
    <script>
        var routes = {
            list: {
                fetch : 'articles/list',
                add : '{{route('articles/add')}}',
                edit : '{{route('articles/edit')}}',
                del : '{{route('articles/del')}}'
            }
        };
        var url = jsRoute(routes.list.fetch);

        $(document).ready(function(){

            var url = jsRoute(routes.list.fetch);
            getList({page:1});
            var perPage = 10;
            //改变翻页
            $("#main_table_length").on("change","select[name=main_table_length]",function(){
                var perPage = $(this).val();
                var params = {page:1,perPage:perPage};
                getList(params);
            });
            $("#main_table_paginate").on("click","li a",function(){
                var page = $(this).attr('data-page');
                var perPage = $("#main_table_length select[name=main_table_length]").val();
                var cate_id = $("#cate_id select[name=cate_id]").val();
                var params = {page:page,perPage:perPage,cateId:cate_id};
                getList(params);
            })


            function getList(params){


                $.ajax({
                    url:url,
                    dataType:"json",
                    data:params,
                    type:"get",
                    success:function(json_data){

                        var data = json_data.list;
                        var links = json_data.links;
                        var str = '';
                        function get_data(){alert(11);}
                        for(var i = 0; i < data.length; i++){
                            var edit_url = jsRoute(routes.list.edit,{id:data[i].id});
                            str += '<tr>';
                            str += "<td>"+data[i].id + "</td>";
                            str += "<td>" + data[i].title  + "</td>";
                            str += "<td>" + (data[i].cate_name || '') + "</td>";
                            str += "<td>" + (data[i].author || '') + "</td>";
                            str += "<td>" + data[i].click + "</td>";
                            str += "<td>" + data[i].like + "</td>";
                            str += "<td>" + (data[i].created_at || '')+ "</td>";
                            str += "<td><a data-id=\"" + data[i].id + "\" href='"+edit_url+"' class=\"btn btn-sm purple item_edit\"><i class=\"fa fa-edit\"></i>编辑</a>" ;
                            var del_item = "<a href='javascript:void(0);' onclick='del_item(\""+data[i].id+"\");' data-id=\""+ data[i].id +"\" class=\"btn dark btn-sm red item_del\"><i class=\"fa fa-trash-o\"></i> 删除 </a>" ;

                            str += del_item;
                            str += "</td>";
                            str += '</tr>';

                        }
//                    $.each(data,function(index,item){
//                        var edit_url = jsRoute(routes.list.edit,{id:item.id});
//                        var str = '';
//                        str += '<tr id="a'+item.id+'">';
//                        str += "<td>"+item.id + "</td>";
//                        str += "<td>" + item.title  + "</td>";
//                        str += "<td>" + item.cate_name || '' + "</td>";
//                        str += "<td>" + (item.author || '') + "</td>";
//                        str += "<td>" + item.click + "</td>";
//                        str += "<td>" + item.like + "</td>";
//                        str += "<td>" + item.created_at || ''+ "</td>";
//                        str += '</tr>';
//                        $("#show_list").append(str);
//                        var action  = "<td><a data-id=\"" +item.id + "\" href='"+edit_url+"' class=\"btn btn-sm purple item_edit\"><i class=\"fa fa-edit\"></i>编辑</a>" ;
//                        action  += "<a href='javascript:void(0);'onclick='test2(\""+item.id+"\");'  data-id=\""+ item.id +"\" class=\"btn dark btn-sm red item_del\"><i class=\"fa fa-trash-o\"></i> 删除 </a>" ;
//                        $("#a"+item.id).append(action);
//                    });
                        $("#show_list").html(str);
                        $("#main_table_paginate").html(links);
                        var page_table_info = "显示第 "+json_data.page.from + " 至 "+json_data.page.to+" 项结果，共 "+json_data.page.total+" 项";
                        $("#main_table_info").html(page_table_info);

                    },
                    error:function(){

                    }
                });

            }


        })
        function getParams(){
            var perPage = $("#main_table_length select[name=main_table_length]").val();
            var cate_id = $("#cate_id select[name=cate_id]").val();
            var params = {page:1,perPage:perPage,cateId:cate_id};
            return params;
        }

        function del_item(id){
            swal({
                    title: "确定删除?",
                    text: "删除后，你将无法恢复!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是的，确定删除",

                }

            ).then(
                function(){
                    url = jsRoute(routes.list.del, {id: id});
                    $.get( url, function(data) {
                        if(data.status){
//                            var table = $('#main_table').DataTable();
//                            table.ajax.reload();
                            var params = getParams();
                            //用模拟改变事件重新刷新页面
                            $('#main_table_length select[name=main_table_length]').trigger("change");
                            toastr.options = {
                                closeButton: true,
                                debug: false,
                                positionClass: 'toast-top-right',
                                onclick: null,
                            };
                            toastr['success'](data.msg,'成功');
                        }else{
                            swal({
                                title: "失败",
                                text: data.msg,
                                type: "error",
                            });
                        }
                    }).fail(function() {
                        swal({
                            title: "失败",
                            text: '删除菜单失败',
                            type: "error",
                        });
                    });
                }
            ) .catch(swal.noop);;
        }



    </script>

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
                                <i class="fa fa-cogs"></i>文章列表 </div>

                            <div class="actions">
                                <a href="{{ route('articles/add') }}" class="btn btn-default btn-sm category_add">
                                    <i class="fa fa-plus"></i> 添加文章
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline pull-right" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="标签名称">
                                </div>
                                <div class="form-group" id="cate_id">
                                    <select name="cate_id"  class="form-control">
                                        <option value="0">请选择分类</option>
                                        @if(!empty($cate_list))
                                            @foreach($cate_list as $k =>$cate)
                                                <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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

                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="dataTables_scrollBody" id="dataTables_scrollBody" style="position: relative; overflow: auto; width: 100%;">
                                                <table class="table table-striped table-bordered table-hover order-column dataTable no-footer " style="width: 100%;" id="main_table" role="grid" aria-describedby="main_table_info"><thead>
                                                    <tr role="row" >
                                                        <th class="sorting_disabled example_tb_th"  rowspan="1" colspan="1" style="width: 35px;" aria-label="ID">ID</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="菜单名称">标题</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1"   aria-label="拼音">分类</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1" aria-label="简拼">作者</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="描述">点击量</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="显示">赞</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1"  aria-label="显示">创建时间</th>
                                                        <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 235px;" aria-label="操作">操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="show_list">
                                                    {{--@foreach($list as $k => $data)--}}
                                                    {{--<tr role="row" class="odd">--}}
                                                    {{--<td>{{ $data->id }}</td>--}}
                                                    {{--<td>{{ $data->title }}</td>--}}
                                                    {{--<td>{{ $data->cate_name }}</td>--}}
                                                    {{--<td>{{ $data->author }}</td>--}}
                                                    {{--<td>{{ $data->click }}</td>--}}
                                                    {{--<td>{{ $data->like }}</td>--}}
                                                    {{--<td>{{ $data->created_at }}</td>--}}
                                                    {{--<td>--}}
                                                    {{--<a data-id="1" class="btn btn-sm purple item_edit"><i class="fa fa-edit"></i>编辑</a>--}}
                                                    {{--<a href="javascript:;" data-id="1" class="btn dark btn-sm red item_del"><i class="fa fa-trash-o"></i> 删除 </a></td>--}}
                                                    {{--</tr>--}}
                                                    {{--@endforeach--}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="main_table_processing" class="dataTables_processing panel panel-default" style="display: none;">正在加载数据，请稍后...</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <div class="dataTables_info" id="main_table_info" role="status" aria-live="polite"></div></div>
                                    <div class="col-sm-10">
                                        <div class="dataTables_paginate paging_simple_numbers" id="main_table_paginate">
                                            {{--{{ $page->links() }}--}}
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

