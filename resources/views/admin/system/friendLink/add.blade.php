@extends('layouts.common')

@section('CUSTOM_STYLE')
<link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />

@endsection

@section('CUSTOM_SCRIPT')
<script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
<script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>

<script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>
<script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>
<script src="{{asset('js/system/friendlink/form.js')}}" type="text/javascript"></script>
<script src="{{asset('js/common.js')}}" type="text/javascript"></script>

<script>
    // post-submit callback
</script>
@endsection

@section('body')
<section class="common_content">
    <div class="portlet-body" style="padding:25px 0 0 15px">
        <!-- BEGIN FORM-->
        <form action="{{route('friend_link/add')}}" method="post" id="form-horizontal" class="form-horizontal" enctype="multipart/form-data">

            {{csrf_field()}}

            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> 表单验证成功! </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">网站名称
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#login_name_error">
                            <input type="text" id="name" name="name" value="" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">链接地址
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#password">
                            <input type="text" id="link_url" name="link_url" value="" data-required="1" class="form-control" />
                        </div>
                        <div id="password"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">描述
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#email">
                            <input type="text" id="description" name="description" value="" class="form-control" />
                        </div>
                        <div id="email"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">排序值
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="input-icon right">
                            <i class="fa"></i>
                            <input type="text" id="sort" name="sort" value="0" data-required="1" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">是否在首页显示
                        <span class="required">  </span>
                    </label>
                    <div class="col-xs-9" style="height:32px;">
                        <input type="checkbox" name="is_front"  id="is_front" class="make-switch" data-on-text="是" data-off-text="否">
                    </div>
                </div>
            </div>
            <input type="hidden" name="id" id="id" value="0" />
            <input type="submit" style="display: none;" name="dosubmit" id="dosubmit" value="dosubmit" />
        </form>
        <!-- END FORM-->
    </div>
</section>
@endsection