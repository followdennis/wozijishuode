@extends('layouts.main_layout')
@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/metronic_theme/css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/system/user/index.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>

    <script>
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : 'report/get_list',
                edit : '{{route('user/edit')}}',
            }
        };

        $(document).ready(function() {

            var table = $('#main_table').DataTable({
                bLengthChange:false,
                bPaginate : false,
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
                        d.report_type = $('#report_type').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', title : 'ID', width:"35px",sortable: false},
                    {data: 'article_id', name: 'article_id', title : '文章id',width:"35px", sortable: false},
                    {data: 'title', name: 'title', title : '文章标题',width:"200px", sortable: false},
                    {data: 'comment_id', name: 'comment_id', title : '评论id', sortable: false},
                    {data: 'comment', name: 'comment', title : '评论内容', sortable: false},
                    {data: 'description', name: 'description', title : '问题描述', sortable: false},
                    {data: 'user_name', name: 'user_name', title : '投诉人',width:"80px", sortable: false},
                    {data:'report_time',name:'report_time',title:'投诉事件',width:"90px",sortable:false},
                    {data: 'process_user_name', name: 'process_user_name', title : '处理人', sortable: false},
                    {data: 'process_time', name: 'process_time', title : '处理时间', sortable: false},

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
//                    {data: 'action', name: 'action', title : '操作', width:"235px",sortable: false}
                ],
                //创建行回调
                "createdRow": function ( row, data, index ) {
                    $('.menu_del',row).click(function () {
                        deleteItem($(this).data('id'));
                    });
                    $('.item_add',row).click(function(){
                        item_add($(this).data('id'));
                    })
                    $('.item_edit',row).click(function(){
                        item_edit($(this).data('id'));
                    })
                    $('.is_finish_convert',row).click(function(){
                        change_finish_status(this);
                    })
                }
            });

            $('#search-form').on('submit', function(e) {
                table.draw();
                e.preventDefault();
            });

//        $("#penalty_start_date").datepicker({
//            todayBtn: "linked",
//            clearBtn: true,
//            language: "cn",
//            calendarWeeks: true,
//            autoclose: true,
//            todayHighlight: true
//        });
//
//        $("#penalty_end_date").datepicker({
//            todayBtn: "linked",
//            clearBtn: true,
//            language: "cn",
//            calendarWeeks: true,
//            autoclose: true,
//            todayHighlight: true
//        });

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

        function item_add(id){
            var url = jsRoute(routes.list.add,{parent_id:id});
            layer.open({
                title: '添加菜单',
                type: 2,
                btn: ['保存','取消'], //按钮
                yes: function(index, layero){ //或者使用btn1
                    var formData = layer.getChildFrame('body');
                    formData.find('#dosubmit').click();
                    // layer.closeAll();
                },cancel: function(index){ //或者使用btn2
                    layer.closeAll();
                },
                skin: 'layui-layer-rim', //加上边框
                area: ['600px','700px'], //宽高
                content: url,
                end: function () {
                    // location.reload();
                    var table = $('#main_table').DataTable();
                    table.ajax.reload();
                }
            });
        }
        function item_edit(id){
            var url = jsRoute(routes.list.edit,{id:id});
            layer.open({
                title: '编辑菜单',
                type: 2,
                btn: ['保存','取消'], //按钮
                yes: function(index, layero){ //或者使用btn1
                    var formData = layer.getChildFrame('body');
                    formData.find('#dosubmit').click();
                    // layer.closeAll();
                },cancel: function(index){ //或者使用btn2
                    layer.closeAll();
                },
                skin: 'layui-layer-rim', //加上边框
                area: ['600px','450px'], //宽高
                content: url,
                end: function () {
                    // location.reload();
                    var table = $('#main_table').DataTable();
                    table.ajax.reload();
                }
            });
        }
        //    $("#penalty_start_date").datepicker({
        //        todayBtn: "linked",
        //        clearBtn: true,
        //        language: "cn",
        //        calendarWeeks: true,
        //        autoclose: true,
        //        todayHighlight: true
        //    });
        //
        //    $("#penalty_end_date").datepicker({
        //        todayBtn: "linked",
        //        clearBtn: true,
        //        language: "cn",
        //        calendarWeeks: true,
        //        autoclose: true,
        //        todayHighlight: true
        //    });

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
            <h1 class="page-title"> 投诉与反馈
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
                                <i class="fa fa-cogs"></i>问题列表 </div>

                            <div class="actions">
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline pull-right" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="评论关键词">
                                </div>
                                <select name="report_type" id="report_type" class="form-control">
                                    <option value="0">搜索内容</option>
                                    <option value="1">文章投诉</option>
                                    <option value="2">留言投诉</option>
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

        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@section('footer')
@endsection