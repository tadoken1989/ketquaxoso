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
                        <h4 class="modal-title" id="myModalLabel">Thống kê loto gan</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Thống kê các bộ số loto GAN trong khoảng ngày bạn chọn, lần xuất hiện
                            cuối cùng của các bộ số đó.</p>
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
                <h4 class="right-menu-title">Thống kê loto Gan</h4>
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
                    <div class="col-sm-2 form-group daudong">
                        <label for="begin_date">Từ ngày</label>
                        <input type="text" class="form-control" id="begin_date" value="{{ $begin_date }}" name="begin_date">
                    </div>
                    <div class="col-sm-2 form-group daudong">
                        <label for="end_date">Đến ngày</label>
                        <input type="text" class="form-control" id="end_date" value="{{ $end_date }}" name="end_date">
                    </div>
                    <div class="col-sm-2 form-group daudong">
                        <label for="count">Biên độ gan</label>
                        <input type="text" class="form-control" id="day_count" name="day_count"
                               placeholder="Biên độ gan" value="{{ $day_count }}">
                    </div>
                    <div class="col-sm-2 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary col-sm-12"><i class="fa fa-eye"></i> Xem kết quả
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê loto gan Truyền Thống</h4></div>
                <div class="panel-body">
                    <div class="kqbackground"><h4>Các bộ số chưa ra theo biên độ <span class="maudo">{{ $day_count }}</span> ngày trở lên</h4>
                        <ul>
                            @if($data)
                            @foreach($data as $d)
                            <li> Bộ số <span class="maudo vietdam">{{ $d['number'] }}</span> ra ngày <a
                                        href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($d['latest_day'],'Y-m-d')]) }}" target="_blank">{{ parseDate($d['latest_day'],'d-m-Y') }}</a>,
                                đến ngày <a href="">{{ parseDate($end_date,'d-m-Y') }}</a> vẫn chưa ra <b
                                        class="maudo vietdam">{{ $d['days'] - 1 }}</b> ngày
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                   {!! $maxGan !!}
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
        $(document).ready(function () {
            $('#begin_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Mysql date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form input#begin_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#begin_date'));

            // Set the curerent begin day
            $('#begin_date').datepicker('update','{!! parseDate($begin_date,'d-m-Y') !!}');

            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Mysql date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form input#end_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#end_date'));

            // Set the curerent last day
            $('#end_date').datepicker('update','{!! parseDate($end_date,'d-m-Y') !!}');

            // Enable tooltip on our data
            $('.target_tooltip').tooltip();

        });
    </script>
@endsection