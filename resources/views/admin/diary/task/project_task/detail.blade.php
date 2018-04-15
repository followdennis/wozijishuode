@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('metronic_theme/global/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic_theme/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic_theme/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/System/SuperviseUser/form.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPTS')

    <script src="{{asset('metronic_theme/global/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('metronic_theme/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('vendor/sweetalert2/sweetalert2.js')}}" type="text/javascript"> </script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/Complaint/ComplaintTask/form.js')}}" type="text/javascript"></script>


    <script src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>

    <script>
        $("#complaint_time_at").datepicker({
            todayBtn: "linked",
            clearBtn: true,
            language: "zh-CN",
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,

        });
        $("#complaint_time_at").datepicker('setDate','}');

        $("#enterprise").on("select2:select", function(e){
            var enBaseData = e.params.data.data;
            $('#edit_enterprise_id').val(enBaseData.id);
            $('#edit_enterprise_name').val(enBaseData.name);
        });
        $('.select2-search__field').val('')
    </script>
@endsection

@section('body')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">

            </div>
            <!-- END PAGE BAR -->

            <!-- END PAGE HEADER-->

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN SAMPLE TABLE PORTLET-->
                    <div class="portlet light bordered">

                        <div class="portlet-body" style="padding:25px 0 0 15px">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <tr><td width="20%">文章标题</td><td><h2>{{ $info['title'] }}</h2></td></tr>
                                    <tr><td>描述</td><td>{{ $info['description'] }}</td></tr>
                                    <tr><td colspan="2">{!! $info['content'] !!} </td></tr>


                                </table>
                            </div>
                        </div>

                    </div>
                    <!-- END SAMPLE TABLE PORTLET-->
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection