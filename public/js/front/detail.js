$(document).ready(function(){
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        url:'/browse',
        type:'post',
        dataType:'json',
        data:{article_id:article_id},
        success:function(data){
            console.log(data.msg);
        }
    })
    $("#search_input").bigAutocomplete({
        width:228,
        url:'/search/auto',
        callback:function(data){
            //alert(data.title);
        }
    });
});
function article_click_like(obj){
    like_process(is_login,article_id,obj);
}
function article_report(){
    if(is_login == 1){
        layer.prompt({title: '请输入举报原因', formType: 2}, function(pass, index){
            if(pass.length > 255){
                layer.msg('输入的字符过长');
                return false;
            }
            var url = '/article_comment/report';
            var data = {
                type:1,
                article_id:article_id,
                description:pass,
                comment_id:0
            }
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: url,
                data: data,
                type: "post",
                dataType: "json",
                async: true,
                success: function (data) {
                    if(data.state == 1){
                        layer.msg('举报成功', {
                            icon: 1,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        }, function(){

                        });
                    }else{
                        layer.msg('举报失败', {icon: 5});
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            })
            layer.close(index);
        });
    }else{
        checkLogin();
    }
}
function like_process(is_login,article_id,obj){

    if(is_login == 1){
        $.get("/article/like",{article_id:article_id},function(data){
            if(data.state == 1){
                var str = $(obj).children().eq(0).text();

                var num = parseInt(str)+1;
                $(obj).html('赞(<span>'+ num +'</span>) ');
                layer.tips('+1', obj, {
                    tips: [1, '#fb4c4c'],
                    time:1500
                });
//                        $(obj).css('color','#ed4040');
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
        checkLogin();
    }
}
function collect_article(){
    if(is_login == 1){
        index = layer.confirm('确定收藏该文章？', {
            btn: ['确定','取消'], //按钮
            shade: false //不显示遮罩
        }, function(){
            $.ajax({
                type: "GET",
                url: "/article/collect",
                data: {article_id:article_id},
                dataType:'json',
                success: function(data){
                    if(data.code == 1){
                        layer.msg(data.msg,{
                            icon:1
                        });
                    }else if(data.code == 2){
                        layer.msg(data.msg,{
                            icon:5
                        });
                    }else{
                        layer.msg(data.msg,{
                            icon:5
                        });
                    }
                }
            });
        }, function(){
            layer.close(index);
        });
    }else{
        checkLogin();
    }
}
function checkLogin(){
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
                msg = '登陆';
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
        shade: 0.5,
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