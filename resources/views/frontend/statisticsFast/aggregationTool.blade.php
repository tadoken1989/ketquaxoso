@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Công cụ xổ số - Gộp dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    Công cụ này sẽ gộp những cặp số có dạng AB và BA thành dạng thu gọn ABA.<br>
                    Những cặp số rời (độc lập), chẳng hạn CD mà không có DC sẽ được giữ nguyên<br>
                    p/s: Nhập các số có 2 chữ số, ví dụ: 00,09,99<br>
                    Ví dụ:<br>
                    Dàn số nhập vào là: 12,21,34,43,89,98 sau khi gộp thành dàn 121, 343, 898<br>
                    Dàn số nhập vào là: 12,34,43,56,89,98 sau khi gộp thành dàn 12, 343, 56, 898
                </div>
                <div>
                    <div class="form-group col-sm-7 kqcenter">
                        <label>Nhập dàn số</label>
                        <textarea class="form-control" name="numbers" id="numbers" placeholder="Nhập dàn số (cách nhau bằng dấu phẩy). Các số có 2 chữ số." rows="3"></textarea>
                    </div>
                    <div class="form-group col-sm-3 big-button">
                        <button type="submit" class="btn btn-primary" onclick="return gop_so();">Xem kết quả</button>
                    </div>
                    <script src="frontend/js/gop_so.js" type=""></script>
                </div>
                <legend class="kqvertimarginw dosam">
                    <p class="text-center">Kết quả gộp dàn số</p>
                </legend>
                <div class="tool-div pad10">
                    <div class="tool-result-box" id="gopso_div" style="width:100% !important">
                        <ul id="gopso_ul" class="tool-ul"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection
@endsection
