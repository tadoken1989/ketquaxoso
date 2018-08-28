@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Công cụ xổ số - loại dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                   {{ env('APP_URL') }} : Hỗ trợ loại dàn xổ số đặc biệt chuyên nghiệp chính xác nhất. Dàn số cách nhau bằng dấu phẩy. Mỗi số gồm có 2 chữ số.
                </div>
                <div>
                    <script src="frontend/js/loai_dan.js" type=""></script>
                    <legend class="kqvertimarginw dosam">
                        <p class="text-center">Loại dàn đặc biệt</p>
                    </legend>
                    <div>
                        <div class="alert space">
                            <textarea name="dnn$ctr460$ViewLOAIDANDB$txtNumber" rows="2" cols="20" id="dnn_ctr460_ViewLOAIDANDB_txtNumber" style="font-size: 16px;padding: 15px !important;height: 120px;width: 100%;background: #d9edf7;border: 1px solid #ddd;color: #333">00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99</textarea>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại đầu:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="iddau" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại đuôi:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idduoi" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại tổng:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idtong" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại chạm:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idcham" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại bộ:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idbo" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Loại những số:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idloaiso" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div class="alert space" style="width:100%;padding: 2px 10px;">
                            <div class="pull-left vietdam dosam" style="width: 25%">
                                Thêm những số:
                            </div>
                            <div class="pull-left" style="width: 70%">
                                <input type="text" id="idthemso" style="width: 100%;" autocomplete="off">
                            </div>
                            <div style="clear: both"></div>
                        </div>
                        <div style="width:100%;text-align: center">
                            <input type="button" id="btnloai" class="btn btn-primary" value="Xem kết quả loại dàn" onclick="return loaiso()">
                        </div>
                        <br>
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
