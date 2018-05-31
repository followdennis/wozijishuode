@extends('layouts.main_layout')
@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/metronic_theme/css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/system/role/index.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>

    <script>
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : '{{route('role/list')}}',
                add : '{{route('role/add')}}',
                edit : '{{route('role/edit')}}',
                del : '{{route('role/del')}}'
            },
            power:{
                set:'{{route('role/power')}}'
            }
        };
        $(document).ready(function() {

            var table = $('#main_table').DataTable({
                bLengthChange:false,
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
                        d.description = $('#description').val();
                        d.search_order = $('#search_order').val();
                        d.is_finish = $('#is_finish').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', title : 'ID', width:"35px",sortable: false},
                    {data: 'name', name: 'name', title : '角色名称',width:"100px", sortable: false},
                    {data: 'display_name', name: 'display_name', title : '角色显示名称', sortable: false},
                    {data: 'description', name: 'description', title : '描述', sortable: false},

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
                    {data: 'action', name: 'action', title : '操作', width:"310px",sortable: false}
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
                        item_edit($(this).data('id'),$(this).data('name'));
                    });
                    $('.power_set',row).click(function(){
                        power_set($(this).data('id'),$(this).data('name'));
                    });
                    $('.is_finish_convert',row).click(function(){
                        change_finish_status(this);
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
        function deleteItem(id) {
            swal({
                    title: "确定删除?",
                    text: "删除后，你将无法恢复!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确定",
                    width:"300px",
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
                            text: '删除角色失败',
                            type: "error",
                            width:"300px",
                        });
                    });
                }
            );
        }

        function item_details(id){
            var url ='/project_task/show';
            var url = jsRoute(routes.list.show);
            layer.open({
                title: '投诉任务详情',
                type: 2,
                btn: ['关闭'], //按钮
                yes: function(index, layero){ //或者使用btn1

                    layer.closeAll();
                },
                skin: 'layui-layer-rim', //加上边框
                area: ['1000px','600px'], //宽高
                content:url+'?id='+id,
            });
        }
        function power_set(id,name){
            var url = jsRoute(routes.power.set,{id:id});
            layer.open({
                title: '权限设置>'+ name,
                type: 2,
                btn: ['保存','关闭'], //按钮
                yes: function(index, layero){ //或者使用btn1
                    var formData = layer.getChildFrame('body');
                    formData.find('#dosubmit').click();
//                    layer.closeAll();
                },cancel:function(index){
                    layer.closeAll();
                },
                skin: 'layui-layer-rim', //加上边框
                area: ['600px','500px'], //宽高
                content:url,
                end: function () {
                    // location.reload();
                    var table = $('#main_table').DataTable();
                    table.ajax.reload();
                }
            });
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
                content: url
            });
        }
        function item_edit(id,name){
            var url = jsRoute(routes.list.edit,{id:id});
            layer.open({
                title: '编辑角色>'+ name,
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
                area: ['500px','400px'], //宽高
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
            <h1 class="page-title"> 角色管理
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
                                <i class="fa fa-cogs"></i>角色列表 </div>

                            <div class="actions">
                                <button type="button" data-url="{{route('role/add')}}" class="btn btn-default btn-sm role_add" >
                                    <i class="fa fa-plus"></i> 添加角色
                                </button>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="角色名称">
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