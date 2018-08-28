@extends('frontend.layouts.index')
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
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê theo tổng</h4>
            </div>
            <div class="panel-body">
                <form id="chuky_form" method="POST">
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
                        <input type="text" class="form-control" value="{{ parseDate($begin_date,'d-m-Y') }}"
                               id="begin_date" name="begin_date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="end_date">Đến ngày</label>
                        <input type="text" class="form-control" id="end_date" value="{{ parseDate($end_date,'d-m-Y') }}"
                               name="end_date">
                    </div>
                    <div class="col-sm-offset-3">
                        <label for="first-digit-switch">Chỉ xét giải đặc biệt</label>
                        <input type="checkbox" @if(isset($special_only) && $special_only == 'on') checked
                               @endif data-toggle="toggle" data-size="mini" data-onstyle="primary" data-style="ios"
                               id="special_only" name="special_only">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4"><span
                                class="glyphicon glyphicon-forward" aria-hidden="true"></span> Chuyển
                    </button>
                </form>
            </div>
            <div class="kqbackground">
                <div class="form-group">
                    <label for="view_method" class="col-sm-3 col-sm-offset-1 control-label">Chọn tổng muốn xem</label>
                    <div class="col-sm-4">
                        <select name="view_method" id="view_method" class="form-control">
                            <option value="0" selected="">Tổng 0</option>
                            <option value="1">Tổng 1</option>
                            <option value="2">Tổng 2</option>
                            <option value="3">Tổng 3</option>
                            <option value="4">Tổng 4</option>
                            <option value="5">Tổng 5</option>
                            <option value="6">Tổng 6</option>
                            <option value="7">Tổng 7</option>
                            <option value="8">Tổng 8</option>
                            <option value="9">Tổng 9</option>
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <p class="chu15 daudong vietnghieng" style="padding-top:10px;"><span class="maudo"> Hướng dẫn</span>: B1
                    - Chọn tỉnh, khoảng ngày và bấm <span class="mauxanh">CHUYỂN</span>. =&gt; B2 - Chọn Cách xem (<span
                            class="maudo">KHÔNG</span> cần bấm Enter).</p>
            </div>
        </div>
        <script src="{{asset('/frontend/js/qtk_support_theotong.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/qtk_thongketonghop.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>

        <div id="common">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê theo tổng {{ get_name_from_slug($provinceAlias) }} từ
                        {{ parseDate($begin_date,'d-m-Y') }} đến {{ parseDate($end_date,'d-m-Y') }}</h4></div>
                <div class="panel-body">
                    @include('frontend.block.social')
                    {{--<table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">--}}
                        {{--<thead>--}}
                        {{--<tr class="info">--}}
                            {{--<th class="center">Bộ số</th>--}}
                            {{--<th class="center">Tổng số lần xuất hiện</th>--}}
                            {{--<th class="center">Lần xuất hiện cuối</th>--}}
                            {{--<th class="center">Số ngày chưa về</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody class="center">--}}
                        {{--@foreach($data as $key => $results)--}}
                            {{--@if($results && $results['counter'] > 0)--}}
                                {{--<tr id="{{sprintf('%01d', intval($key))}}" style="display: none">--}}
                                    {{--<td><b>{{$key}}</b></td>--}}
                                    {{--<td>{{$results['counter']}}</td>--}}
                                    {{--<td>--}}
                                        {{--<a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"--}}
                                           {{--target="_blank">{{ parseDate($results['latest']['day'],'d-m-Y')}}</a></td>--}}
                                    {{--<td class="center">{{countDateDiff($results['latest']['day'])}}</td>--}}
                                {{--</tr>--}}
                            {{--@else--}}
                                {{--<tr id="{{sprintf('%01d', intval($key))}}">--}}
                                    {{--<td><b>{{$key}}</b></td>--}}
                                    {{--<td colspan="2">Bộ số này không xuất hiện trong khoảng ngày bạn chọn</td>--}}
                                {{--</tr>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                    {!! $raw !!}
                </div>
                <div id="yesterday">
                    <div class="panel-heading center"><h4 class="right-menu-title">Loto lần quay gần đây nhất ngày <a
                                    class="mautrang"
                                    href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($day,'Y-m-d')]) }}">{{ parseDate($day,'d-m-Y') }}</a>
                            của {{ get_name_from_slug($provinceAlias) }}</h4></div>
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                        <thead>
                        <tr class="info">
                            <th class="center" style="width:15%;">Tổng</th>
                            <th class="center">Loto</th>
                        </tr>
                        </thead>
                        <tbody>
                        @isset($item)
                            @foreach($item as $index => $value)
                                <tr>
                                    <td class="vietdam"> Tổng {{ $index }}</td>
                                    @if(count($value) > 0)
                                        <td class="vietdam">
                                            @foreach($value as $text)
                                                @if($text['prize'] == 0)
                                                    <span class="maudo vietdam chu17">{{ $text['prize_number_lotto'] }},</span>
                                                @else
                                                {{ $text['prize_number_lotto'] }},
                                                @endif
                                            @endforeach
                                        </td>
                                    @else
                                        <td class="vietdam"></td>
                                    @endif
                                </tr>
                            @endforeach
                        @endisset
                        </tbody>
                        <tbody class="center"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('navRightTop')
    @include('frontend.block.newsLottery')
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
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
                format: 'd-m-yyyy', // site_date_format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });
            // Set the curerent begin day
            $('#begin_date').datepicker('update', '{!! parseDate($begin_date,'d-m-Y') !!}');

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

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            // Set event listener to change the view
            $('#view_method').change(function () {
                display_qtk(this.value);
            });

            display_qtk(0);
        });
    </script>

@endsection