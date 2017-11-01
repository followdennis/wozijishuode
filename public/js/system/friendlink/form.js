$(document).ready(function() {
    /**
     * 编辑时，密码的特殊处理插件
     * 2017-10-15
     * author libo
     */
    // $('#role_id').bind('change',function () {
    //     var role_id=$("#role_id").val();  //获取选中的角色
    //     console.log(role_id)
    // })



    var form = $('.form-horizontal');
    var errorTip = $('.alert-danger', form);
    var successTip = $('.alert-success', form);

    form.validate({
        debug: false,
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "",  // validate all fields including form hidden input
        rules: {
            name: {
                minlength: 2,
                maxlength:100,
                required: true
            },
            link_url:{
                required:true,
                minlength:5,
                maxlength:100
            },
            sort:{
                required:true,
            },
        },
        messages: {
            name:{
                required:"网站名称必填",
                minlength:"最少两个字符",
            },
            link_url:{
                required:"网站地址必填",
                minlength:"链接地址最少5个字符"
            },
            sort:{
                required:"排序值必填"
            },
        },

        invalidHandler: function (event, validator) { //display error alert on form submit
            successTip.hide();
            errorTip.show();
            App.scrollTo(errorTip, -200);
        },

        errorPlacement: function (error, element) { // render error placement for each input type
            var icon = $(element).parent('.input-icon').children('i');
            icon.removeClass('fa-check').addClass("fa-warning");
            icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});

            if (element.parents('.mt-radio-list') || element.parents('.mt-checkbox-list')) {
                if (element.parents('.mt-radio-list')[0]) {
                    error.appendTo(element.parents('.mt-radio-list')[0]);
                }
                if (element.parents('.mt-checkbox-list')[0]) {
                    error.appendTo(element.parents('.mt-checkbox-list')[0]);
                }
            } else if (element.parents('.mt-radio-inline') || element.parents('.mt-checkbox-inline')) {
                if (element.parents('.mt-radio-inline')[0]) {
                    error.appendTo(element.parents('.mt-radio-inline')[0]);
                }
                if (element.parents('.mt-checkbox-inline')[0]) {
                    error.appendTo(element.parents('.mt-checkbox-inline')[0]);
                }
            } else if (element.parent(".input-group").size() > 0) {
                error.insertAfter(element.parent(".input-group"));
            } else if (element.attr("data-error-container")) {
                error.appendTo(element.attr("data-error-container"));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }

        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight
        },

        success: function (label, element) {
            var icon = $(element).parent('.input-icon').children('i');
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
            icon.removeClass("fa-warning").addClass("fa-check");
        },
    });

    form.ajaxForm({success: showResponse});

    // post-submit callback
    function showResponse(data, statusText)  {

        $('#model_close').click();
        if($('#id').val() == 0){
            var title = '添加';
        }else{
            var title = '编辑';
        }
        if(data.status == 1){
            swal({
                title: title,
                text: "操作成功!",
                type: "success",
                closeOnConfirm: false
            }).then(function(){
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                // parent.window.location.href='/back/user';
            });
        }else {
            swal({
                title: title,
                text: "操作失败!",
                type: "error",
            });
        }

    }

});