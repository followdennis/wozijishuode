$(document).ready(function() {

    jQuery.validator.addMethod("check_permission", function (value, element) {
        var permissions_display_name = $.trim($('#permissions_display_name').val());
        var permissions_description = $.trim($('#permissions_description').val());
        var permissions_name = $.trim($('#permissions_name').val());
        if(permissions_name == ''){
            if(permissions_display_name != '' || permissions_name != ''){
                return false;
            }else {
                return true;
            }
        }else{
            return true;
        }
    }, "路由必须填写");

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
            parent_id: {
                required: true
            },
            name: {
                minlength: 2,
                required: true
            },
            sort: {
                required: true,
                digits: true
            }
        },
        messages: {
            parent_id:{
                required:"父id必填"
            },
            name:{
                required:"菜单名称必填"
            },
            sort:{
                remote:"排序值必填"
            }
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
        if(data.action == 'add'){
            var title = '添加分类';
        }else{
            var title = '编辑分类';
        }
        if(data.status == 1){
            swal({
                title: title,
                text: "操作成功!",
                type: "success",
                closeOnConfirm: false
            }).then(function(){
                // console.log('fff')
                var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                parent.layer.close(index); //再执行关闭
                // parent.window.location.href="/back/menus";
            });
        } else {
            swal({
                title: title,
                text: "操作失败!",
                type: "error",
            });
        }

    }

});