@extends('frontend.layouts.index')
@section('content')
    <div class="col-sm-7">
        <div class="kqbackground border news-padding">
            <legend>
                <h2 class="newsh2 text-center dosam">{{$detail->title}}</h2>
            </legend>
            <h5 class="description">{{$detail->excerpt}}</h5>
            <h5 class="newscontent">
                {!! $detail->body !!}
            </h5>
            <ul class="tags-list">
                @foreach($detail->tags as $tags)
                    <li class="tags"><a class="link-tags" href="{{route('postByTag',$tags->slug)}}"
                                        target="_blank">{{$tags->tag}}</a></li>
                @endforeach
            </ul>
            <legend>
                <h3 class="newsh3 text-center">Tin tức xổ số mới nhất</h3>
            </legend>
            <ul>
                @foreach($all as $a)
                    <li>
                        <h4 class="relatenews"><a href="{{route('detail',$a->slug)}}">{{$a->title}}</a></h4>
                    </li>
                @endforeach
            </ul>
            <legend>
                <h4 class="relatenews text-center"><a class="chu17 maudo" href="{{route('tin-tuc-xo-so')}}"><i
                                class="fa fa-hand-o-right" aria-hidden="true"></i> Xem tất cả bài tin tức xổ số </a>
                </h4>
            </legend>
            <div class="fb-comments" data-href="{{route('detail',$a->slug)}}" data-width="716" data-numposts="5"></div>
        </div>
    </div>
@endsection
@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection
