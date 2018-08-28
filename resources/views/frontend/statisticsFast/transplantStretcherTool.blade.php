@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Lọc - Ghép dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <div class="alert alert-info">
                    VDEV Company: Hỗ trợ lọc ghép dàn chuyên nghiệp chính xác nhất. Dàn số cách nhau bằng dấu phẩy. Mỗi số gồm có 2 chữ số.
                </div>
                <div>
                    <div class="form-group col-sm-5">
                        <label>Dàn số 1</label>
                        <textarea class="form-control" id="list1" name="list1" placeholder="Thêm dàn thứ 1 (cách nhau bởi dấu phẩy)" rows="3"></textarea>
                    </div>
                    <div class="form-group col-sm-5">
                        <label>Dàn số 2</label>
                        <textarea class="form-control" id="list2" name="list2" placeholder="Thêm dàn thứ 2 (cách nhau bởi dấu phẩy)" rows="3"></textarea>
                    </div>
                    <div class="form-group col-sm-3 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary" onclick="return do_all();">Xem kết quả</button>
                    </div>
                </div>
                <script src="frontend/js/loc_ghep_dan.js" type=""></script>
                <legend class="kqvertimarginw dosam pull-left">
                    <p class="text-center">Kết quả lọc - ghép dàn</p>
                </legend>
                <div class="tool-div">
                    <div class="tool-result-title">
                        <h5 class="dosam">Dàn trùng</h5>
                        <i>(Những số có mặt đồng thời trong cả Dàn 1 và Dàn 2)</i>
                    </div>
                    <div class="tool-result-box" id="dantrung_div">
                        <ul id="dantrung_ul" class="tool-ul"></ul>
                    </div>
                </div>
                <div class="tool-div">
                    <div class="tool-result-title">
                        <h5 class="dosam">Dàn ghép</h5>
                        <i>(Những số có mặt ít nhất 1 lần trong Dàn 1 hoặc Dàn 2, hoặc có mặt trong cả 2 dàn)</i>
                    </div>
                    <div class="tool-result-box" id="danghep_div">
                        <ul id="danghep_ul" class="tool-ul"></ul>
                    </div>
                </div>
                <div class="tool-div">
                    <div class="tool-result-title">
                        <h5 class="dosam">Dàn 1 loại Dàn 2</h5>
                        <i>(Những số có mặt trong Dàn 1 nhưng không có mặt trong Dàn 2)</i>
                    </div>
                    <div class="tool-result-box" id="locdan1_div">
                        <ul id="locdan1_ul" class="tool-ul"></ul>
                    </div>
                </div>
                <div class="tool-div">
                    <div class="tool-result-title">
                        <h5 class="dosam">Dàn 2 loại Dàn 1</h5>
                        <i>(Những số có mặt trong Dàn 2 nhưng không có mặt trong Dàn 1)</i>
                    </div>
                    <div class="tool-result-box" id="locdan2_div">
                        <ul id="locdan2_ul" class="tool-ul"></ul>
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