@extends('foreground.layouts.main')
@section('seo')
<title>@isset($article['title']){{ $article['title'] }} @endisset _{{ config('app.front_name', 'Laravel') }}网(wozijishuode.com)</title>
    <meta name="keywords" content="@isset($article['keywords']) {{ $article['keywords'] }}@endisset" />
    <meta name="description" content="@isset($article['description']) {{ $article['description'] }} @endisset" />
@endsection
@section('script')
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('js/bigautocomplete/bigautocomplete.js') }}" type="text/javascript"></script>
<script>
    var is_login = "{{ $is_login }}";
    var article_id = "{{$article['article_id']}}";
</script>
<script src="{{ asset('vendor/ueditor/third-party/SyntaxHighlighter/shCore.js') }}"></script>
<script>
    SyntaxHighlighter.all();
</script>
<script src="{{ asset('js/front/detail.js') }}"></script>
@endsection
@section('style')
    <link href="{{ asset('vendor/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/detail.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <ol class="breadcrumb">
            @foreach($breads as $bread)
                @if(isset($bread['is_title']))
                    <li class="active">{{ $bread['name'] }}</li>
                @else
                    <li><a href="{{ url("{$bread['prefix']}{$bread['pinyin']}") }}">{{ $bread['name'] }}</a></li>
                @endif
            @endforeach
        </ol>
        <div class="panel-body panel-body-detail">
            <div class="article_box">
                @if($is_exist)
                <h2 class="article-title">{{ $article['title'] }}</h2>
                <div class="article-sub"><!---->
                    <span>@if(empty($article['author']))佚名 @else{{ $article['author'] }} @endif</span>
                    <span>@if(empty($article['created_at']))2018-01-01 20:11:32 @else {{ $article['created_at'] }} @endif
                    </span>
                    <span>
                        浏览 {{ $article['click'] }}
                    </span>
                </div>
                <div class="article-content">
                    <div>
                        {!! $article['content'] !!}
                    </div>
                </div>
                <div class="article-tag">
                    <div class="tag-left">

                        <ul class="tag-list">

                            @if(!empty($article['tags_name']))
                                <li class="tag-item"><i class="fa fa-tags" aria-hidden="true"></i></li>
                                @foreach($article['tags_name'] as $tag)
                                    <li class="tag-item"><a href="/search/t/{{ $tag }}" target="_blank" class="label-link">{{ $tag }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="tag-right">
                        <ul class="tag-list">
                            <li class="tag-item"><a href="javascript:void(0)" class="label-link" onclick="collect_article()" >收藏</a></li>
                            <li class="tag-item"><a  href="javascript:void(0)"  onclick="article_report()" class="label-link">举报</a></li>
                        </ul>
                    </div>
                </div>
                    <div class="like_support">
                        <a href="javascript:;" onclick="article_click_like(this)" class="like_btn">赞(<span>{{ $article['like'] }}</span>)</a>
                    </div>
                @else
                    <div class="page-not-found">对不起，你查找的文章走丢了，浏览其他文章试试！</div>
                    <p>
                        <a href="/">返回首页</a>
                    </p>
                @endif
            </div>
            @if($is_exist)
                <div class="row page-pre-next">
                    <div class="col-md-6">
                        <span class="page-pre">上一篇：<a href="{{ $prev_url }}" @if($prev_url == '#') style="color:#f99f9f"; @endif>{{ $prev }}</a></span>
                    </div>
                    <div class="col-md-6">
                        <span class="page-next">下一篇：<a href="{{ $next_url }}" @if($next_url == '#') style="color:#f99f9f"; @endif>{{ $next }}</a></span>
                    </div>

                </div>
            @endif
            <div>
                <div style="float:left;margin-right:25px;">
                    @include('foreground.shared.ad1',['position'=>'detail_middle','is_show'=>1])
                </div>
                <div>
                    @include('foreground.shared.ad2',['position'=>'detail_middle','is_show'=>1])
                </div>
            </div>
            <div class="detail-comment" id="comments">
                @if($is_exist)
                    <comment-list is_login="{{ $is_login }}" article_id="{{ $article['article_id'] }}" comment_count="{{ $article['comments_count'] }}"></comment-list>
                @endif
            </div>
            <div class="relative">
                @include('foreground.shared.bottom_recommend')
            </div>
        </div>
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.search')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
    @include('foreground.shared.ad3',['position'=>'detail_right','is_show'=>1])
@endsection