@extends('frontend.layouts.app')
@section('css')
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Soi cầu bạch thủ</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Chỉ tính cầu thuận AB không tính cầu nghịch BA.</p>
                        <a href="http://upload.ketqua.net/upload/2016/01/30/20160130200746-34ce78b3.png"
                           target="_blank">Xem thêm cách SOI CẦU ?</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <link href="{{ asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <link href="{{ asset('/frontend/css/bangcau.css')}}" rel="stylesheet">
        <script src="{{ asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('/frontend/js/cau_support.js') }}" type="text/javascript"></script>
        <script type="">
            $(document).ready(function () {
                console.log('done');
                soicau(0);
            });
        </script>
        @if($raw)
            <div class="kqbackground vien">
                <hr>
                <legend class="kqvertimarginw dosam"><p class="text-center">Xem chi tiết cầu {{ get_name_from_slug($provinceAlias) }} {{ countBetweenDateDiff($begin_date,$end_date) }} ngày, từ
                        {{ $begin_date }} tới {{ $end_date }} với vị trí {{ $pos_1 }} và {{ $pos_2 }}</p>
                </legend>
                {!! $raw !!}
            </div>
        @endif
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
@endsection