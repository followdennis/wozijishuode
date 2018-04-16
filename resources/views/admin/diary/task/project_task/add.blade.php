@extends('layouts.main_layout')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic_theme/global/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/admin/task/project/form.js')}}" type="text/javascript"></script>

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
            <h1 class="page-title"> 添加项目任务
            </h1>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="note note-info">
                <p> 功能：添加项目任务 </p>
            </div>

            <!-- BEGIN FORM-->
            <form action="{{route('project_task/add')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">

                {{csrf_field()}}

                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="form-group">
                                <label class="control-label col-xs-3">内容标题<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <input type="text" id="title" name="title"  value="" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">描述<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <input type="text" id="description" name="description"  value="" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3" id="content">内容<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <textarea class="form-control" name="content"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">预估时间<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <input type="text" id="estimate_time" name="estimate_time"  value="" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">实际时间<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <input type="text" id="true_time" name="true_time"  value="" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">价值评估<span class="required"> * </span>
                                </label>
                                <div class="col-xs-5">
                                    <input type="text" id="assess_value" name="assess_value"  value="0" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">开始时间<span class="required"> * </span>
                                </label>
                                <div id="effective_date_start" class="input-group date date-picker col-xs-3" data-date-format="yyyy-mm-dd ">
                                    <input id="launch_date" name="start_time" type="text" class="form-control " readonly="">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">结束时间<span class="required"> * </span>
                                </label>
                                <div id="effective_date_end" class="input-group date date-picker col-xs-3" data-date-format="yyyy-mm-dd " >
                                    <input id="launch_edate" name="end_time" type="text" class="form-control" readonly="">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn blue">保存</button>
                                        <button type="button" class="btn default" onclick="javascript:history.back(-1);">返回</button>
                                        <span id="check_items"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection
@section('footer')
@endsection