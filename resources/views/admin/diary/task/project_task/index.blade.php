@extends('layouts.main_layout')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/toastr/toastr.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>
    <script type="text/javascript">
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : '{{route('project_task/list')}}',
                delete : '{{route('project_task/del')}}',
                edit:'{{ route('project_task/edit') }}',
                change_status:'{{ route('public_project_task/change_status') }}',
                show:'{{ route('project_task/show') }}'
            }
        };

        $(document).ready(function() {
                    {{--$.get('public_current_table',{tb_name:'{{ $tb_name }}'},function(data){--}}
                    {{--setTimeout(function () {--}}
                    {{--}, 10);--}}
                    {{--});--}}

            var table = $('#main_table').DataTable({
                    bLengthChange:false,
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
                        {data: 'id', name: 'id', title : '关键人id', sortable: false, visible: false},
                        {data: 'title', name: 'title', title : '文章标题', sortable: false},
                        {data: 'description', name: 'description', title : '描述', sortable: false},
                        {data: 'estimate_time', name: 'estimate_time', title : '评估时间', sortable: false},
                        {
                            data: 'is_finish', name: 'is_finish', title : '是否完成', sortable: false,
                            render:function(data,type,full){
                                var message_id = full.id;
                                if(full.is_finish == 0){
                                    return '<span data-id="'+message_id+'" data-status="0" class="glyphicon glyphicon-remove is_finish_convert" style="color:red"></span>';
                                }else{
                                    return '<span data-id="'+message_id+'" data-status="1" class="glyphicon glyphicon-ok is_finish_convert" style="color:green"></span>';
                                }
                            }
                        },
                        {data: 'assess_value', name: 'assess_value', title : '价值评估', sortable: false},
                        {data: 'start_time', name: 'start_time', title : '开始时间', sortable: false},
                        {data: 'created_at', name: 'created_at', title : '创建时间', sortable: false},
                        {data: 'true_time', name: 'true_time', title : '实际用时', sortable: false},
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
                        {data: 'action', name: 'action', title : '操作', width:"220px",sortable: false}
                    ],
                    //创建行回调
                    "createdRow": function ( row, data, index ) {
                        $('.itemDel',row).click(function () {
                            deleteItem($(this).attr('data-id'));
                        });
                        $('.itemDetail',row).click(function(){
                            item_details($(this).attr('data-id'));
                        })
                        $('.itemEdit',row).click(function(){
                            item_edit($(this).attr('data-id'));
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

            $("#penalty_start_date").datepicker({
                todayBtn: "linked",
                clearBtn: true,
                language: "zh-CN",
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true
            });

            $("#penalty_end_date").datepicker({
                todayBtn: "linked",
                clearBtn: true,
                language: "zh-CN",
                calendarWeeks: true,
                autoclose: true,
                todayHighlight: true
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
                    confirmButtonText: "是的，确定删除",
                    closeOnConfirm: false
                }

            ).then(

                function(){
                    url = jsRoute(routes.list.delete, {id: id});
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
                            text: '删除关键人失败',
                            type: "error",
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
        function item_edit(id){


            var url =jsRoute(routes.list.edit,{id:id});
            window.location.href=url;
//            layer.open({
//                title: '投诉任务详情',
//                type: 2,
//                btn: ['关闭'], //按钮
//                yes: function(index, layero){ //或者使用btn1
//
//                    layer.closeAll();
//                },
//                skin: 'layui-layer-rim', //加上边框
//                area: ['1000px','600px'], //宽高
//                content:url+'?id='+id,
//            });
        }
        $("#penalty_start_date").datepicker({
            todayBtn: "linked",
            clearBtn: true,
            language: "zh-CN",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        });

        $("#penalty_end_date").datepicker({
            todayBtn: "linked",
            clearBtn: true,
            language: "zh-CN",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true
        });
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

                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h1 class="page-title"> 项目任务
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box blue-steel">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>项目任务列表 </div>

                            <div class="actions">
                                <a href="{{route('project_task/add')}}" class="btn btn-default btn-sm">
                                    <i class="fa fa-plus"></i> 添加项目任务
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="标题关键字">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="description" id="description" placeholder="描述">
                                </div>
                                <select name="search_order" id="search_order" class="form-control">
                                    <option value="">排序方式</option>
                                    <option value="1">时间降序</option>
                                    <option value="2">时间升序</option>
                                    <option value="3">用时降序</option>
                                    <option value="4">用时升序</option>
                                </select>
                                <select name="is_finish" id="is_finish" class="form-control">
                                    <option value="">是否完成</option>
                                    <option value="1">完成</option>
                                    <option value="0">未完成</option>
                                </select>
                                <div class="form-group">
                                    <div id="penalty_start_date" class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                        <input id="start_date" name="start_date" type="text" class="form-control" readonly="" placeholder="开始认定时间">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label> - </label>
                                    <div id="penalty_end_date" class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                        <input id="end_date" name="end_date" type="text" class="form-control" readonly="" placeholder="结束认定时间">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">搜索</button>
                            </form>

                            <table class="table table-striped table-bordered table-hover order-column" style="width: 100%" id="main_table">
                            </table>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>

            <!-- 编辑检查组的模态框 -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection