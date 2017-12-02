/**
 * Created by lotus on 17/11/19.
 */
$(document).ready(function () {

    $('.meun_sort').each(function () {
        $(this).blur(function () {
            var id = $(this).attr('data-id');
            var sort = $(this).val();
            $.ajax({
                url: "/public_menu/sort",
                data: {id: id,sort:sort},
                type: "post",
                dataType: "json",
                success: function (data) {
                    if(data.state == true){
                        var type = 'success';
                        var message = '设置成功';
                    }else{
                        var type = 'error';
                        var message = '设置失败';
                    }

                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "positionClass": "toast-bottom-right",
                        "onclick": null,
                        "showDuration": "1000",
                        "hideDuration": "1000",
                        "timeOut": "3000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "width":"250px"
                    };
                    toastr[type](message, "排序");
                }
            })
        });
    });

    /**
     * 添加
     */
    $('.author_add').click(function () {
        var url = $(this).data('url');
        //页面层
        layer.open({
            title: '添加标签',
            type: 2,
            btn: ['保存','取消'], //按钮
            yes: function(index, layero){ //或者使用btn1
                var formData = layer.getChildFrame('body');
                formData.find('#dosubmit').click();
                // layer.closeAll();
            },cancel: function(index){ //或者使用btn2
                layer.closeAll();
            },
            skin: 'layui-layer-rim', //加上边框
            area: ['600px','500px'], //宽高
            content: url,
            end: function () {
                // location.reload();
                var table = $('#main_table').DataTable();
                table.ajax.reload();
            }
        });
    });
})