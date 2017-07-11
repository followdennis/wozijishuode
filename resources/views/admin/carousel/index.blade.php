@extends('layouts.main_layout')
@section('CUSTOM_STYLE')

@endsection
@section('CUSTOM_SCRIPT')

@endsection
@section('content')
<div class="row">
    <form method="post" action="{{ url('upload') }}" class="col-md-4 col-md-offset-4">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="fileupload_input">请选择文件</label>
            <input type="file" class="form-control" id="fileupload_input" placeholder="file">
        </div>
        <button type="submit" class="btn  btn-primary">Submit</button>
    </form>
</div>
@endsection
@section('footer')
@endsection