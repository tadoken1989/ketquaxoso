

@if(isset($resultLotteriesOthers) && $resultLotteriesOthers['dien-toan-123'])
<div id="outer_result_123">
    <div class="result_div" id="result_123">
        <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border" id="result_tab_123" style="text-align:center;">
            <thead>
            <tr class="title_row">
                <td colspan="3" class="dosam chu18">
                    <p class="kqcenter viethoa dosam vietdam"><button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print " onclick="return $('#result_123').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Điện Toán 123'});"><span class="lyphicon glyphicon glyphicon-print"></span></button>Xổ số Điện Toán 123<button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print " onclick="return notification_switch();"><i class="fa fa-volume-up notification_switch rolling-finished mauden"></i></button></p>
                    <span id="result_date">{{ parseStringToDate($resultLotteriesOthers['dien-toan-123']->result_day) }}</span>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($resultLotteriesOthers['dien-toan-123']->resultsDetail as $resultDetail)
                    <td style="width:33.33%;" id="rs_0_0" class="chu19 need_blank vietdam @if($resultDetail->order == 2){{  ('stop-reload') }} @endif" rs_len="1" >{{$resultDetail->prize_number}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
        <span id="all_res_123" class="hidden-print" hidden="">786898</span>
        <span id="reload_link_123" class="hidden-print" hidden="">/pre_loads/kq-123.raw</span>
        <span id="date_123" class="hidden-print" hidden="">{{ parseStringToDate($resultLotteriesOthers['dien-toan-123']->result_day) }}</span>
    </div>
</div>
<hr>
@endif


@if(isset($resultLotteriesOthers) && $resultLotteriesOthers['636'])
<div id="outer_result_636">
    <div class="result_div" id="result_636">
        <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border" id="result_tab_636" style="text-align:center;">
            <thead>
            <tr class="title_row">
                <td colspan="6" class="dosam chu18">
                    <p class="kqcenter viethoa dosam vietdam"><button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print " onclick="return $('#result_636').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Điện Toán 6x36'});"><span class="lyphicon glyphicon glyphicon-print"></span></button>Xổ số Điện Toán 6x36<button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print " onclick="return notification_switch();"><i class="fa fa-volume-up notification_switch rolling-finished mauden"></i></button></p>
                    <span id="result_date">{{ parseStringToDate($resultLotteriesOthers['636']->result_day) }}</span>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($resultLotteriesOthers['636']->resultsDetail as $resultDetail)
                    <td style="width:16.67%;" id="rs_0_5" class="chu19 need_blank vietdam @if($resultDetail->order == 5){{  ('stop-reload') }} @endif " rs_len="2">{{$resultDetail->prize_number}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
        <span id="all_res_636" hidden="">030509133234</span>
        <span id="reload_link_636" hidden="">/pre_loads/kq-636.raw</span>
        <span id="date_636" hidden="">{{ parseStringToDate($resultLotteriesOthers['636']->result_day) }}</span>
    </div>
</div>
<hr>
@endif

@if(isset($resultLotteriesOthers) && $resultLotteriesOthers['than-tai'])
<div id="outer_result_tt4">
    <div class="result_div" id="result_tt4">
        <p class="lead text-center visible-print-inline">KETQUA.NET - TRANG KẾT QUẢ XỔ SỐ LỚN NHẤT VIỆT NAM</p>
        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border" id="result_tab_tt4" style="text-align:center;">
            <thead>
            <tr class="title_row">
                <td>
                    <p class="kqcenter viethoa dosam vietdam"><button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print " onclick="return $('#result_tt4').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Thần Tài'});"><span class="lyphicon glyphicon glyphicon-print"></span></button>Xổ số Thần Tài<button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print " onclick="return notification_switch();"><i class="fa fa-volume-up notification_switch rolling-finished mauden"></i></button></p>
                    <span id="result_date">{{ parseStringToDate($resultLotteriesOthers['than-tai']->result_day) }}</span>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($resultLotteriesOthers['than-tai']->resultsDetail as $resultDetail)
                    <td id="rs_0_0" class="chu19 vietdam need_blank stop-reload" style="font-size:19px;" rs_len="4">{{$resultDetail->prize_number}}</td>
                @endforeach
            </tr>
            </tbody>
        </table>
        <span id="all_res_tt4" hidden="">2177</span>
        <span id="reload_link_tt4" hidden="">/pre_loads/kq-tt4.raw</span>
        <span id="date_tt4" hidden="">{{ parseStringToDate($resultLotteriesOthers['than-tai']->result_day) }}</span>
    </div>
</div>
<hr>

@endif