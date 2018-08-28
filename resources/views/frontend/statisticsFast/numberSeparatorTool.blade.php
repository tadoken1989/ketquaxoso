@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Công cụ xổ số - Tách dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    Công cụ này sẽ tách những cặp số có dạng thu gọn ABA thành dạng AB và BA<br>
                    Những cặp số rời (độc lập), chẳng hạn CD, EF sẽ được giữ nguyên <br>
                    Ví dụ: <br>
                    Dàn số nhập vào là: 121,343,898 sau khi tách thành dàn 12, 21, 34, 43, 89, 98<br>
                    Dàn số nhập vào là: 12,343,56,898 sau khi tách thành dàn 12, 34, 43, 56,89, 98
                </div>
                <div>
                    <div class="form-group col-sm-7 kqcenter">
                        <label>Nhập dàn số</label>
                        <textarea class="form-control" id="numbers" name="numbers" placeholder="Nhập dàn số cách nhau bằng dấu phẩy." rows="3"></textarea>
                    </div>
                    <div class="form-group col-sm-3 big-button">
                        <button type="submit" class="btn btn-primary" onclick="return tach_so();">Xem kết quả</button>
                    </div>
                    <script src="frontend/js/tach_so.js" type=""></script>
                </div>
                <legend class="kqvertimarginw dosam">
                    <p class="text-center">Kết quả tách dàn số</p>
                </legend>
                <div class="tool-div pad10">
                    <div class="tool-result-box" id="tachso_div" style="width:100% !important">
                        <ul id="tachso_ul" class="tool-ul"></ul>
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