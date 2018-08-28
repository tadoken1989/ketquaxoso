@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    <div class="col-sm-5">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Cùng quay xổ số</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="chuky_form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="speed" class="col-sm-1 control-label daudong">Quay</label>
                        <div class="col-sm-2">
                            <select name="speed" id="speed" class="form-control">
                                <option value="200">Nhanh</option>
                                <option value="500">Trung bình</option>
                                <option value="1200">Chậm</option>
                            </select>
                        </div>
                        <label for="code" class="col-sm-1 control-label daudong">Tỉnh</label>
                        <div class="col-sm-3">
                            <select name="code" id="code" class="form-control">
                                @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                                    <option value="mien-bac" selected>Truyền thống</option>
                                @else
                                    <option value="mien-bac">Truyền thống</option>
                                    <option value="dien-toan-123">Điện Toán 123</option>
                                    <option value="dien-toan-6-36">Điện Toán 6x36</option>
                                    <option value="than-tai">Thần Tài</option>
                                @endif
                                @foreach(load_province() as $pro)
                                    @if($pro->region_id != 2)
                                        @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                            <option value="{{$pro->slug}}" selected>{{$pro->name}}</option>
                                        @else
                                            <option value="{{$pro->slug}}">{{$pro->name}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning col-sm-2">
                            <span aria-hidden="true"></span>Chọn
                        </button>
                    </div>
                    <button id="start" class="btn btn-primary col-sm-2 col-sm-offset-4">
                        <span id="starticon" class="glyphicon glyphicon-play" aria-hidden="true"></span> Bắt đầu
                    </button>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <link href="/frontend/css/bootstrap-toggle.min.css" rel="stylesheet">
            <script src="/frontend/js/cungquay.js" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Cùng quay xổ số
                        @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                            Truyền Thống
                        @else
                            Truyền Thống
                        @endif
                        @foreach(load_province() as $pro)
                            @if($pro->region_id != 2)
                                @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                    {{$pro->name}}
                                @endif
                            @endif
                        @endforeach
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="kqbackground vien tb-phoi">
                        <div id="outer_result_mb">
                            <div class="result_div " id="result_mb">
                                <p class="lead text-center visible-print-inline">{{ env('APP_URL') }} - Trang kết quả xổ
                                    số lớnnhất Việt Nam</p>
                                <div class="color333">
                                    @if($province->id >45 && $province->id <52)
                                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border tb-phoi-border watermark"
                                               id="result_tab_mb">
                                            <thead>
                                            <tr class="title_row">
                                                <td class="color333" colspan="13">
                                                    <div class="col-sm-10">
                                                        <a href="/in-truyen-thong.php?ngay=07-06-2018" target="_blank">
                                                            <button class="btn btn-lg button-noborder col-sm-1 pull-left hidden-print">
                                                                <span class="lyphicon glyphicon glyphicon-print"></span>
                                                            </button>
                                                        </a>
                                                        <h2 class="martop10 col-sm-8 chu22 kqcenter viethoa dosam vietdam">
                                                            Xổ số Truyền Thống</h2>
                                                        <button class="btn btn-lg button-noborder col-sm-1 pull-right hidden-print "
                                                                onclick="return notification_switch();">
                                                            <i class="fa fa-volume-up notification_switch mauden"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <span class="pull-left col-sm-5 chu15"
                                                              id="result_date">{{date('d-m-Y')}}</span>
                                                        <span class="pull-right col-sm-5  chu15">Ký tự trúng giải:
                                                            <span id="rs_8_0" rs_len="4" class="need_blank">*Sk</span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;color:red;">
                                                    Đặc biệt
                                                </td>
                                                <td id="rs_0_0" colspan="12" style="width:84%;"
                                                    class="phoi-size chu22 gray need_blank vietdam phoi-size chu30 maudo stop-reload"
                                                    rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải nhất
                                                </td>
                                                <td id="rs_1_0" colspan="12" style="width:84%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải nhì
                                                </td>
                                                <td id="rs_2_0" colspan="6" style="width:42%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                                <td id="rs_2_1" colspan="6" style="width:42%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2" style="width:16%;vertical-align:middle;font-size:16px;">
                                                    Giải ba
                                                </td>
                                                <td id="rs_3_0" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                                <td id="rs_3_1" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                                <td id="rs_3_2" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="display:none"></td>
                                                <td id="rs_3_3" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                                <td id="rs_3_4" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                                <td id="rs_3_5" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải tư</td>
                                                <td id="rs_4_0" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_4_1" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_4_2" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_4_3" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2" style="width:16%;vertical-align:middle;font-size:16px;">
                                                    Giải năm
                                                </td>
                                                <td id="rs_5_0" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_5_1" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_5_2" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="display:none"></td>
                                                <td id="rs_5_3" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_5_4" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                                <td id="rs_5_5" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="4">****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải sáu
                                                </td>
                                                <td id="rs_6_0" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="3">***
                                                </td>
                                                <td id="rs_6_1" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="3">***
                                                </td>
                                                <td id="rs_6_2" colspan="4" style="width:28%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="3">***
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải bảy
                                                </td>
                                                <td id="rs_7_0" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td id="rs_7_1" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td id="rs_7_2" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td id="rs_7_3" colspan="3" style="width:21%;"
                                                    class="phoi-size chu22 gray need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @elseif($province->id == 60)
                                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border"
                                               id="result_tab_123" style="text-align:center;">
                                            <thead>
                                            <tr class="title_row">
                                                <td colspan="3" class="dosam chu18">
                                                    <p class="kqcenter viethoa dosam vietdam">
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print "
                                                                onclick="return $('#result_123').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Điện Toán 123'});">
                                                            <span class="lyphicon glyphicon glyphicon-print"></span>
                                                        </button>
                                                        Xổ số Điện Toán 123
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print "
                                                                onclick="return notification_switch();">
                                                            <i class="fa fa-volume-up notification_switch rolling-finished mauden"></i>
                                                        </button>
                                                    </p>
                                                    <span id="result_date">{{date('m-d-Y')}}</span>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width:33.33%;" id="rs_0_0" class="chu19 need_blank vietdam"
                                                    rs_len="1">*
                                                </td>
                                                <td style="width:33.33%;" id="rs_0_1" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:33.33%;" id="rs_0_2"
                                                    class="chu19 need_blank vietdam stop-reload" rs_len="3">***
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @elseif($province->id == 61)
                                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-bordered kqbackground table-kq-bold-border"
                                               id="result_tab_636" style="text-align:center;">
                                            <thead>
                                            <tr class="title_row">
                                                <td colspan="6" class="dosam chu18">
                                                    <p class="kqcenter viethoa dosam vietdam">
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print "
                                                                onclick="return $('#result_636').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Điện Toán 6x36'});">
                                                            <span class="lyphicon glyphicon glyphicon-print"></span>
                                                        </button>
                                                        Xổ số Điện Toán 6x36
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print "
                                                                onclick="return notification_switch();">
                                                            <i class="fa fa-volume-up notification_switch rolling-finished mauden"></i>
                                                        </button>
                                                    </p>
                                                    <span id="result_date">{{date('d-m-Y')}}</span>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width:16.67%;" id="rs_0_0" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:16.67%;" id="rs_0_1" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:16.67%;" id="rs_0_2" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:16.67%;" id="rs_0_3" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:16.67%;" id="rs_0_4" class="chu19 need_blank vietdam"
                                                    rs_len="2">**
                                                </td>
                                                <td style="width:16.67%;" id="rs_0_5"
                                                    class="chu19 need_blank vietdam stop-reload" rs_len="2">**
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @elseif($province->id == 62)
                                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
                                               id="result_tab_tt4" style="text-align:center;">
                                            <thead>
                                            <tr class="title_row">
                                                <td>
                                                    <p class="kqcenter viethoa dosam vietdam">
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print "
                                                                onclick="return $('#result_tt4').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số Thần Tài'});">
                                                            <span class="lyphicon glyphicon glyphicon-print"></span>
                                                        </button>
                                                        Xổ số Thần Tài
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print "
                                                                onclick="return notification_switch();">
                                                            <i class="fa fa-volume-up notification_switch rolling-finished mauden"></i>
                                                        </button>
                                                    </p>
                                                    <span id="result_date">{{date('d-m-Y')}}</span>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td id="rs_0_0" class="chu19 vietdam need_blank stop-reload"
                                                    style="font-size:19px;" rs_len="4">****
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
                                               id="result_tab_cm" style="text-align:center;">
                                            <thead>
                                            <tr class="title_row">
                                                <td colspan="13" class="dosam chu18">
                                                    <h2 class="martop10 chu22 kqcenter viethoa dosam vietdam">
                                                        <a href="/in-ca-mau.php?ngay=07-06-2018" target="_blank">
                                                            <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print">
                                                                <span class="lyphicon glyphicon glyphicon-print"></span>
                                                            </button>
                                                        </a>Xổ số
                                                        @foreach(load_province() as $pro)
                                                            @if($pro->region_id != 2)
                                                                @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                                                    {{$pro->name}}
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print "
                                                                onclick="return notification_switch();">
                                                            <i class="fa fa-volume-up notification_switch rolling-finished"></i>
                                                        </button>
                                                    </h2>
                                                    <span id="result_date">{{date('d-m-Y')}}</span>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;color:red;">
                                                    Đặc biệt
                                                </td>
                                                <td id="rs_0_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam maudo stop-reload chu30"
                                                    rs_len="6">******
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải nhất
                                                </td>
                                                <td id="rs_1_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải nhì
                                                </td>
                                                <td id="rs_2_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải ba</td>
                                                <td id="rs_3_0" colspan="6" style="width:42%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_3_1" colspan="6" style="width:42%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td rowspan="2" style="width:16%;vertical-align:middle;font-size:16px;">
                                                    Giải tư
                                                </td>
                                                <td id="rs_4_0" colspan="3" style="width:21%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_4_1" colspan="3" style="width:21%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_4_2" colspan="3" style="width:21%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_4_3" colspan="3" style="width:21%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="display:none"></td>
                                                <td id="rs_4_4" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_4_5" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                                <td id="rs_4_6" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="5">*****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải năm
                                                </td>
                                                <td id="rs_5_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="4">****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải sáu
                                                </td>
                                                <td id="rs_6_0" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="4">****
                                                </td>
                                                <td id="rs_6_1" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="4">****
                                                </td>
                                                <td id="rs_6_2" colspan="4" style="width:28%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="4">****
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải bảy
                                                </td>
                                                <td id="rs_7_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="3">***
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:16%;vertical-align:middle;font-size:16px;">Giải tám
                                                </td>
                                                <td id="rs_8_0" colspan="12" style="width:84%;"
                                                    class="chu22 gray need_blank vietdam" rs_len="2">**
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection
