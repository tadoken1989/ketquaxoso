@extends('frontend.layouts.index')
@section('content')

<div class="col-sm-7">
    <div class="kqbackground viento">
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title"> Sổ kết quả</h4>
            </div>
            <div class="panel-body">
                <form method="GET">
                    <div class="form-group col-sm-4">
                        <label for="code">Tỉnh</label>
                        <select name="tinh" id="code" class="form-control">
                            @if(request()->query('tinh','truyen-thong') == 'truyen-thong')
                                <option value="truyen-thong" selected>Truyền thống</option>
                                <option value="than-tai">Thần tài</option>
                                <option value="dien-toan-123">Điện toán 123</option>
                                <option value="dien-toan-6-36">Điện toán 636</option>
                            @elseif(request()->query('tinh','truyen-thong') == 'than-tai')
                                <option value="truyen-thong">Truyền thống</option>
                                <option value="than-tai" selected>Thần tài</option>
                                <option value="dien-toan-123">Điện toán 123</option>
                                <option value="dien-toan-6-36">Điện toán 636</option>
                            @elseif(request()->query('tinh','truyen-thong') == 'dien-toan-123')
                                <option value="truyen-thong">Truyền thống</option>
                                <option value="than-tai">Thần tài</option>
                                <option value="dien-toan-123" selected>Điện toán 123</option>
                                <option value="dien-toan-6-36">Điện toán 636</option>
                            @elseif(request()->query('tinh','truyen-thong') == 'dien-toan-6-36')
                                <option value="truyen-thong">Truyền thống</option>
                                <option value="than-tai">Thần tài</option>
                                <option value="dien-toan-123">Điện toán 123</option>
                                <option value="dien-toan-6-36" selected>Điện toán 636</option>
                            @else
                                <option value="truyen-thong">Truyền thống</option>
                                <option value="than-tai">Thần tài</option>
                                <option value="dien-toan-123">Điện toán 123</option>
                                <option value="dien-toan-6-36">Điện toán 636</option>
                            @endif
                            @foreach(load_province() as $pro)
                                @if($pro->region_id != 2)
                                    @if(request()->query('tinh','truyen-thong') == $pro->slug)
                                        <option value="{{$pro->slug}}" selected>{{$pro->name}}</option>
                                    @else
                                        <option value="{{$pro->slug}}">{{$pro->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="date">Biên độ ngày</label>
                        <input type="text" class="form-control" id="date" name="bien-do-ngay" value="{{request()->query('bien-do-ngay',date('Y-m-d'))}}">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="so-ngay">Số ngày <span class="vietthuong">(max= 300)</span></label>
                        <div class="input-group bootstrap-touchspin">
                                <span class="input-group-addon bootstrap-touchspin-prefix">
                                </span>
                            <input type="text" id="so-ngay" class="form-control" name="so-ngay" value="{{ $limit }}">
                        </div>
                    </div>
                    <div class="form-group col-sm-3 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary">Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('#date').datepicker({
                    autoclose: true,
                    language: 'vi',
                    format: 'yyyy-mm-dd', // Mysql date format
                    endDate: new Date(),
                    todayBtn: 'linked',
                    todayHighLight: true,
                    startDate: '-4y'
                });

                $('#date').datepicker('update', '{!! request()->query('bien-do-ngay',date('Y-m-d')) !!}');

                $('#so-ngay').TouchSpin({
                    min: 1,
                    max: 300,
                    step: 1,
                    postfix: ' ngày'
                });
            });
        </script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Sổ kết quả - Tổng hợp kết quả xổ số, tra cứu kqxs</h4>
            </div>
            <div class="panel-body">
                <div class="row kqborder kqvertimarginw" style="padding-left: 10px;">
                    <script data-rocketsrc="https://apis.google.com/js/platform.js" async="" defer=""
                            type="text/rocketscript" data-rocketoptimized="true">
                    {lang: 'vi'}
                    </script>
                </div>
                @if($listResultLottery && count($listResultLottery) > 0)
                    @foreach($listResultLottery as $resultLottery)
                        <div class="kqbackground vien tb-phoi">
                            <div id="outer_result_mb">
                                <div class="result_div " id="result_mb">
                                    @if($resultLottery->province->region_id == 2 && $resultLottery->type == 'normal')
                                        <div class="row">
                                            <div class="col-sm-6 tb-phoi-6">
                                                <div class="color333">
                                                    @include('frontend.partials.template_result_north',['resultLottery'=>$resultLottery])
                                                </div>
                                            </div>
                                            <div class="col-sm-4 tb-phoi-4">
                                                <table class="table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground table-kq-hover"
                                                       style="margin-left: 3px;" id="dau_mb">
                                                    <thead>
                                                    <tr>
                                                        <td style="width:16%;">Đầu</td>
                                                        <td class="bang_kqnhanh_bold_bottomw">Lô tô</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="font-weight:bold;">
                                                    @foreach($resultLottery->bingo_head() as $key => $rds)
                                                        <tr>
                                                            <td class="dosam chu15 kqcenter">
                                                                {{$key}}
                                                            </td>
                                                            <td id="begin_with_0" class="chu15 need_blank">
                                                                {!!
                                                                $rds->map(function($item) {
                                                                $b = $item->getTwoNumberFromPrizeNumber();
                                                                if ($item->prize == 0) return "<span class='maudo'>$b</span>";
                                                                return $b;
                                                                })->implode('; ')
                                                                !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @elseif($resultLottery->province->region_id != 2)
                                        <div class="row">
                                            <div class="col-sm-6 tb-phoi-6">
                                                <div class="color333">
                                                    @include('frontend.partials.template_result_south',['resultLottery'=>$resultLottery])
                                                </div>
                                            </div>
                                            <div class="col-sm-4 tb-phoi-4">
                                                <table class="table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground table-kq-hover"
                                                       style="margin-left: 3px;" id="dau_mb">
                                                    <thead>
                                                    <tr>
                                                        <td style="width:16%;">Đầu</td>
                                                        <td class="bang_kqnhanh_bold_bottomw">Lô tô</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="font-weight:bold;">
                                                    @foreach($resultLottery->bingo_head() as $key => $rds)
                                                        <tr>
                                                            <td class="dosam chu15 kqcenter">
                                                                {{$key}}
                                                            </td>
                                                            <td id="begin_with_0" class="chu15 need_blank">
                                                                {!!
                                                                $rds->map(function($item) {
                                                                $b = $item->getTwoNumberFromPrizeNumber();
                                                                if ($item->prize == 0) return "<span class='maudo'>$b</span>";
                                                                return $b;
                                                                })->implode('; ')
                                                                !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    @elseif($resultLottery->province->region_id == 2 && $resultLottery->type == '123')
                                        <div id="outer_result_123">
                                            <div class="result_div" id="result_123">
                                                <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
                                                <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border" id="result_tab_123" style="text-align:center;">
                                                    <thead>
                                                    <tr class="title_row">
                                                        <td colspan="3" class="dosam chu18">
                                                            <span id="result_date">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($resultLottery->resultsDetail as $prize)
                                                            <td style="width:33.33%;" id="rs_0_2" class="chu19 need_blank vietdam @if($prize['order'] == 2){{  ('stop-reload') }} @endif" rs_len="3">{{$prize['prize_number']}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <span id="all_res_123" class="hidden-print" hidden="">354104</span>
                                                <span id="reload_link_123" class="hidden-print" hidden="">/pre_loads/kq-123.raw</span>
                                                <span id="date_123" class="hidden-print" hidden="">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                            </div>
                                        </div>
                                    @elseif($resultLottery->province->region_id == 2 && $resultLottery->type == '6-36')
                                        <div id="outer_result_636">
                                            <div class="result_div" id="result_636">
                                                <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
                                                <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border" id="result_tab_636" style="text-align:center;">
                                                    <thead>
                                                    <tr class="title_row">
                                                        <td colspan="6" class="dosam chu18">
                                                            <span id="result_date">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($resultLottery->resultsDetail as $prize)
                                                            <td style="width:16.67%;" id="rs_0_5" class="chu19 need_blank vietdam @if($prize['order'] == 5){{  ('stop-reload') }} @endif" rs_len="2">{{$prize['prize_number']}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <span id="all_res_636" hidden="">050614203132</span>
                                                <span id="reload_link_636" hidden="">/pre_loads/kq-636.raw</span>
                                                <span id="date_636" hidden="">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                            </div>
                                        </div>
                                    @elseif($resultLottery->province->region_id == 2 && $resultLottery->type == 'than-tai')
                                        <div id="outer_result_tt4">
                                            <div class="result_div" id="result_tt4">
                                                <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
                                                <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border" id="result_tab_tt4" style="text-align:center;">
                                                    <thead>
                                                    <tr class="title_row">
                                                        <td>
                                                            <span id="result_date">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                                        </td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        @foreach($resultLottery->resultsDetail as $prize)
                                                            <td id="rs_0_0" class="chu19 vietdam need_blank stop-reload" style="font-size:19px;" rs_len="4">{{$prize['prize_number']}}</td>
                                                        @endforeach
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <span id="all_res_tt4" hidden="">1084</span>
                                                <span id="reload_link_tt4" hidden="">/pre_loads/kq-tt4.raw</span>
                                                <span id="date_tt4" hidden="">{{ parseStringToDate($resultLottery->result_day) }}</span>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection
