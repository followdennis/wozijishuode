@extends('layouts.common')

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('CUSTOM_SCRIPT')

    <script src="{{asset('metronic_theme/global/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script>
    {{--<script src="{{asset('js/layer/layer.js')}}" type="text/javascript"></script>--}}
    <script src="{{asset('js/jquery.form.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/utils/xsrf_ajax.js')}}" type="text/javascript"></script>

    <script src="{{asset('js/system/role/form.js')}}" type="text/javascript"></script>
    <script>

//        form.ajaxForm({success:showResponse });
        function showResponse(data, statusText)  {

            // $('#model_close').click();
            var id = $('#id').val();

            if(id == 0){
                var title = '添加角色';
            }else{
                var title = '编辑角色';
            }
            if(data.status == 1){
                swal({
                    title: title,
                    text: "操作成功!",
                    type: "success",
                    closeOnConfirm: false,
                    width:"250px"
                }).then(function () {
                    var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                    parent.layer.close(index); //再执行关闭
                    // parent.window.location.href='/back/role';
                });
            }else {
                swal({
                    title: title,
                    text: "操作失败!",
                    type: "error",
                });
            }

        }
    </script>
@endsection

@section('body')
    <section class="common_content">
    <div class="portlet-body" style="padding:25px 0 0 15px">
        <!-- BEGIN FORM-->
        <form action="{{route('role/add')}}" method="post" id="form_horizontal" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-body">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button> 表单存在错误，请检查！ </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button> 表单验证成功! </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">
                        角色名称
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <div class="mt-radio-list" data-error-container="#name_error">
                            <input type="text" id="name" name="name" value="" data-required="1" class="form-control" />
                        </div>
                        <div id="name_error"> </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">显示名称
                        <span class="required"> * </span>
                    </label>
                    <div class="col-xs-8">
                        <input type="text" name="display_name" value="" data-required="1" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-xs-3">描述</label>
                    <div class="col-xs-8">
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>

            </div>
            <input type="hidden" name="id" id="id" value="0" />
            <input type="submit"  name="dosubmit" id="dosubmit" value="dosubmit" />
        </form>
        <!-- END FORM-->
    </div>
    </section>
@endsection