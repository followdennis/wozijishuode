@extends('layouts.wx')
@section('CUSTOM_STYLE')
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.css') }}">
    <style>

    </style>

@endsection
@section('CUSTOM_SCRIPT')
    <script src="{{ mix('js/wechat.js') }}"></script>
    <script type="text/javascript">

    </script>
@endsection
@section('content')
    <div class="container" id="wechat">
        <router-view></router-view>
    </div>
@endsection
