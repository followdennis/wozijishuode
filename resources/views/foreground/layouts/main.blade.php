<!DOCTYPE html>
<html lang="cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('logo/icon.png') }}" media="screen" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>我自己说的</title>

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link  href="{{asset('layui/src/css/layui.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
<div id="app">
    @include('foreground.shared.top_bar')
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <ul style="list-style: none">
                    <li></li>
                </ul>
            </div>
            <div class="col-md-8">
                @yield('nav')
                @yield('content')
            </div>
            <div class="col-md-3 ">
                <div style="height:15px;"></div>
                @yield('right_side')
            </div>
        </div>
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{asset('layui/src/layui.js')}}"></script>

<script>
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
            $.get("{{ url('article/like') }}",{article_id:article_id},function(data){
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
                        url = "{{ url('login') }}";
                        msg = '登陆';
                    }else if(login_flag == 0){
                        url = "{{ url('register') }}";
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
</script>
@yield('script')
</body>
</html>
