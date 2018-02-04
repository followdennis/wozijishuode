@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')
    <link href="{{asset('vendor/bootstrap-switch/bootstrap-switch.css')}}" rel="stylesheet" type="text/css" />
    <style>
    .input_select_2{
        width:150px;height:36px;
    }
    .select_div{
        text-align: center;position:relative;
    }
    ._input{
        display:block;position:absolute;width:130px;margin-top:-36px;padding-left:10px;height:36px;
    }
    .select_div_2{
        text-align: left;position:relative;margin-left: -15px;
    }
    .add_tag_button_2{
        height: 36px;
        margin-left: -5px;
    }
    .tag_button_position{
        float:left;margin-right:3px;
    }
</style>
@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{asset('vendor/bootstrap-switch/bootstrap-switch.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/common.js')}}" type="text/javascript"></script>
    @include('vendor.ueditor.assets')
    <script type="text/javascript">
        var ue = UE.getEditor('container1',{
            toolbars:[[
                'fullscreen',  '|', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'cleardoc', '|',
                'lineheight', '|',
                'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                'simpleupload', 'insertimage', 'emotion',   'insertcode',  'template', 'background', '|',
                'horizontal', 'date', 'time', 'spechars', 'snapscreen',  '|',
                'inserttable', 'deletetable',  '|',
                'preview', 'searchreplace'
            ]],
            initialFrameHeight:600
        });
        ue.ready(function() {
            ue.setContent("{!! $data['content'] !!}");
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    <script>
        $(document).ready(function(){
            //设置文章默认值
            //tag字段变动的同时，光标离开
            $("#_input_tag").change(function(){
                $("#_input_tag").blur(function(){
                    $("#_input_tag_bridge").val('0,'+$("#_input_tag").val());
                });
            });
        });
        //设置文章初始值
        function clearmyedit(){
            UE.getEditor('container1').setContent('abc');
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
                swal({
                    title: "操作失败",
                    text: '一篇文章最多可以添加6个标签',
                    type: "error",
                });
                return false;
            }
            //追加tag标签
            //非下拉框选择
            if($("#input_select_tag option:selected").val() == 0){
                if($("#_input_tag").val().length == 0){
                    swal({
                        title: "操作失败",
                        text: '您还没有选择标签',
                        type: "error",
                    });
                   return false;
                }else{
                    if($("#_input_tag").val() == "请选择标签"){
                        swal({
                            title: "操作失败",
                            text: '您还没有选择标签',
                            type: "error",
                        });
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
                        swal({
                            title: "操作失败",
                            text: '标签已存在',
                            type: "error",
                        });

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
            <form action="{{ route('articles/edit') }}" method="post" id="form_horizontal"  enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    {{ csrf_field() }}
                    <label for="inputEmail3" class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="title" name="title" value="{{ $data['title'] }}" placeholder="请输入标题">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                    <div class="row col-sm-10" >
                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">分类</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="cate" id="cate">
                                    {!! $data['cate_list'] !!}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">作者</label>
                            <div class="col-sm-9">

                                <div id="select_div" class="select_div">
                                    <select id="input_select" class="form-control" name="author">
                                        <option value="0">请选择作者</option>
                                        @foreach($data['author_list'] as $author)
                                            <option value="{{ $author->author }}" @if( $author->author == $data['author_and_id']) selected @endif>{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4">
                            <label for="description" class="col-sm-3 control-label">内链</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="inner_link" value="{{ $data['inner_link_name'] }}" placeholder="请输入内链">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">tags</label>
                    <div class="col-sm-10">
                        <div class="col-lg-3">
                            <div id="select_div" class="select_div_2">
                                <select id="input_select_tag" class="input_select_2" onchange="get_tag()">
                                    <option value="0" >请选择标签</option>
                                    @foreach($data['tags_list'] as $tag)
                                        <option value="{{ $tag->id }},{{$tag->name}}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                                <input id="_input_tag" class="_input" type="text" />
                                <input id="_input_tag_bridge"  type="hidden" />
                                <button type="button" class="add_tag_button_2" onclick="add_tag()">add</button>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="col-sm-12" id="tag_group">
                                @if(!empty($data['tags_name']))
                                    @foreach($data['tags_name'] as $k => $tag)
                                    <div class="tag_button_position">
                                        <button type="button" class="btn btn-success" onclick="del_self(this)">{{ $tag }}</button>
                                        <input type="hidden" name="tags[]" value="{{ $data['tags_id'][$k] }},{{ $tag }}" >
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" id="article_content" name="description" placeholder="文章描述">@if(!empty($data['description'])){{ $data['description'] }}@endif</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                       <span>创建时间：{{ $data['created_at'] }}</span>
                       <span>赞：{{ $data['like'] }}</span>
                       <span>点击：{{ $data['click'] }}</span>
                        <span>发布状态：  <input type="checkbox" name="is_show" @if($data['is_show']) checked @endif class="make-switch" data-on-text="已发布" data-off-text="未发布"></span>
                        @if($data['is_show'] ==1)
                            <span>发布时间:2018-01-01</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">文章正文</label>
                    <div class="col-sm-10">
                        <script id="container1" name="content" type="text/plain"></script>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <input type="hidden" name="click" value="{{ $data['click'] }}">
                       <button type="submit" class="btn blue">保存</button>
                    </div>
                </div>
            </form>
        </div><!-- /col-lg-9 END SECTION MIDDLE -->

    </div><! --/row -->
@endsection

