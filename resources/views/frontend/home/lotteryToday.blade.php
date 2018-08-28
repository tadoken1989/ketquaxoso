@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    @if($listResultLottery && count($listResultLottery) > 0)
        <div class="col-sm-5">
            @foreach($listResultLottery as $key => $resultLottery)
                {{--mien bac--}}
                @if($resultLottery->province->region_id == 2 && $resultLottery->type == 'normal')
                    <div class="kqbackground vien tb-phoi">
                        <div id="outer_result_mb">
                            <div class="result_div " id="result_mb">
                                <div class="color333">
                                    @include('frontend.partials.template_result_north',['resultLottery'=>$resultLottery])
                                </div>
                                @include('frontend.block.bingo')
                                @include('frontend.block.bingoHeadEnd')
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if(isset($resultLotteriesOthers))
                        @include('frontend.block.dientoan',['resultLotteriesOthers'=>$resultLotteriesOthers])
                    @endif
                @elseif($resultLottery->province->region_id != 2  && $resultLottery->type == 'normal')
                    @if($resultLottery->province->region_id == 3)
                        <hr>
                        <p class="lead text-center"><span class="maudo vietdam">Kết quả Xổ số miền Trung</span></p>
                    @endif
                    @if($resultLottery->province->region_id == 1)
                        <hr>
                        <p class="lead text-center"><span class="maudo vietdam">Kết quả Xổ số miền Nam</span></p>
                    @endif
                    {{--mien trung - mien nam--}}
                    <div class="kqbackground vien">
                        <div id="outer_result_dni">
                            <div class="result_div" id="result_dni">
                                @include('frontend.partials.template_result_south',['resultLottery'=>$resultLottery,'province'=>$resultLottery->province->name])
                                {{--Bingo--}}
                                @include('frontend.block.bingo')
                                {{--End Bingo--}}
                                {{--Bingo HeadEnd--}}
                                @include('frontend.block.bingoHeadEnd')
                                {{--End Bing HeadEnd--}}
                                <span id="date_dni" hidden="">{{ parseStringToDate($resultLottery->result_day) }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
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