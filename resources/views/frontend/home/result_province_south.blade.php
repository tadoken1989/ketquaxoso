@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date',['province'=>$province])
@endsection
@section('content')
    @if($resultLottery)
    <div class="col-sm-5">
        <div class="kqbackground vien">
            <div id="outer_result_{{ $resultLottery->province->alias }}">
                <div class="result_div" id="result_{{ $resultLottery->province->alias }}">
                    <p class="lead text-center visible-print-inline">KETQUA.NET - Trang kết quả xổ số lớn nhấtViệtNam</p>
                    @include('frontend.partials.template_result_south',['resultLottery'=>$resultLottery,'province'=>$province])
                    {{--Bingo--}}
                    @include('frontend.block.bingo')
                    {{--End Bingo--}}
                    {{--Bingo HeadEnd--}}
                    @include('frontend.block.bingoHeadEnd')
                    {{--End Bing HeadEnd--}}
                    <span id="date_{{ $resultLottery->province->alias }}" hidden="">{{ parseStringToDate($resultLottery->result_day) }}</span>
                </div>
            </div>
        </div>
        <hr style="margin: 1px;">
        @if(isset($resultLottery))
            @include('frontend.partials.statistical',['province'=>$province, 'resultLottery'=>$resultLottery,'name'=>$province->name])
        @endif
    </div>
    @else
        <div class="col-sm-5">
            <div class="kqbackground vien">
                <div id=outer_result_btr">
                    <div class="result_div" id="result_bdu">
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
