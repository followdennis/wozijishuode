$(document).ready(function() {
    /**
     * 编辑时，密码的特殊处理插件
     * 2017-10-15
     * author libo
     */
    jQuery.validator.addMethod("check_password", function (value, element,param) {
        var user_id = $.trim($('#id').val());
        var password = $.trim($('#password').val());
        var permissions_description = $.trim($('#permissions_description').val());
        var permissions_name = $.trim($('#permissions_name').val());
        console.log(param);

        return false;
    }, "路由必须填写");

    $('.mt-multiselect').each(function(){
        var btn_class = $(this).attr('class');

        // advanced functions
        var onchange_function = function(option, checked, select) {
            // alert('Changed option ' + $(option).val() + '.');
        }

        // init advanced functions
        var onchange = ($(this).data('action-onchange') == true) ? onchange_function : '';

        // template functions
        // init variables
        var li_template;
        if ($(this).attr('multiple')){
            li_template = '<li class="mt-checkbox-list"><a href="javascript:void(0);"><label class="mt-checkbox"> <span></span></label></a></li>';
        } else {
            li_template = '<li><a href="javascript:void(0);"><label></label></a></li>';
        }

        // init multiselect
        $(this).multiselect({
            nonSelectedText:'请选择角色',
            enableFiltering: true,
            filterPlaceholder:'搜索',
            includeSelectAllOption: true,
            selectAllText:"全选",
            disableIfEmpty: true,
            buttonWidth: '100%',
            maxHeight: '270',
            onChange: onchange,
            buttonClass: btn_class,
            // optionClass: function(element) { return "mt-checkbox"; },
            // optionLabel: function(element) { console.log(element); return $(element).html() + '<span></span>'; },
            // templates: {
            //  li: li_template,
            //  }
        });
    });

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
                maxlength:12,
                required: true,
                remote: {
                    url: '/back/user/check_exists',
                    type: "post",
                    dataType: "json",
                    data: {
                        'name': function () {
                            return $("#name").val();
                        },
                        'user_id':function(){
                            return $("#id").val();
                        }
                    }
                }
            },
            email:{
                required:true,
                minlength:5,
                maxlength:20,
                email:true,
                remote:{
                    url:'/back/user/check_exists',
                    type:"post",
                    dataType:"json",
                    data:{
                        'email':function(){
                            return $("#email").val();
                        },
                        'user_id':function(){
                            return $("#id").val();
                        }
                    }
                }
            },
            password:{
               required:function(){
                 if($("#id").val().length >15){
                     return false;
                 }else{
                     return true;
                 }
               },
                minlength: function(){
                    if($("#id").val().length >15){
                        var pw = $("#password").val();
                       if(pw.length >0){
                           return 6;
                       }
                    }else{
                        return 6;
                    }
                },
                maxlength:function(){
                    if($("#id").length >15){
                        var pw = $("#password").val();
                        if(pw.length >0){
                            return 6;
                        }
                    }else{
                        return 18;
                    }
                }
            },
            'role_id[]':{
                required: true
            },
        },
        messages: {
            name:{
                required:"登录名必填",
                remote:"登陆名已存在",
                minlength:"最少两个字符",
                maxlength:"最少十二个字符"
            },
            password:{
                required:"密码必填",
                minlength:"密码最少6位",
                maxlength:"密码最大18位"
            },
            email:{
                required:"邮箱必填",
                remote:"邮箱已经存在",
                minlength:"最少五个字符",
                maxlength:"最长二十个字符",
                email:"邮箱格式不正确"
            },
            'role_id[]':{
                required:"请选择角色"
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
        }else if(data.status == -1){
            swal({
                title: title,
                text: "用户已存在!",
                type: "error",
            });
        }else {
            swal({
                title: title,
                text: "操作失败!",
                type: "error",
            });
        }

    }

    //选择站点
    if($('#site_id').length > 0)
    {
        $('#site_id').change(function () {
            var site_id = $(this).val();
            //重置角色 -- multiselect
            $.ajax({
                url: "/public_role/user_choice",
                data: {site_id: site_id},
                type: "post",
                dataType: "json",
                async:false,
                cache:false,
                success: function (data) {
                    $('#role_id').empty();
                    var newRoles = new Array();
                    var obj = new Object();
                    $.each(data, function(index, role) {
                        $("#role_id").append('<option value="' + role.id + '">' + role.display_name + '</option>');
                        obj = {
                            label : role.display_name,
                            value : role.id
                        };
                        newRoles.push(obj);
                    });
                    $("#role_id").multiselect('dataprovider', newRoles);
                    $('#role_id').multiselect('refresh')
                }
            });
            //重置部门 - html
            $.ajax({
                url: "/public_department/user_choice",
                data: {site_id: site_id},
                type: "post",
                dataType: "json",
                async:false,
                cache:false,
                success: function (data) {
                    $('#department_id').empty();
                    $('#department_id').append(data.html);
                }
            });
            //重置管辖区域
            if(site_id == 0)
            {
                var html = '<input value="" placeholder="输入并选择提示" type="text" id="site_area_name" name="site_area_name" data-required="1" class="form-control site_area_name" />'+
                    '<input value=""  type="hidden" id="area_code" name="area_code" class="form-control area_code" />';
                $('#area_code_content').html(html);
                $( "#site_area_name" ).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "/public_area/select",
                            dataType: "jsonp",
                            data: {
                                featureClass: "P",
                                style: "full",
                                maxRows: 20,
                                keyword: request.term
                            },
                            success: function(data) {
                                response($.map(data, function(item) {
                                    return {
                                        label: item.area_name,
                                        value: item.area_name,
                                        area_code: item.area_code
                                    }
                                }));
                            }
                        });
                    },
                    select: function(e, ui) {
                        $('#area_code').val(ui.item.area_code);
                    },
                    minChars: 2,  //最少输入字条
                    minLength: 2
                });
            }else{
                $.ajax({
                    url: "/public_area/user_choice",
                    data: {site_id: site_id},
                    type: "post",
                    dataType: "json",
                    async:false,
                    cache:false,
                    success: function (data) {
                        $('#area_code_content').html(data.html);
                    }
                });
            }

        });
    }
});