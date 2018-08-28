@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    @if($resultLottery)
        <div class="col-sm-5">
            @include('frontend.adv.top_home')
            <div class="kqbackground vien">
                <div id="outer_result_btr">
                    <div class="result_div" id="result_btr">
                        <p class="lead text-center visible-print-inline">KETQUA.NET - Trang kết quả xổ số lớn nhất
                            ViệtNam</p>
                        @if($resultLottery)
                            @include('frontend.partials.template_result_north',['resultLottery'=>$resultLottery])
                            @include('frontend.block.bingo',['resultLottery'=>$resultLottery])
                            @include('frontend.block.bingoHeadEnd',['resultLottery'=>$resultLottery])
                        @endif
                    </div>
                </div>
            </div>
            <hr style="margin: 1px;">
            @include('frontend.partials.statistical',['resultLottery'=>$resultLottery,'name'=>'Truyền Thống'])
        </div>
    @else
        <div class="col-sm-5">
            @include('frontend.adv.top_home')
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
