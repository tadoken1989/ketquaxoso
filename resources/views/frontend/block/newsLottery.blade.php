<div class="kqvertimarginw">
    <div class="kqvertimarginw">
        <div class="sidebar-nav">
            <h3 class="right-menu-title"><i class="fa fa-newspaper-o"></i> Tin tức xổ số mới nhất</h3>
        </div>
        <div class="panel-body pad0">
            <div class="table-responsive">
                <table class="table table-bordered mar0">
                    <tbody style="font-size: smaller;">
                    <tr>
                        <td>
                            <ul class="mien2">
                                @foreach(posts() as $post)
                                    <li>
                                        <a href="{{route('detail',$post->slug)}}">
                                            <p>{{$post->title}}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <a class="more-news" href="{{route('tin-tuc-xo-so')}}">Xem thêm</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('frontend.adv.right_top')