@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    @if($resultLottery)
        <div class="col-sm-5">
            <div class="kqbackground vien">
                @include('frontend.partials.table.list_result',compact('region', 'province', 'resultLottery','date'))
                <p class="chu15 daudong huongdan vietnghieng"><span class="maudo">Hướng dẫn</span>: Chọn tỉnh tương ứng
                    để
                    xem kết quả loto trực tiếp, đầu, đuôi. Chọn tỉnh trên menu trái HÔM NAY để xem từng tỉnh.</p>
                <div>
                    <ul class="nav nav-tabs chu17" role="tablist">
                        @foreach($resultLottery as $key => $value)
                            <li role="presentation" class="@if ($key == 0) {{ ('active') }} @endif">
                                <a href="#tab_{{ $value->province->alias }}" aria-controls="home" role="tab"
                                   data-toggle="tab">{{ $value->province->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($resultLottery as $key => $value)
                            <div role="tab-panel" class="tab-pane @if ($key == 0) {{ ('active') }} @endif"
                                 id="tab_{{ $value->province->alias }}">
                                <div>
                                    <lengend class="kqcenter dosam vietdam chu19">
                                        <p style="margin-top:10px;">Bảng loto tỉnh {{ $value->province->name }}</p>
                                    </lengend>
                                </div>
                                @include('frontend.block.bingo',['resultLottery'=>$value])
                                @include('frontend.block.bingoHeadEnd',['resultLottery'=>$value])
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
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
