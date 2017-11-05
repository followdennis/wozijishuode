@foreach($list as $k => $v)
    {{ $v->id."---".$v->title }}<br/>
@endforeach
{{ $page->links() }}