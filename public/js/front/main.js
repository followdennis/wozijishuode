//一般直接写在一个js文件中
layui.use(['layer', 'form'], function(){
    var layer = layui.layer
        ,form = layui.form;
});
function click_like(obj){
    var is_login = $(obj).data('status');
    var article_id = $(obj).data('id');
    like_process(is_login,article_id,obj);
}
//文章点赞处理
function like_process(is_login,article_id,obj){
    if(is_login == 1){
        $.get("/article/like",{article_id:article_id},function(data){
            if(data.state == 1){
                var str = $(obj).text();
                var num = parseInt(str);
                $(obj).html('<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> ');
                $(obj).append(num+1);
                layer.tips('+1', obj, {
                    tips: [1, '#fb4c4c'],
                    time:1500
                });
                $(obj).css('color','#ed4040');
            }else if(data.state == 2){
                layer.tips('您已经赞过了哦', obj, {
                    tips: [1, '#fb4c4c'],
                    time: 1500
                });
            }else{
                layer.msg('点赞失败。。', {icon: 5});
            }
        })

    }else{
        var msg = '登陆';
        layer.open({
            type: 2,
            title: '请先'+msg,
            shadeClose: true,
            skin:'my-skin',
            btn: ['确定','取消'], //按钮
            yes:function(index, layero){
                var formData = layer.getChildFrame('body');
                var form = formData.find('#doSubmit').serialize();
                var login_flag = formData.find('input[name="is_login"]').val();
                var url = '';

                if(login_flag == 1){
                    url = "/login";
                    msg = '登陆';
                }else if(login_flag == 0){
                    url = "/register";
                    msg = '注册';
                }

                $.ajax({
                    url: url,
                    data: form,
                    type: "post",
                    dataType: "json",
                    async: false,
                    success: function (data) {
                        if(data.state == 1){
                            layer.msg(msg+'成功', {
                                icon: 1,
                                time: 1000 //2秒关闭（如果不配置，默认是3秒）
                            }, function(){
                                window.parent.location.reload();
                                layer.close(index);
                            });
                        }else{
                            layer.msg(msg+'失败。。', {icon: 5});
                        }
                    },
                    error: function(data) {
                        var error_msg = '';
                        $.each(data.responseJSON.errors, function (index, obj) {
                            error_msg += error_msg + index+" : "+obj[0] + "<br/>";
                            return false;
                        });
                        layer.msg(error_msg, {icon: 5});
                    }
                })
            },
            shade: 0.8,
            area: ['400px', '500px'],
            content: '/login?layer=1', //iframe的url
            cancel: function(index){ //或者使用btn2
                layer.closeAll();
            },
            end:function(index){
//                    layer.closeAll();
            }
        });
    }
}
function another_batch(){
    $.ajax({
        url:'/article/another_batch',
        type:'get',
        dataType:'html',
        success:function(data){
            $("#another_batch").html(data);
//                var list = '';
//                $.each(data.recommend,function(index,item){
//                    list += '<li class="list-group-item"><a href="'+ item.url +'"></a>'+ item.title +'</li>';
//                });
//                var html = '<div class="panel-heading">'
//                    +'<h3 class="panel-title" style="display:inline">'
//                    + '相关推荐'
//                    + '</h3>'
//                    + '<span class="change-one" onclick="another_batch()">'
//                    + '换一批'
//                    + '</span>'
//                    + '</div>'
//                    + '<div class="panel-body">'
//                    + '为您推送相关的文章！'
//                    + '</div>'
//                    + '<ul class="list-group">';
//                    html += list;
//                   html +='</ul>';
//                $("#another_batch").html(html);

        }
    });
}
$(document).ready(function(){
    var hot = $("#slide_more li:gt(6):not(:last)");
    hot.hide();
    var toggleBtn = $("#slide_more li.more");
    toggleBtn.on('click',function(){
        hot.slideToggle('fast',function(){
            if($(this).is(':visible')){
                toggleBtn.text('收起');
            }else{
                toggleBtn.text('更多');
            }
        });
        return false;
    })
})
