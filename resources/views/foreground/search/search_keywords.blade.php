@extends('foreground.layouts.main')
@section('script')
<script>
    $(document).ready(function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $("#auto_search").bigAutocomplete({
            width:618,
            url:'{{ url('search/auto') }}',
            callback:function(data){
                //alert(data.title);
            }
        });
    })
</script>
@endsection
@section('style')
    <style>
        form{
            margin:0;
            padding:0;
        }
        .y-left{
            height: 40px;
            padding: 0 16px;
            background-color: #fff;
            border: 1px solid #ed4040;
            box-sizing: border-box;
            border-radius: 4px 0 0 4px;
        }
        .y-left:focus{
            border:0;outline:none;
            border: 1px solid #ed4040;
            webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }
        .y-right{
            outline: 0;
            border: 0;
            background: #ed4040;
            font-size: 16px;
            text-align: center;
            color: #fff;
            border-radius: 0 4px 4px 0;
        }
        .y-right .search-btn:focus{
            outline: 0;
            border: 0;
            background: #ed4040;
        }
        .search-btn{
            outline: 0;
            border: 0;
            width:100px;
            background: #ed4040;
            font-size: 16px;
            line-height: 40px;
            text-align: center;
            color: #fff;
            border-radius: 0 4px 4px 0;
            padding:0;
        }
        .search-btn:hover,.search-btn:visited,.search-btn:link.search-btn:active{
            background: #ed4040;
            color: #fff;
        }
        #search-btn{
            background: #ed4040;
            color: #fff;
        }
        .btn-default{
            background: #ed4040;
            color: #fff;
        }

        .search-bar{
            margin-top:30px;
            overflow:hidden;
        }
    </style>
@endsection
@section('nav')
    <div class="search-bar">
        <form action="{{ url('search') }}" method="get" name="searchForm">
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" value="{{ $kw }}" placeholder="请输入关键词" name="keywords" id="auto_search" class="form-control y-left">
                    <span class="input-group-btn y-right">
						<button class="btn btn-default search-btn" id="search-btn" type="submit">
							搜索
						</button>
                     </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </form>
    </div>
@endsection
@section('content')
    <div class="panel panel-default article-list">
        <div class="panel-body">
            <div class="">
               热门搜索：
                @foreach($words as $word)
                    <a href="{{ url('search?keywords='.$word->keywords) }}" >{{ $word->keywords }}</a>
                @endforeach
            </div>
        </div>
        @include('foreground.shared.content_list')
    </div>
@endsection
@section('right_side')
    @include('foreground.shared.hotsearch')
    @include('foreground.shared.latest_hot')
    @include('foreground.shared.tags')
@endsection