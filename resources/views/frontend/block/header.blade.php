<div class="row kqvertimargin">
    <div class="col-sm-3">
        <a href="/"> <img src="/frontend/images/20160220172641-4a1ca3a3.png" alt="kqsx trực tiếp kết quả xổ số"
                          height="90"></a>
    </div>
    @include('frontend.adv.header_top')
</div>
<div class="row kqvertimargin">
    <div class="col-sm-10 mae">
        <div class="BreakingNewsController easing" id="notiBox">
            <div class="bn-title">
                <span class="glyphicon glyphicon-bullhorn"></span> Thông báo
            </div>
            @if(load_notify())
            <ul>
                @foreach(load_notify() as $notify)
                    <li><a href="{{ $notify->url }}" target="_blank">{{ $notify->content }}</a></li>
                @endforeach
            </ul>
            @endif
            <div class="bn-arrows"><span class="bn-arrows-left"></span><span class="bn-arrows-right"></span></div>
        </div>
    </div>
</div>
@include('frontend.adv.header')