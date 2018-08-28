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
                <h4 class="right-menu-title">Thống kê chu kỳ dàn đặc biệt</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" id="main_form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="code" class="col-sm-1 control-label">Tỉnh</label>
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
                        <label for="code" class="col-sm-1 control-label">Từ</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{ $begin_date }}" id="begin_date"
                                   name="begin_date">
                        </div>
                        <label for="code" class="col-sm-1 control-label">Đến</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{ $end_date }}" id="end_date"
                                   name="end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-3 control-label">Dàn đặc biệt muốn thống kê</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="numbers" name="numbers"
                                   placeholder="Dàn (ngăn cách bằng dấu phẩy)" value="{{ $number }}">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary">Xem kết quả</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @if($raw)
            {!! $raw !!}
        @endif
    </div>

    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
    <script type="text/javascript">

        var Core = {
            openLink : function ($this) {
                value = $($this).text();
                province = $($this).data('province');
                return window.open('{!! route('frontend.result_lottery_via_province',['slug'=> $provinceAlias]) !!}'+'?ngay='+value);
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

        });
    </script>
@endsection