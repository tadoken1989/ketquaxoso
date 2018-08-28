@extends('frontend.layouts.index')
@section('content')

    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Lô xiên tự động</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Hệ thống tự động giúp bạn ghép các cặp lô theo bộ số bạn muốn.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Ghép lô xiên tự động</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="chuky_form" method="POST">
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Cách ghép</label>
                        <div class="col-sm-1">
                            <select name="count" id="count" class="form-control">
                                <option value="2">2 số</option>
                                <option value="3">3 số</option>
                                <option value="4">4 số</option>
                            </select>
                        </div>
                        <label for="numbers" class="col-sm-1 control-label">Bộ số</label>
                        <div class="col-sm-5">
                            <input class="form-control" id="numbers" name="numbers" placeholder="Điền các bộ số để tạo lô xiên (ngăn bằng dấu phẩy)">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-5">
                            <button type="submit" class="btn btn-primary" onclick="return make_lo_xien();"><i class="fa fa-eye"></i> Xem kết quả</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <script src="frontend/js/loxien_v2.2.js" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Ghép lô xiên tự động</h4>
                </div>
                <div class="panel-body">
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover" id="loxien_table" style="display:none;">
                        <thead>
                        <tr class="info dosam">
                            <th class="center" colspan="4">Lô xiên</th>
                        </tr>
                        </thead>
                        <tbody class="center"></tbody>
                    </table>
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