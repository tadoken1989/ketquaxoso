@extends('frontend.layouts.app')
@section('css')
    <style type="text/css">
        .toggle.ios, .toggle-on.ios, .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Soi cầu giải đặc biệt</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Cầu được ghép bởi một ngày là AB thì ít nhất 1 trong 2 số A hoặc B
                            sẽxuất hiện trong giải đặc biệt của ngày tiếp theo.</p>
                        <a href="http://upload.ketqua.net/upload/2016/01/30/20160130200746-34ce78b3.png"
                           target="_blank">Xem thêm cách SOI CẦU ?</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal" data-original-title="" title="">
                            Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <link href="{{asset('/frontend/css/bangcau.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/cau_support.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Soi cầu {{ $title }}</h4>
            </div>
            <div class="panel-body">
                <form method="POST">
                    {{ csrf_field() }}
                    <div class="form-group col-sm-3 daudong">
                        <label for="code">Tỉnh</label>
                        <select name="code" id="code" class="form-control">
                            @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                                <option value="mien-bac" selected>Truyền thống</option>
                            @else
                                <option value="mien-bac">Truyền thống</option>
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
                    <div class="form-group col-sm-3 daudong">
                        <label for="form-control">Biên ngày cầu chạy</label>
                        <input type="text" class="form-control" id="end_date" value="{{ parseDate($end_date,'d-m-Y') }}"
                               name="end_date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="count">Số ngày cầu chạy</label>
                        <input type="text" class="form-control" id="count" name="count" value="{{ $count }}"
                               style="display: block;">
                    </div>
                    <br><br>
                    @if(isset($both_digit))
                    <div class="form-group col-sm-5 col-sm-offset-3">
                        <label for="first-digit-switch">Gần giải đặc biệt hơn</label>
                        <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="primary" data-style="ios" id="both_digit" name="both_digit" @if(isset($both_digit) && $both_digit == 'on') checked @endif>
                    </div>
                    @endif
                    <div class="col-sm-2 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary" data-original-title="" title="">Xem kết quả
                        </button>
                    </div>
                    <p class="max-cau daudong chu15">Cầu dài nhất tìm được theo biên ngày bạn nhập là: <b
                                class="dosam"> {{ $raw['count'] }} </b>ngày
                    </p>
                </form>
            </div>
        </div>
        <div class="kqbackground">
            <legend class="kqvertimarginw kqbackground dosam"><p class="text-center">{{ $title }} {{ get_name_from_slug($provinceAlias) }}, {{ $count }}
                    ngày trước {{ parseDate($end_date,'d-m-Y') }}</p></legend>
            <p class="chu15 daudong vietnghieng"><span class="maudo">Hướng dẫn:</span> di chuột đến ô cầu để xem các vị
                trí tạo cầu. Nhấn vào một ô cầu để xem cách tính cầu đó. <span class="vietdam">Số lần</span> - số lần
                xuất hiện của cầu tương ứng. Bấm <span class="mauxanh vietdam">Xem thêm số cầu xuất hiện theo cặp</span>
                để xem thêm.</p>
        </div>
        {!! $raw['table'] !!}
        {!! $raw['popup'] !!}
        <br>
        <h3><p class="text-center kqbackground dosam" id="scroll_here">Kết quả cụ thể hàng ngày</p></h3>
        <div id="details_explain" class="kqbackground">Chi tiết {{ $title }}<b class="viethoa"> {{ get_name_from_slug($provinceAlias) }}</b>
            biên độ: <span class="maudo vietdam chu17">{{ $count }}</span> ngày tính từ ngày <a
                    href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($end_date)]) }}" target="_blank">{{ parseDate($end_date,'d-m-Y') }}</a>. Cặp số: <span
                    id="num_detail" class="vietdam maudo chu17"></span> - xuất hiện: <span id="ways_detail"
                                                                                           class="vietdam chu17 maudo"></span>
            lần<br>Vị trí số ghép lên cầu &gt;&gt; Vị trí 1: <span id="pos1_details" class="vietdam chu17"></span>, Vị
            trí 2: <span id="pos2_details" class="vietdam chu17"></span><br><br>
        </div>
        {!! $raw['row'] !!}
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
    <script type="">
        $(document).ready(function () {
            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            $('#count').TouchSpin({
                min: 1,
                max: 20,
                step: 1,
                postfix: ' ngày'
            });

            $('.btn').tooltip();
        });
    </script>
@endsection