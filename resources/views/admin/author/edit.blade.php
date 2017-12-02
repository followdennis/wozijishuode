@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('CUSTOM_SCRIPT')
    <script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>
    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/admin/author/form.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
@endsection

@section('body')
    <section class="common_content">
        <div class="portlet-body" style="padding:25px 0 0 15px">
            <!-- BEGIN FORM-->
            <form action="{{route('author/edit')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> 表单验证成功! </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">作者名称
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" name="name" value="{{ $info->name }}" data-required="1" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">作者全拼
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" name="pinyin" value="{{ $info->pinyin }}" data-required="1" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">作者简拼
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" name="py" data-required="1" value="{{ $info->py }}" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">作者描述
                            <span class="required">  </span>
                        </label>
                        <div class="col-xs-8">
                            <input type="text" id="description" name="description" value="{{ $info->description }}" data-required="1" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">是否显示</label>
                        <div class="col-xs-9" style="height:32px;">
                            <input type="checkbox" name="is_show" @if($info->is_show) checked @endif  class="make-switch" data-on-text="是" data-off-text="否">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="id" id="id" value="{{ $info->id }}" />
                <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
            </form>
            <!-- END FORM-->
        </div>
    </section>
@endsection