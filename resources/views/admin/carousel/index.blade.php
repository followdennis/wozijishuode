@extends('layouts.main_layout')
@section('CUSTOM_STYLE')

@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{ asset('js/ajaxfileupload.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $(":button").click(function () {
                if ($("#file1").val().length > 0) {
                    ajaxFileUpload();
                }
                else {
                    alert("请选择图片");
                }
            })
        })
        function ajaxFileUpload() {
            $.ajaxFileUpload
            (
                {
                    url: '/back/upload', //用于文件上传的服务器端请求地址
                    type: 'POST',
                    data: {Id:'123',name:'lunis'}, //此参数非常严谨，写错一个引号都不行
                    secureuri: false, //一般设置为false
                    fileElementId: 'file1', //文件上传空间的id属性  <input type="file" id="file" name="file" />
                    dataType: 'JSON', //这里的json一定要为大写
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        alert(data);
                        $("#img1").attr("src", data.imgPath1);
                        alert("你请求的Id是" + data.Id + "     " + "你请求的名字是:" + data.name);
                        if (typeof (data.error) != 'undefined') {
                            if (data.error != '') {
                                alert(data.error);
                            } else {
                                alert(data.msg);
                            }
                        }
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        alert(e);
                    }
                }
            )
            return false;
        }
    </script>
@endsection
@section('content')
表单内容
    <p><input type="file" id="file1" name="file" /></p>
    <input type="button" value="上传" />
    <p><img id="img1" alt="上传成功啦" src="" /></p>
@endsection
@section('footer')
@endsection