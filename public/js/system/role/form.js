$(document).ready(function() {

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
            // name: {
            //     required: true,
            //     remote: {
            //          url: '/back/ajax_role/check_role_exist',
            //          type: "post",
            //          dataType: "json",
            //          data: {
            //              'id': function () {
            //                  return $("#id").val();
            //              },
            //              'name': function () {
            //                  return $("#name").val();
            //              }
            //          }
            //      }
            // },
            name:{
               required:true
            },
            display_name:{
                required: true
            }
        },
        messages: {
            name:{
                required:"角色名称必须填写",
                remote:"角色名称已经存在"
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

        }
    });

    form.ajaxForm({success: showResponse});

    // form.submit(function() {
    //     // 提交表单
    //     $(this).ajaxForm({success: showResponse});
    //     // $(this).ajaxForm({success: showResponse});
    //     // 为了防止普通浏览器进行表单提交和产生页面导航（防止页面刷新？）返回false
    //     return false;
    // });
    // post-submit callback
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
});