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
                        <h3 class="right-menu-title"><i class="fa fa-bar-chart"></i>Vietlott Mega 6/45</h3>
                    </div>
                    <div class="result_div" id="result_hcm">
                        <p class="lead text-center visible-print-inline">KETQUA.NET - Trang kết quả xổ số lớn nhấtViệtNam</p>

                        <h2 class="red text-center">Kết quả xổ số Vietlott Mega 6/45</h2>
                        <p class="time-result title-mega645" style="text-align:center;">
                            {{ parseStringToDate($resultLottery['result_day']) }}- Kỳ quay thưởng {{$resultLottery['lotteries_db_content']->patch}}                </p>
                        <ul class="result-number">
                            @foreach($resultLottery['results'] as $result)
                            <li>{{$result}}</li>
                            @endforeach
                        </ul>
                        <p style="margin-top: 10px; text-align:center">(Các con số dự thưởng không cần theo đúng thứ tự)</p>
                        <p class="red ali-center" style="font-weight: bold;font-size: 22px;text-align:center;">{{format_prize($resultLottery['lotteries_db_content']->prizes[0]->prize)}} đồng</p>
                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
                               id="result_tab_hcm" style="text-align:center;">
                            <thead>
                            <tr>
                                <th class="ali-center" width="25%" style="text-align:center">Giải thưởng</th>
                                <th class="ali-center" width="20%" style="text-align:center">Trùng khớp</th>
                                <th class="ali-center" style="text-align:center">Số giải</th>
                                <th class="ali-center" style="text-align:center">Giá trị (đồng)</th>
                            </tr>
                            </thead>
                            <tbody class="ali-center">
                            @php($prizeNames = ['Jackpot','Giải nhất','Giải nhì','Giải ba'])
                            @foreach($resultLottery['lotteries_db_content']->prizes as $prize)
                                <tr>
                                    <td>{{$prizeNames[$loop->iteration-1]}}</td>
                                    <td>{{7 - $loop->iteration}} số</td>
                                    <td>{{$prize->win_count}}</td>
                                    <td><b>{{format_prize($prize->prize)}}</b></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <span id="all_res_bdu" hidden></span>
                            <span id="reload_link_bdu" hidden>http://ketqua.net/pre_loads/kq-bdu.raw</span>
                            <span id="date_bdu" hidden>{{$resultLottery['result_day']}}</span>
                        </table>

                        <span id="date_hcm" hidden="">{{ parseStringToDate($resultLottery['result_day']) }}</span>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="right-menu-title"><i class="fa fa-bar-chart"></i> Thống kê nhanh Vietlott Mega 6/45</h3>
                </div>
                <div class="panel-body">
                    <div class="tk">
                        <h4 class="tk-item"><i class="fa fa-line-chart" aria-hidden="true"></i> 5 kỳ quay gần đây</h4>
                        <div class="main-tk">
                            @foreach($resultLottery['recents'] as $recent)
                            <ul class="list-record">
                                <li>{{date('d/m/Y', strtotime($recent['result_day']))}}: </li>
                                @foreach($recent->toArray()['results_detail'] as $detail)
                                    <li class="red">{{$detail['prize_number']}}</li>
                                @endforeach
                            </ul>
                            @endforeach
                        </div>
                    </div>
                    <div class="tk">
                        <h4 class="tk-item"><i class="fa fa-line-chart" aria-hidden="true"></i> 12 bộ số suất hiện nhiều nhất trong 20 kỳ qua</h4>
                        <div class="main-tk">
                            <ul class="count-record">
                                @foreach($resultLottery['bestNumbers'] as $number)
                                    <li><strong>{{$number->prize_number}}</strong> <span>{{$number->count}} lần</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="tk">
                        <h4 class="tk-item"><i class="fa fa-line-chart" aria-hidden="true"></i> 12 bộ số xuất hiện ít nhất trong 20 kỳ qua</h4>
                        <div class="main-tk">
                            <ul class="count-record">
                                @foreach($resultLottery['worstNumbers'] as $number)
                                    <li><strong>{{$number->prize_number}}</strong> <span>{{$number->count}} lần</span></li>
                                @endforeach
                            </ul>
                        </div>
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