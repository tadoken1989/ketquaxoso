@extends('frontend.layouts.index')
@section('content')
    <div class="col-sm-7">
        <div class="kqbackground border news-padding">
            <legend>
                <h2 class="newsh2 text-center dosam">Tin tức xổ số mới nhất</h2>
            </legend>
            @foreach($postsAll as $pAll)
                <div class="news-item">
                    <div class="news_image"><a class="news-list" href="{{route('detail',$pAll->slug)}}"><img
                                    alt="kqxs, xổ số, xsmb xsmn xsmt" title="{{$pAll->title}}"
                                    src="{{ url($pAll->image) }}"></a></div>
                    <div class="news-main">
                        <h4><a class="news-list" href="{{route('detail',$pAll->slug)}}">{{$pAll->title}}</a></h4>
                        <p class="newscontent des-list"> {{$pAll->excerpt}}</p>
                    </div>
                </div>
            @endforeach
            <nav aria-label="Page navigation" class="center" style="margin-top:10px;">
                <ul class="pagination pad10">
                    {!! $postsAll->links() !!}
                </ul>
            </nav>
        </div>
    </div>
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection