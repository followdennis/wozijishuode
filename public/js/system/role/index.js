/**
 * Created by lotus on 16/11/15.
 */
$(document).ready(function () {

    $('.menu_del').each(function () {
        $(this).click(function () {
            var id = $(this).attr('data-id');
            swal({
                    title: "确定删除?",
                    text: "删除后，你将无法恢复!",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "取消",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "是的，确定删除",
                    closeOnConfirm: false
                }
            ).then(
                function(){
                    $.ajax({
                        url: "/role/del",
                        data: {id: id},
                        type: "post",
                        dataType: "json",
                        success: function (data) {
                            if(data.state == true){
                                var type = 'success';
                                var text = '操作成功';
                            }else{
                                var type = 'error';
                                var text = '操作失败';
                            }
                            swal({
                                title: '删除菜单',
                                text: text,
                                type: type,
                                timer: 3000
                            }).then(function () {
                                window.location.href='/menu/index';
                            });
                        }
                    })
                }
            );
        })
    });

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
     * 目前只用到这一个
     */
    $('.role_add').click(function () {
        var url = $(this).data('url');
        //页面层
        alert(url);
        layer.open({
            title: '添加角色',
            type: 2,
            btn: ['保存','取消'], //按钮
            yes: function(index, layero){ //或者使用btn1

                var formData = layer.getChildFrame('body');
                console.log(formData);
                formData.find('#dosubmit').click();
                // layer.closeAll();
            },cancel: function(index){ //或者使用btn2
                layer.closeAll();
            },
            skin: 'layui-layer-rim', //加上边框
            area: ['500px','400px'], //宽高
            content: url,
            end: function () {
                // location.reload();
                var table = $('#main_table').DataTable();
                table.ajax.reload();
            }
        });
    });
})