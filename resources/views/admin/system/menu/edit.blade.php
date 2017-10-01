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
    <script src="{{asset('js/System/Menu/form.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
@endsection

@section('body')
    <div class="portlet-body" style="padding:25px 0 0 15px">
        <!-- BEGIN FORM-->
        <form action="{{route('menus/edit')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> 表单验证成功! </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">上级菜单：
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <select class="form-control" name="parent_id">
                            <option value="0"> ≡ 作为顶级菜单 ≡ </option>
                            {!! $select_categorys !!}
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">菜单名称
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" name="display_name" data-required="1" class="form-control" value="{{ $info->name }}" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">图标样式
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="icon" data-required="1" class="form-control" value="{{ $info->icon }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">排序
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" name="sort" value="0" data-required="1" class="form-control" value="{{ $info->sort }}" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">是否显示</label>
                    <div class="col-xs-9" style="height:32px;">
                        <input type="checkbox" name="is_show" @if($info->is_show) checked @endif checked class="make-switch" data-on-text="是" data-off-text="否">
                    </div>
                </div>
                <fieldset>
                    <legend>权限设置</legend>
                </fieldset>
                <div class="form-group">
                    <label class="control-label col-xs-3">路由
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#permissions_name_error">
                            <input type="text" id="permissions_name" name="permissions_name" data-required="1" class="form-control" value="{{ $info->permissions_name }}" />
                        </div>
                        <div id="permissions_name_error"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">路由参数
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#route_params_error">
                            <input type="text" id="route_params" name="route_params" value="" data-required="1" class="form-control" value="{{ $info->route_params }}" />
                        </div>
                        <div id="route_params_error"> </div>
                        <div class="help-block"> 变量名与路由中变量对应，如：id=1&name=jack </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">权限名称
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-8">
                        <input type="text" id="permissions_display_name" name="permissions_display_name" data-required="1" class="form-control" value="{{ $info->permissions_display_name }}" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">权限描述
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-8">
                        <input type="text" id="permissions_description" name="permissions_description" data-required="1" class="form-control" value="{{ $info->permissions_description }}" />
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="permission_id" value="{{ $info->id }}" />
            <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
        </form>
        <!-- END FORM-->
    </div>
@endsection