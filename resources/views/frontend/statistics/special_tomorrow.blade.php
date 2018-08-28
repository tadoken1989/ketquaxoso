@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table-centered.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cầu loto</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Dựa vào kết quả giải ĐB ngày gần nhất (ngày A) để đưa ra dự đoán loto
                            ĐB cho ngày bạn chọn (ngày B).</p>
                        <p class="“text-justify”">Liệt kê lịch sử các ngày có loto ĐB trùng ngày A, và ngày liền kề
                            trong quá khứ.</p>
                        <p class="“text-justify”">Thống kê tuần suất loto ĐB vào ngày tiếp theo : theo bộ số, đầu, đít,
                            tổng. Và sắp xếp theo thứ tự giảm dần.</p>
                        <p class="“text-justify”">Thống kê nâng cao cụ thể theo ngày trong thứ, và hàng năm từ năm 2000
                            theo ngày bạn chọn.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê giải đặc biệt ngày mai</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="chuky_form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="code" class="col-sm-1 col-sm-offset-1 control-label">Tỉnh</label>
                        <div class="col-sm-2">
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
                        <label for="code" class="col-sm-2 control-label">Ngày thống kê</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{ parseDate($end_date,'d-m-Y') }}" id="end_date" name="end_date">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4"><i class="fa fa-eye"></i> Xem
                        kết quả
                    </button>
                </form>
            </div>
        </div>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <link href="{{asset('frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
        <script src="{{asset('frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>
        <script src="{{asset('frontend/js/qtk_support.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center"><h4 class="right-menu-title">Thống kê giải đặc biệt ngày hôm sau: {{ parseDate($end_date,'d-m-Y') }}</h4></div>
            <div class="panel-body">
                {!! $raw !!}
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
    <script type="text/javascript">
        var Core = {
            openLink: function ($this) {
                value = $($this).text();
                province = $($this).data('province');
                return window.open('{!! route('frontend.result_lottery_via_province',['slug'=> $provinceAlias]) !!}' + '?ngay=' + value);
            }
        };
        $(document).ready(function () {
            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Mysql date format
                weekStart: 1,
                endDate: '+1w',
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });
            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            $('.emphasis2').each(function() {
                $(this).html(
                    $(this).html().substr(0, $(this).html().length-2)
                    + "<span style='font-size:17px;' class='dosam'>"
                    + $(this).html().substr(-2)
                    + "</span>");
            });

        });
    </script>
@endsection