@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPT')
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>--}}

    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/admin/category/form.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
@endsection

@section('body')
    <section class="common_content">
        <div class="portlet-body" style="padding:25px 0 0 15px">
            <!-- BEGIN FORM-->
            <form action="{{route('tags/add')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> 表单验证成功! </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">分类名称
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" name="name" data-required="1" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">分类描述
                            <span class="required">  </span>
                        </label>
                        <div class="col-xs-8">
                            <input type="text" id="description" name="description" data-required="1" class="form-control" />
                        </div>
                    </div>
                </div>
                <input type="hidden" name="category_id" id="category_id" value="0" />
                <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
            </form>
            <!-- END FORM-->
        </div>
    </section>
@endsection