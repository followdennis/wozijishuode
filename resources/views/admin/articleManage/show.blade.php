@extends('layouts.main_layout')

@section('meta_description')aaa @endsection

@section('meta_keyword') 管理后台 @endsection

@section('CUSTOM_STYLE')

@endsection
@section('CUSTOM_SCRIPT')

@endsection
@section('content')
    <div class="container-fluid ">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p class="text-center"><h3>{{ $data['title'] }}</h3></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1 col-md-offset-1">
                作者:<em>{{ $data['author'] }}</em>
            </div>
            <div class="col-md-1">
                分类：<em>{{ $data['cate_name'] }}</em>
            </div>
            <div class="col-md-1">
                点击: <strong>{{ $data['click'] }}</strong>
            </div>
            <div class="col-md-1">
                赞:<strong>{{ $data['like'] }}</strong>
            </div>
            <div class="col-md-1">
                展示:@if($data['is_show'] == 1)<span class="glyphicon glyphicon-ok" style="color:green"></span>
                @else
                    <span class="glyphicon glyphicon-remove" style="color:red"></span>
                @endif
            </div>
            <div class="col-md-3">
                @if(!empty($data['tags_name']))
                    @php $tags = explode(',',$data['tags_name']);
                    foreach($tags as $tag){
                        echo $tag;
                    }
                    @endphp
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <p class="lead">
                    {{ $data['description'] }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                {!! $data['content'] !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                创建时间: <strong>{{ $data['created_at'] }}</strong>    &nbsp;&nbsp;更新时间:<strong>{{ $data['updated_at'] }}</strong>
            </div>
        </div>
    </div>
    <! --/row -->
@endsection

