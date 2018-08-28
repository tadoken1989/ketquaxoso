@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    @if($resultLottery)

        <div class="col-sm-5">
            <div class="kqbackground vien">
                <div id="outer_result_hcm">
                    <div class="panel-heading">
                        <h3 class="right-menu-title"><i class="fa fa-bar-chart"></i>Vietlott Max 4D</h3>
                    </div>
                    <div class="result_div" id="result_hcm">
                        <p class="lead text-center visible-print-inline">KETQUA.NET - Trang kết quả xổ số lớn
                            nhấtViệtNam</p>

                        <h2 class="red text-center">Kết quả xổ số Vietlott Max 4D</h2>
                        <p class="time-result title-mega645" style="text-align:center;">
                            {{ parseStringToDate($resultLottery['result_day']) }}- Kỳ quay thưởng {{$resultLottery['lotteries_db_content']->patch}}  </p>


                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
                               id="result_tab_hcm" style="text-align:center;">
                            <thead>
                            <tr>
                                <th style="text-align:center" width="25%">Giải thưởng</th>
                                <th class="ali-center">Kết quả</th>
                                <th class="ali-right">Giá trị giải (đồng)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($prizeNames = ['Giải nhất','Giải nhì','Giải ba', 'Giải KK 1', 'Giải KK 2'])
                            @foreach($resultLottery['lotteries_db_content']->prizes as $prize)
                                <tr>
                                    <td>{{$prizeNames[$loop->iteration-1]}}</td>
                                    <td class="result-max4d red">
                                        @foreach($prize->results as $result)
                                            <b>{{$result}}</b>
                                        @endforeach
                                    </td>
                                    <td class="red ali-right"><b>{{format_prize($prize->prize)}}</b></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <span id="all_res_bdu" hidden></span>
                            <span id="reload_link_bdu" hidden>http://ketqua.net/pre_loads/kq-bdu.raw</span>
                            <span id="date_bdu" hidden>{{$resultLottery['result_day']}}</span>
                        </table>

                        <span id="date_hcm" hidden="">{{ parseStringToDate($resultLottery['result_day']) }}</span>

                        @foreach($resultLottery['recents'] as $recent)
                            <p class="time-result title-mega645" style="text-align:center;padding-top: 10px">
                                {{ parseStringToDate($recent->result_day) }}- Kỳ quay thưởng {{$recent->lotteries_db_content->patch}}  </p>


                            <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
                                   id="result_tab_hcm" style="text-align:center;">
                                <thead>
                                <tr>
                                    <th style="text-align:center" width="25%">Giải thưởng</th>
                                    <th class="ali-center">Kết quả</th>
                                    <th class="ali-right">Giá trị giải (đồng)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($prizeNames = ['Giải nhất','Giải nhì','Giải ba', 'Giải KK 1', 'Giải KK 2'])
                                @foreach($recent->lotteries_db_content->prizes as $prize)
                                    <tr>
                                        <td>{{$prizeNames[$loop->iteration-1]}}</td>
                                        <td class="result-max4d red">
                                            @foreach($prize->results as $result)
                                                <b>{{$result}}</b>
                                            @endforeach
                                        </td>
                                        <td class="red ali-right"><b>{{format_prize($prize->prize)}}</b></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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