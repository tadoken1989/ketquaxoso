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
                <h4 class="right-menu-title">Thống kê tổng hợp</h4>
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
                <div class="form-group">
                    <label for="view_method" class="col-sm-2 col-sm-offset-1 control-label">Chọn cách xem</label>
                    <div class="col-sm-4">
                        <select name="view_method" id="view_method" class="form-control">
                            <option value="0" selected="">Tất cả</option>
                            <option value="1">Tổng chẵn</option>
                            <option value="2">Tổng lẻ</option>
                            <option value="3">Chẵn chẵn</option>
                            <option value="4">Lẻ lẻ</option>
                            <option value="5">Chẵn lẻ</option>
                            <option value="6">Lẻ chẵn</option>
                            <option value="7">Bộ kép</option>
                            <option value="8">Sát kép</option>
                            <option value="9">Theo đầu số</option>
                            <option value="10">Theo đít số</option>
                            <option value="11">15 bộ số xuất hiện nhiều nhất</option>
                            <option value="12">15 bộ số xuất hiện ít nhất</option>
                        </select>
                    </div>
                </div>
                <br><br>
                <p class="chu15 daudong vietnghieng" style="padding-top:10px;"><span class="maudo"> Hướng dẫn</span>: B1
                    - Chọn tỉnh, khoảng ngày và bấm <span class="mauxanh">CHUYỂN</span>. =&gt; B2 - Chọn cách xem muốn
                    soi (<span class="maudo">KHÔNG</span> cần bấm Enter).</p>
            </div>
        </div>
        <div class="kqbackground vien">
            <link href="/frontend/bootstrap/css/bootstrap-toggle.min.css" rel="stylesheet">
            <script src="/frontend/bootstrap/js/bootstrap-toggle.min.js" type=""></script>
            <script src="/frontend/js/qtk_support.js" type=""></script>
            <script src="/frontend/js/qtk_thongketonghop.js" type=""></script>
            <script src="/frontend/js/bootstrap-datepicker.vi.min.js" type=""></script>
            <div id="common">
                <div class="panel panel-default">
                    <div class="panel-heading center">
                        <h4 class="right-menu-title">Thống kê tổng hợp
                            @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                                Truyền Thống
                            @else
                                Truyền Thống
                            @endif
                            @foreach(load_province() as $pro)
                                @if($pro->region_id != 2)
                                    @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                        {{$pro->name}}
                                    @endif
                                @endif
                            @endforeach

                            từ {!! parseDate($begin_date,'d-m-Y') !!} đến {!! parseDate($end_date,'d-m-Y') !!}
                        </h4>
                    </div>
                    <div class="panel-body">
                        @include('frontend.block.social')
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info dosam">
                                <th class="center">Bộ số</th>
                                <th class="center">Tổng số lần xuất hiện</th>
                                <th class="center">Ngày về gần nhất</th>
                                <th class="center">Số ngày chưa về</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @foreach($data as $key => $results)
                                @if($results)
                                    <tr id="{{sprintf('%01d', intval($key))}}">
                                        <td><b>{{$key}}</b></td>
                                        <td>{{$results['counter']}}</td>
                                        <td>
                                            <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"
                                               target="_blank">{{$results['latest']['day']}}</a></td>
                                        <td class="center">{{countDateDiff($results['latest']['day'])}}</td>
                                    </tr>
                                @else
                                    <tr id="{{sprintf('%01d', intval($key))}}">
                                        <td><b>{{$key}}</b></td>
                                        <td colspan="2">Bộ số này không xuất hiện trong khoảng ngày bạn chọn</td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="by_head">
                        <legend>
                            <p class="text-center dosam kqbackground qtk-ganhon">Theo đầu số</p>
                        </legend>
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info">
                                <th class="center">Đầu số</th>
                                <th class="center">Số lần xuất hiện</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @if(isset($items['head']))
                                @foreach($items['head'] as $key => $item)
                                    <tr>
                                        <td><b>Đầu {{ $key }}</b></td>
                                        <td>{{ $item }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div id="by_tail">
                        <legend>
                            <p class="text-center dosam kqbackground qtk-ganhon">Theo đuôi số</p>
                        </legend>
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info">
                                <th class="center">Đuôi số</th>
                                <th class="center">Số lần xuất hiện</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @if(isset($items['foot']))
                                @foreach($items['foot'] as $key => $item)
                                    <tr>
                                        <td><b>Đuôi {{ $key }}</b></td>
                                        <td>{{ $item }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div id="top15">
                        <legend>
                            <p class="text-center dosam kqbackground qtk-ganhon">15 bộ số xuất hiện nhiều nhất</p>
                        </legend>
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info">
                                <th class="center">Bộ số</th>
                                <th class="center">Số lần xuất hiện</th>
                                <th class="center">Lần xuất hiện cuối</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @foreach(array_slice(array_sort_key($data,'counter',SORT_DESC),0,15) as $key => $results)
                                <tr id="{{sprintf('%01d', intval($key))}}">
                                    <td><b>{{ $results['latest']['numbers'] }}</b></td>
                                    <td>{{$results['counter']}}</td>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"
                                           target="_blank">{{ parseDate($results['latest']['day']) }}</a> ({{countDateDiff($results['latest']['day'])}}
                                        ngày trước)
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="bottom15">
                        <legend>
                            <p class="text-center dosam kqbackground qtk-ganhon">15 Bộ số xuất hiện ít nhất</p>
                        </legend>
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info">
                                <th class="center">Bộ số</th>
                                <th class="center">Số lần xuất hiện</th>
                                <th class="center">Lần xuất hiện cuối</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @foreach(array_slice(array_sort_key($data,'counter',SORT_ASC),0,15) as $key => $results)
                                <tr id="{{sprintf('%01d', intval($key))}}">
                                    <td><b>{{ $results['latest']['numbers'] }}</b></td>
                                    <td>{{$results['counter']}}</td>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"
                                           target="_blank">{{ parseDate($results['latest']['day']) }}</a> ({{countDateDiff($results['latest']['day'])}}
                                        ngày trước)
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
        });
    </script>
@endsection