@extends('layouts.app_front')
@section('style')
    <link href="{{ asset('admin/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <style>
        .navbar{
            min-height:45px;
        }
        .s-top-bar{
            background:#21292f;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">登陆</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('front.login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">邮箱地址</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    登陆
                                </button>
                                <a class="btn btn-link" href="{{ route('front.password.request') }}">
                                    忘记密码?
                                </a>
                            </div>
                        </div>
                        <div class="form-group" style="border-top:1px solid rgba(185,204,187,0.55);padding-top:10px;">
                            <label for="email" class="col-md-4 control-label">其他方式登陆</label>
                            <div class="col-md-6">
                                <div style="padding-top:5px;padding-left:-5px;">
                                    <a style="padding:5px;margin-top:10px;">
                                        <img src="{{ asset('foreground/images/Connect_logo_7.png') }}" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
