@extends('frontend.layouts.index')
@section('content')
    <div class="col-sm-7">
        <div class="kqbackground border news-padding">
            <legend>
                <h2 class="newsh2 text-center dosam">Tin tức xổ số mới nhất</h2>
            </legend>
            @foreach($post as $pTags)
                <div class="news-item">
                    <div class="news_image"><a class="news-list" href="{{route('detail',$pTags->slug)}}"><img
                                    alt="kqxs, xổ số, xsmb xsmn xsmt" title="{{$pTags->title}}"
                                    src="{{ url($pTags->image) }}"></a></div>
                    <div class="news-main">
                        <h4><a class="news-list" href="{{route('detail',$pTags->slug)}}">{{$pTags->title}}</a></h4>
                        <p class="newscontent des-list"> {{$pTags->excerpt}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection