@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')
    <style>
        .input_select{
            width:150px;height:36px;
        }
        .select_div{
            text-align: center;position:relative;
        }
        ._input{
            display:block;position:absolute;width:130px;margin-top:-36px;padding-left:10px;height:36px;
        }
        .add_tag_button{
            position: absolute;
            margin-top: -36px;
            height: 36px;
            margin-left: 83px;
        }
        .tag_button_position{
            float:left;margin-right:3px;
        }
    </style>
@endsection
@section('CUSTOM_SCRIPT')
    @include('vendor.ueditor.assets')
    <script type="text/javascript">
        var ue = UE.getEditor('container1',{
            initialFrameHeight:600
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    <script>
        $(document).ready(function(){
            if($('#input_select option:selected').val() != 0){
                $("#_input").val($("#input_select option:selected").text());
                $("#_input_bridge").val($("#input_select option:selected").val());
            }
            //作者字段变动的同时，光标离开
            $("#_input").change(function(){
                $("#_input").blur(function(){
                    $("#_input_bridge").val('0,'+$("#_input").val());
                });
            });
            //tag字段变动的同时，光标离开
            $("#_input_tag").change(function(){
                $("#_input_tag").blur(function(){
                    $("#_input_tag_bridge").val('0,'+$("#_input_tag").val());
                });
            });
        });
        function get_author() {
            $("#_input").val($("#input_select option:selected").text());
            $("#_input_bridge").val($("#input_select option:selected").val());

        }
        function get_tag() {
            $("#_input_tag").val($("#input_select_tag option:selected").text());
            $("#_input_tag_bridge").val($("#input_select_tag option:selected").val());
        }
        function del_self(obj){
            $(obj).parent().remove();
        }
        function add_tag(){
            if($('.tag_button_position').length>5){
                alert('一篇文章最多可以添加6个标签');
                return false;
            }
            //追加tag标签
            //非下拉框选择
            if($("#input_select_tag option:selected").val() == 0){
                if($("#_input_tag").val().length == 0){
                    alert('你还没有选择或设置标签');
                    return false;
                }else{
                    if($("#_input_tag").val() == "请选择标签"){
                        alert('你还没有选择或设置标签');
                        return false;
                    }
                    var tag_name = '0,'+$.trim($("#_input_tag").val());
                }
            }else{
                var tag_name = $.trim($("#_input_tag_bridge").val());
            }
//            alert(tag_name);return false;
            var regExp = /^\d+,/g;  //注意，这里没有引号
            var tag_button_name = tag_name.replace(regExp,'');
            try{
                $('.tag_button_position button').each(function(index,item){
                    var tag_name_all = $.trim($(item).html());

                    if(tag_button_name == tag_name_all){
                        alert('标签已存在');

                        throw('已存在');
                    }
                });
            }catch (e) {
                console.log(e);
                return false;
            }
            //随机产生标签颜色
            var colors = ['btn-primary','btn-success','btn-info','btn-warning','btn-danger'];
            var index = Math.floor((Math.random()*colors.length));
            var color = colors[index];
            var tag_button = '<div class="tag_button_position">'
                +'<button type="button" class="btn '+ color +'" onclick="del_self(this)">'+tag_button_name+'</button>'
                +'<input type="hidden" name="tags[]" value="'+ tag_name +'" > '
                +'</div>';
            $("#tag_group").append(tag_button);
        }
    </script>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-9 main-chart">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" placeholder="请输入标题">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                    <div class="row col-sm-10" >
                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">分类</label>
                            <div class="col-sm-9">

                                <select class="form-control" name="cate" id="cate">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>

                            </div>
                        </div>


                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">作者</label>
                            <div class="col-sm-9">

                                <div id="select_div" class="select_div">
                                    <select id="input_select" class="input_select"  onchange="get_author()">
                                        <option value="0">请选择作者</option>
                                        <option value="1,爬楼高手">爬楼高手</option>
                                        <option value="2,隔壁老尤条" >隔壁老尤条</option>
                                        <option value="3,测试3" >测试3</option>
                                        <option value="4,测试2" selected>测试2</option>
                                    </select>
                                    <input id="_input_bridge" class="_input" type="hidden" />
                                    <input id="_input" class="_input" type="text" />
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">内链</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="inner_link" placeholder="请输入内链">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">tags</label>
                    <div class="col-sm-10">
                        <div class="col-lg-4">
                            <div class="col-sm-12">
                                <div class="col-sm-9">

                                    <div id="select_div" class="select_div">
                                        <select id="input_select_tag" class="input_select" onchange="get_tag()">
                                            <option value="0" >请选择标签</option>
                                            <option value="1,爬楼高手">爬楼高手</option>
                                            <option value="2,隔壁老尤条" >隔壁老尤条</option>
                                            <option value="3,测试3" >测试3</option>
                                            <option value="4,测试2" >测试2</option>
                                            <option value="5,政治" >政治</option>
                                        </select>
                                        <input id="_input_tag" class="_input" type="text" />
                                        <input id="_input_tag_bridge"  type="hidden" />
                                        <button type="button" class="add_tag_button" onclick="add_tag()">add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="col-sm-12" id="tag_group">
                                <div class="tag_button_position">
                                    <button type="button" class="btn btn-success" onclick="del_self(this)">历史</button>
                                    <input type="hidden" name="tags[]" value="tags[]" >
                                </div>
                                <div class="tag_button_position">
                                    <button type="button" class="btn btn-success" onclick="del_self(this)">军事</button>
                                    <input type="hidden" name="tags[]" value="tags[]" >
                                </div>
                                <div class="tag_button_position">
                                    <button type="button" class="btn btn-success" onclick="del_self(this)">政治</button>
                                    <input type="hidden" name="tags[]" value="tags[]" >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">description</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="article_content" name="description" placeholder="文章描述"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">文章正文</label>
                    <div class="col-sm-10">
                        <script id="container1" name="content" type="text/plain"></script>
                    </div>
                </div>
            </form>
        </div><!-- /col-lg-9 END SECTION MIDDLE -->

    </div><! --/row -->
@endsection

