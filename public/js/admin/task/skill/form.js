/**
 * Created by lotus on 16/11/15.
 */
$(document).ready(function () {

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
            chef_info:{
                required: true
            },
            launch_person: {
                required: true
            },
            launch_person_phone: {
                required: true,
                digits:true
            },
            report_person: {
                required: true
            },
            report_person_phone: {
                required: true,
                digits:true
            },
            report_desk_number: {
                required: true,
                digits:true
            },
            report_person_number: {
                required: true,
                digits:true
            },
            area_code: {
                required: true
            },
            launch_date: {
                required: true
            },
            launch_edate: {
                required: true
            },
            report_date: {
                required: true
            },
            launch_address: {
                required: true
            },
            launch_reason: {
                required: true
            }

        },
        messages: {
            chef_info:{
                required:"厨师必填"
            },
            launch_person:{
                required:"家宴举办人必填"
            },
            launch_person_phone:{
                required:"举办人电话必填",
                digits:"电话号码格式不正确"
            },
            report_person:{
                required:"报备人必填"
            },
            report_person_phone:{
                required:"报备人电话必填",
                digits:"电话号码格式不正确"
            },
            report_desk_number:{
                required:"家宴桌数必填",
                digits:"家宴桌数为整数"
            },
            report_person_number:{
                required:"参加人数必填",
                digits:"参加人数为整数"
            },
            area_code:{
                required:"地区必填"
            },
            launch_date:{
                required:"举办开始时间必填"
            },
            launch_edate:{
                required:"举办结束时间必填"
            },
            report_date:{
                required:"报备日期必填"
            },
            launch_address:{
                required:"举办地址必填"
            },
            launch_reason:{
                required:"举办事由必填"
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
        if(data.action=='add'){
            var title = '添加技能任务';
        }else{
            var title = '编辑技能任务';
        }

        if(data.status == 1){
            swal({
                title: title,
                text: data.msg,
                type: "success",
                timer: 3000
            }).then(function () {
                // var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                // parent.layer.close(index); //再执行关闭
                window.location.href='/back/skill_task';
            });

        } else {
            swal({
                title: title,
                text: data.msg,
                type: "error",
            });
        }

    }

    $('#chef').on("select2:select",function(e){
        var chef_list = e.params.data.data;
        initCheckInfo(chef_list);
    });

    function initCheckInfo(data) {
        $('#chef_id').val(data.id);
        $('#chef_name').val(data.chef_name);
        $('#chef_info').val(data.chef_name+'('+data.chef_phone+')');
    }

    $("#effective_date_start").datepicker({
        todayBtn: "linked",
        clearBtn: true,
        language: "zh-CN",
        calendarWeeks: false,
        autoclose: true,
        todayHighlight: true
    });

    $("#effective_date_end").datepicker({
        todayBtn: "linked",
        clearBtn: true,
        language: "zh-CN",
        calendarWeeks: false,
        autoclose: true,
        todayHighlight: true,
    });
    $("#reward_dates").datepicker({
        todayBtn: "linked",
        clearBtn: true,
        language: "zh-CN",
        calendarWeeks: false,

        autoclose: true,
        todayHighlight: true,
    });

    $('#area_name').val(($('#area_code option:selected').attr('data-area_name')));

    $(document).on('change','#area_code',function(){
        $('#area_name').val(($('#area_code option:selected').attr('data-area_name')));
    })

})