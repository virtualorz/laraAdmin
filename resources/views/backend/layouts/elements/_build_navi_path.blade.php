@foreach(Sitemap::getNaviPath() as $k=>$v)
    <li><a href="{{ $v['url'] }}">{{ $v['text'] }}</a></li>
@endforeach
