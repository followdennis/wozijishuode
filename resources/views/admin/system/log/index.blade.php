@extends('layouts.main_layout')
@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/metronic_theme/css/bootstrap-responsive.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/toastr/toastr.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/datatables/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/datatables/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/helper.js')}}" type="application/javascript"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}" type="application/javascript"></script>

    <script>
        /**
         * 定义本页面使用到的路由
         * */
        var routes = {
            list: {
                fetch : 'system_log/lists'
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
                        d.is_login = $('#is_login').val();
                        d.user_type = $('#user_type').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                columns: [
                    {data: 'id', name: 'id', title : 'ID', width:"35px",sortable: false},
                    {data: 'user_id', name: 'user_id', title : '用户id', sortable: false},
                    {data: 'user_type', name: 'user_type', title : '用户类型', sortable: false},
                    {data: 'user_name', name: 'user_name', title : '用户名', sortable: false},
                    {data: 'login_ip', name: 'login_ip', title : '登陆ip', sortable: false},
                    {data: 'login_address', name: 'login_address', title : '登陆地址', sortable: false},
                    {data: 'is_login', name: '登陆状态', title : '登陆状态', sortable: false},
                    {data: 'created_at', name: 'created_at', title : '登陆时间', sortable: false},
                    {data: 'updated_at', name: 'updated_at', title : '退出时间',sortable: false}
                ],
                //创建行回调
                "createdRow": function ( row, data, index ) {

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
            <h1 class="page-title"> 系统日志
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
                                <i class="fa fa-cogs"></i>日志列表 </div>

                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method="POST" id="search-form" class="form-inline" role="form">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="用户名">
                                </div>
                                <div class="form-group" >
                                    <select name="user_type" id="user_type" class="form-control">
                                        <option value="">用户类型</option>
                                        <option value="0">后台用户</option>
                                        <option value="1">前台用户</option>
                                    </select>
                                </div>
                                <div class="form-group" >
                                    <select name="is_login"  id="is_login" class="form-control">
                                        <option value="">是否登陆</option>
                                        <option value="1">登陆</option>
                                        <option value="2">退出</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>检查日期</label>
                                    <div id="penalty_start_date" class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                        <input id="start_date" name="start_date" type="text" class="form-control" readonly="">
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
                                        <input id="end_date" name="end_date" type="text" class="form-control" readonly="">
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
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