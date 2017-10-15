@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('metronic_theme/global/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('CUSTOM_SCRIPT')
    {{--<script type="text/javascript" src="{{ URL::asset('/js/jquery-validation-1.13.1/lib/jquery.form.js')}}"></script>--}}
    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/utils/xsrf_ajax.js')}}" type="text/javascript"></script>
    <script src="{{asset('metronic_theme/global/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/system/user/form.js')}}" type="text/javascript"></script>

@endsection

@section('body')
    <section class="common_content">
        <div class="portlet-body" style="padding:25px 0 0 15px">
            <!-- BEGIN FORM-->
            <form action="{{route('user/add')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">

                {{csrf_field()}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button> 表单验证成功! </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">登录名称
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="mt-radio-list" data-error-container="#login_name_error">
                                <input type="text" id="name" name="name" value="" class="form-control" />
                            </div>
                            <div id="login_name_error"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">登录密码
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="mt-radio-list" data-error-container="#password">
                            <input type="text" id="password" name="password" value="" class="form-control" />
                            </div>
                            <div id="password"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">登录邮箱
                            <span class="required"> * </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="mt-radio-list" data-error-container="#email">
                            <input type="text" id="email" name="email" value="" class="form-control" />
                            </div>
                            <div id="email"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">用户姓名
                            <span class="required">  </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" id="nickname" name="nickname" value="" data-required="1" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">选择角色
                            <span class="required"> </span>
                        </label>
                        <div class="col-xs-8">
                            <div class="mt-radio-list" data-error-container="#role">
                            <select id="role_id" name="role_id[]" class="mt-multiselect btn btn-default" multiple="multiple" data-label="left" data-action-onchange="true">
                                @foreach($role_list as $role)
                                    <option value="{{$role->id}}">{{$role->display_name}}</option>
                                @endforeach
                            </select>
                            </div>
                            <div id="role"></div>
                        </div>
                    </div>
                    @if(Auth::user()->is_admin == 1)
                        <div class="form-group">
                            <label class="control-label col-xs-3">站点管理员</label>
                            <div class="col-xs-9" style="height:32px;">
                                <input type="checkbox" name="is_admin" class="make-switch" data-on-text="是" data-off-text="否">
                            </div>
                        </div>
                    @endif
                </div>
                <input type="hidden" name="id" id="id" value="0" />
                <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
            </form>
            <!-- END FORM-->
        </div>
    </section>
@endsection