@extends('layouts.main_layout')
@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/metronic_theme/css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/admin/author/index.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>

    <script>
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : 'author/list',
                add : '{{route('author/add')}}',
                edit : '{{route('author/edit')}}',
                del : '{{route('author/del')}}'
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
                    }
                },
                columns: [
                    {data: 'id', name: 'id', title : 'ID', width:"35px",sortable: false},
                    {data: 'name', name: 'name', title : '名称', sortable: false},
                    {data: 'pinyin', name: 'pinyin', title : '拼音', sortable: false},
                    {data: 'py', name: 'py', title : '简拼', sortable: false},
                    {data: 'description', name: 'description', title : '描述', sortable: false},
                    {data: 'is_show', name: 'is_show', title : '是否展示', sortable: false,
                        render:function(data,type,full){
                            var message_id = full.id;
                            if(full.is_show == 0){
                                return '<span data-id="'+message_id+'" data-status="0" class="glyphicon glyphicon-remove is_finish_convert" style="color:red"></span>';
                            }else{
                                return '<span data-id="'+message_id+'" data-status="1" class="glyphicon glyphicon-ok is_finish_convert" style="color:green"></span>';
                            }
                        }

                    },
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
                    $('.item_add',row).click(function(){
                        item_add($(this).data('id'));
                    })
                    $('.item_edit',row).click(function(){
                        item_edit($(this).data('id'));
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
            //前台是否展示
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
                        if(data.code){
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
                title: '添加作者',
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
                area: ['600px','500px'], //宽高
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
                title: '编辑分类',
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
                area: ['600px','500px'], //宽高
                content: url,
                end: function () {
                    // location.reload();
                    var table = $('#main_table').DataTable();
                    table.ajax.reload();
                }
            });
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
            <h1 class="page-title"> 作者管理
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
                                <i class="fa fa-cogs"></i>作者列表 </div>

                            <div class="actions">
                                <button type="button" data-url="{{route('author/add')}}" class="btn btn-default btn-sm author_add" >
                                    <i class="fa fa-plus"></i> 添加作者
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