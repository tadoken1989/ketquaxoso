<div class="col-sm-2">
    <div id="left_date" class="kqbackground kqvertimarginw kqborder border"></div>
    <nav class="sidebar-nav kqvertimargin">
        <ul id="left_menu">
            <li class="active"><h2 class="lefth2"><a class="title"><i class="fa fa-calendar" aria-hidden="true"></i>
                        Trực tiếp xổsố</a></h2>
            </li>
            <ul class="border collapse in">
                <li><a href="{{ url('xo-so-mien-bac') }}">Truyền Thống<span class="dosam pull-right rolling-notyet"
                                                                            style="font-weight:400;"
                                                                            id="roll_marker_mb">18:15</span></a></li>
                <li><a href="{{ url('xo-so-dien-toan-123') }}">Điện Toán 123<span
                                class="dosam pull-right rolling-notyet" style="font-weight:400;" id="roll_marker_123">18:05</span></a>
                </li>
                <li><a href="{{ url('xo-so-than-tai') }}">Thần Tài<span class="dosam pull-right rolling-notyet"
                                                                        style="font-weight:400;" id="roll_marker_tt4">18:05</span></a>
                </li>
                @foreach(load_province_result_today() as $province)
                    @if(timeDiff($province['time'],date('H:i:s')) < 0)
                        <li>
                            <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $province['slug']]) }}">{{ $province['name'] }}
                                <span class="pull-right glyphicon glyphicon-ok rolling-finished"
                                      id="roll_marker_dt"></span></a></li>
                    @elseif(timeDiff($province['time'],date('H:i:s')) > 0 && timeDiff($province['time'],date('H:i:s')) < 3)
                        <li>
                            <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $province['slug']]) }}">{{ $province['name'] }}
                                <span class="pull-right glyphicon glyphicon-repeat fa-spin rolling-progress"
                                      id="roll_marker_tth"></span></a></li>
                    @else
                        <li>
                            <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $province['slug']]) }}">{{ $province['name'] }}
                                <span class="dosam pull-right rolling-notyet" style="font-weight:400;"
                                      id="roll_marker_tt4">{{ parseDate($province['time'],'H:i') }}</span></a></li>
                    @endif
                @endforeach
            </ul>
            <li><a class="title">Miền Bắc <span class="glyphicon"></span></a>
                <ul class="border collapse">
                    <li><a href="{{ route('frontend.result_lottery_via_province',['slug'=>'mien-bac']) }}">Truyền Thống</a></li>
                    <li><a href="{{ route('frontend.result_lottery_via_province',['slug'=>'dien-toan-123']) }}">Điện Toán 123</a></li>
                    <li><a href="{{ route('frontend.result_lottery_via_province',['slug'=>'dien-toan-6-36']) }}">Điện Toán 6x36</a></li>
                    <li><a href="{{ route('frontend.result_lottery_via_province',['slug'=>'than-tai']) }}">Thần Tài</a></li>
                </ul>
            </li>
            @foreach(region_left() as $rl)
                @if($rl['slug']  !=  'mien-bac')
                    <li>
                        <a class="title">{{$rl['name']}}<span class="glyphicon"></span></a>
                        <ul class="border collapse">
                            @foreach($rl['provinces'] as $typeLottery)
                                <li>
                                    <a href="{{ route('frontend.result_lottery_via_province',['slug'=>$typeLottery['slug']]) }}">{{$typeLottery['name']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>
</div>
