@foreach($list as $k => $v)
    {{ $v->id."---".$v->title }}
    <a href="{{route('articles/show',['id'=>$v->id])}}" >查看</a>
    <br/>

@endforeach
{{ $page->links() }}