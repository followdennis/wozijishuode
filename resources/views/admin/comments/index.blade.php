@extends('layouts.main_layout')
@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/metronic_theme/css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>

    <script>
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : 'comments/list',
                hide:'{{route('comments/hide')}}',
                del : '{{route('comments/del')}}'
            }
        };

        $(document).ready(function() {

            var table = $('#main_table').DataTable({
                bLengthChange:true,
                bPaginate : true,
                processing: true,
                serverSide: true,
                deferRender: true,
                searching: false,
                aaSorting: [],
                scrollX: true,
                autoWidth: true,
                language: {
                    "sProcessing": "正在加载数据，请稍后...",
                    "sLengthMenu": "每页显示 _MENU_ 项结果",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
                    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                    "sInfoFiltered": "",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                },
                ajax: {
                    url: jsRoute(routes.list.fetch),
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                        d.sort_order = $("#sort_order").val();
                        d.title = $("#article_title").val();
                        d.user_name = $("#user_name").val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', title : 'ID', width:"35px",sortable: false},
                    {data: 'title', name: 'title', title : '对应文章', sortable: false},
                    {data: 'user_name', name: 'user_name', title : '用户名', sortable: false},
                    {data: 'comment', name: 'comment', title : '评论', sortable: false},
                    {data: 'parent_id', name: 'parent_id', title : '父id', sortable: false},
                    {data: 'like', name: 'like', title : '赞', sortable: false},
                    {data: 'created_at', name: 'created_at', title : '创建日期', sortable: false},
//                    {
//                        data: 'source_url', name: 'source_url', title : '文章来源', sortable: false,
//                        render: function (data,type,full) {
//                            if(full.source_url.length > 0){
//                                url =  full.source_url;
//                                return  "<a href='"+url+"' class='get_deducation' target='_blank'>文章来源</a>";
//                            }else{
//                                return '文章来源';
//                            }
//                        }
//                    },
//                    {data: 'created_at', name: 'created_at',width:"100px", title : '采集时间', sortable: false},
                    {data: 'action', name: 'action', title : '操作', width:"235px",sortable: false}
                ],
                //创建行回调
                "createdRow": function ( row, data, index ) {
                    $('.item_del',row).click(function () {
                        deleteItem($(this).data('id'));
                    });
                    $('.item_hide',row).click(function(){
                        changeStatus($(this).data('id'),$(this).data('is_hidden'));
                    })
                }

            });

            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });
        } );

        function change_finish_status(obj){
            var status = $(obj).attr('data-status');
            var id = $(obj).attr('data-id')
            if(status == 0){
                $(obj).attr('data-status',1);
                status = 1;
                $(obj).attr('class','glyphicon glyphicon-ok is_finish_convert').css('color','green');
            }else{
                $(obj).attr('data-status',0);
                status = 0;
                $(obj).attr('class','glyphicon glyphicon-remove is_finish_convert').css('color','red');
            }
            var url = jsRoute(routes.list.change_status);
            $.get(url,{id:id,is_finish:status},function(data){
                if(data.status == 0){

                }else{
                    toastr.options = {
                        closeButton: true,
                        debug: false,
                        positionClass: 'toast-top-right',
                        onclick: null,
                    };
                    toastr['success'](data.msg,'成功');
                }
            })
        }
        //是否屏蔽
        function changeStatus(id,is_hide){
            if(is_hide){
                var is_hide = 0;
            }else {
                var is_hide = 1;
            }
            url = jsRoute(routes.list.hide, {id: id,is_hide:is_hide});
            $.get( url, function(data) {
                if(data.status){
                    var table = $('#main_table').DataTable();
                    table.ajax.reload();
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
                    text: '操作失败',
                    type: "error",
                });
            });
        }
        function deleteItem(id) {
            swal({
                    title: "确定删除?",
                    text: "删除后，你将无法恢复!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是的，确定删除",
                    closeOnConfirm: false
                }

            ).then(
                function(){
                    url = jsRoute(routes.list.del, {id: id});
                    $.get( url, function(data) {
                        if(data.status){
                            var table = $('#main_table').DataTable();
                            table.ajax.reload();
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
            );
        }

    </script>
@endsection
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    {{--{!! $CurrentPosition !!}--}}
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title"> 评论管理
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row row_left">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box red">
                        {{--<div class="portlet box blue-steel">--}}
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>评论列表 </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline pull-right" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="用户名">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="title" id="article_title" placeholder="文章标题">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="评论关键词">
                                </div>
                                <select name="sort_order" id="sort_order" class="form-control">
                                    <option value="0">排序</option>
                                    <option value="1">赞降序</option>
                                    <option value="2">赞升序</option>
                                </select>
                                <button type="submit" class="btn btn-primary red">搜索</button>
                            </form>
                            <table class="table table-striped table-bordered table-hover order-column" style="width: 100%" id="main_table">
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>

            <!-- 编辑检查组的模态框 -->
            <div class="modal fade" id="editListModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="editListModalTitle"></h4>
                        </div>
                        <div class="modal-body"><div class="portlet-body form">
                                <form class="form-horizontal" role="form" id="editListForm" method="post">
                                    {{ csrf_field() }}
                                    <input id="edit_id" type="hidden" name="id">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">企业类型</label>
                                            <div class="col-xs-9">
                                                <div class="form-group">
                                                    <div class="col-xs-7">
                                                        <input value="" type="text" id="enterprise_type_name" name="enterprise_type_name" data-required="1" class="form-control enterprise_type_name" />
                                                        <input value=""  type="hidden" id="enterprise_type_id" name="enterprise_type_id" class="form-control enterprise_type_id" />
                                                        <input value="radio"  type="hidden" id="z_chk_style" name="z_chk_style" class="form-control" />
                                                    </div>
                                                    <button type="button" class="btn green enterprise_type_choice">选择</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">记录类型</label>
                                            <div class="col-md-9">
                                                <input name="behavior_name" id="edit_behavior_name" type="text" class="form-control" placeholder="请输入记录类型">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">分值</label>
                                            <div class="col-md-9">
                                                <input name="score" id="edit_score" type="text" class="form-control" placeholder="请输入分值"> </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">影响年限</label>
                                            <div class="col-md-9">
                                                <input name="effect_years" id="edit_effect_years" type="text" class="form-control" placeholder="请输入影响年限">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="button" class="btn btn-primary" onclick="submitEditList()">保存</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal -->
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@section('footer')
@endsection