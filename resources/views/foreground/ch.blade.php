@extends('foreground.layouts.main')
@section('seo')
<title>@isset($category['name']){{ $category['name'] }} @endisset _{{ config('app.front_name', 'Laravel') }}网(wozijishuode.com)</title>
    <meta name="keywords" content="@isset($category['keywords']){{ $category['keywords'] }}@endisset" />
    <meta name="description" content="@isset($category['description']){{ $category['description'] }}@endisset" />
@endsection
@section('script')
<script src="{{ asset('js/front/ch.js') }}" type="text/javascript"></script>
@endsection
@section('style')
@endsection
@section('nav')
    @include('foreground.shared.nav')
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <div class="panel-body" >
            <div style="float:left;">
                @include('foreground.shared.ad1',['position'=>'ch_top'])
            </div>
            <div style="float:right;">
                @include('foreground.shared.ad2',['position'=>'ch_top'])
            </div>
        </div>

        @include('foreground.shared.content_list')
        {{--
        {!! preg_replace(["~(/ch/[a-zA-Z]+)(/\d+)\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)?\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)~"], ['$1','$1$2$3','$1/$3'], $articles->links('foreground.pagination.page_ch')) !!}
        --}}
        {!! preg_replace(["~(/ch/[a-zA-Z]+)(/\d+)\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)?\?page=~","~(/ch/[a-zA-Z]+)(/)?(\d+)~"],['$1','$1$2$3','$1/$3'],$articles->links('foreground.pagination.simple-bootstrap-4')) !!}
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.search')
    @include('foreground.shared.hot')
    @include('foreground.shared.recommend')
    @include('foreground.shared.tags')
    @include('foreground.shared.ad3',['position'=>'ch_right'])
@endsection