@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table_kq.css')}}" rel="stylesheet">
    <style>
        table#dacbiettuan a {
            color: black;
        }
    </style>
    <style>
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
                        <h4 class="modal-title" id="myModalLabel">Thống kê chu kì dàn đặc biệt</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Thống kê chu kì của dàn số đặc biệt các tỉnh. Cho biết ngưỡng cực đại
                            không xuất hiện của các số thuộc dàn trong giải đặc biệt, lần xuất hiện gần nhất trong
                            khoảng ngày bạn chọn, hoặc lần xuất hiện gần đây nhất.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê bảng đặc biệt tuần</h4>
            </div>
            <div class="panel-body">
                <form method="POST" id="main_form">
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
                        <label for="begin_date">Từ ngày</label>
                        <input type="text" class="form-control" value="{{ $begin_date }}" id="begin_date"
                               name="begin_date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="end_date">Đến ngày</label>
                        <input type="text" class="form-control" value="{{ $end_date }}" id="end_date"
                               name="end_date">
                    </div>
                    <div class="form-group col-sm-2 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary">Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Bảng đặc biệt tuần Xổ Số từ
                        {{ $begin_date }} đến {{ $end_date }}</h4></div>
                <div class="panel-body">
                    <div>
                        <div class="kqbackground">
                            <form class="form-inline" action="eee">
                                <div class="form-group daudong">
                                    <label for="first-digit-switch">Đầu</label>
                                    <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="mauxanh"
                                           data-style="ios" id="first-digit-switch">
                                </div>
                                <div class="form-group">
                                    <label for="last-digit-switch">Đuôi</label>
                                    <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="mauden"
                                           data-style="ios" id="last-digit-switch" name="last-digit-switch">
                                </div>
                                <div class="form-group">
                                    <label for="last-2-switch">Loto</label>
                                    <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="dosam"
                                           data-style="ios" id="last-2-switch" name="last-2-switch">
                                </div>
                                <div class="form-group">
                                    <label for="sum-switch">Tổng</label>
                                    <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="maudo"
                                           data-style="ios" id="sum-switch" name="sum-switch">
                                </div>
                            </form>
                        </div>
                        <br>
                        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
                        <link href="{{asset('frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
                        <script src="{{asset('frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>
                        <link href="{{asset('frontend/css/bangdb.css')}}" rel="stylesheet">
                        <script src="{{asset('frontend/js/bangdbtuan.js')}}" type="text/javascript"></script>
                        {{--content table--}}

                        @if($raw)
                            {!! $raw !!}
                        @endif

                    </div>
                </div>
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
            $('#begin_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-20y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form input#begin_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#begin_date'));

            // Set the curerent begin day
            $('#begin_date').datepicker('update', '{!! parseDate($begin_date,'d-m-Y') !!}');

            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-20y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form input#end_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#end_date'));

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            // Make the last 2 character bold for all giaidb
            $('.emphasis2').each(function() {
                $(this).html(
                    $(this).html().substr(0, $(this).html().length-2)
                    + "<span style='font-size:17px;' class='dosam'>"
                    + $(this).html().substr(-2)
                    + "</span>");
            });

            $('table#dacbiettuan td').click(function(){
                $(this).toggleClass('act');
            });

        });
    </script>
@endsection