@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('js/jquery.treetable/css/jquery.treetable.theme.default.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('js/jquery.treetable/css/jquery.treetable.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPT')
    {{--<script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>--}}
    {{--<script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.treetable/jquery.treetable.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/utils/xsrf_ajax.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/utils/util.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/system/role/power.js')}}" type="text/javascript"></script>
@endsection

@section('body')
    <div class="portlet-body" style="padding:25px 0 0 0px">
        <!-- BEGIN FORM-->
        <form action="{{route('role/power')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="dnd-example">
                    <thead>
                    <tr>
                        <th style="padding-left:30px;"> <label class="checkbox">
                                <input type="checkbox"> 全选/取消
                                <span></span>
                            </label>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php echo $categorys_html; ?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" name="id" id="id" value="{{$info->id}}" />
            <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
        </form>
        <!-- END FORM-->
    </div>
@endsection