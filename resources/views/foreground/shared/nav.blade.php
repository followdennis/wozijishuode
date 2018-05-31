<nav class="navbar navbar-default s-cate-bar" id="navbar">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle " data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">首页</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse " style="margin-left:36px;" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav nav-channel">
                @php $i = 0; @endphp
                @foreach($nav as $k => $item)

                    @if($item['is_leaf'] == 1)
                        @php if($i == 6) break; $i++; @endphp
                    <li class="channel-item @if($current_route == $item['pinyin']) nav-active @endif">
                        <a href="{{ url("ch/{$item['pinyin']}") }}">{{ $item['name'] }} <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    @else
                    <li class="channel-item dropdown">
                        <a href="{{ url("ch/{$item['pinyin']}") }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $item['name'] }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @foreach($item['children'] as $k => $subItem)
                                <li class="subnav @if($current_route == "{$item['pinyin']}_{$subItem['pinyin']}") nav-active @endif"><a href="{{url("ch/{$item['pinyin']}_{$subItem['pinyin']}")}}">{{ $subItem['name'] }}</a></li>
                            @endforeach
                            {{--<li role="separator" class="divider"></li>--}}
                        </ul>
                    </li>
                    @endif
                @endforeach
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>