@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    @if($resultLottery)
        <div class="col-sm-5">
            @if($resultLottery)
                <div class="kqbackground vien tb-phoi">
                    <div id="outer_result_mb">
                        <div class="result_div " id="result_mb">
                            <p class="lead text-center visible-print-inline">KETQUA.NET - Trang kết quả xổ số lớn nhất
                                Việt
                                Nam</p>
                            <div class="color333">
                                @include('frontend.partials.template_result_north',['resultLottery'=>$resultLottery,'province'=>$resultLottery->province])
                            </div>
                            @if($resultLottery->type == 'normal')
                                {{--Bingo--}}
                                @include('frontend.block.bingo')
                                {{--End Bingo--}}
                                {{--Bingo HeadEnd--}}
                                @include('frontend.block.bingoHeadEnd')
                                {{--End Bing HeadEnd--}}
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <hr>
            @if(isset($resultLotteriesOthers))
                {{--dientoan--}}
                @include('frontend.block.dientoan',['resultLotteriesOthers'=>$resultLotteriesOthers])
            @endif
            {{--end dientoan--}}
        </div>
    @else
        <div class="col-sm-5">
            <div class="kqbackground vien">
                <div id="outer_result_btr">
                    <div class="result_div" id="result_btr">
                        <br>
                        <p class="text-center"> Kết quả đang được cập nhật</p>
                    </div>
                </div>

            </div>
        </div>
    @endif
@endsection
@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection