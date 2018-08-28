@extends('frontend.layouts.index')
@section('css')
    <style>
        table#bangtknhanh tbody tr.act {
            background-color: #ffbf00;
            color: black;
        }
    </style>
    <style>
        .toggle.ios,
        .toggle-on.ios,
        .toggle-off.ios {
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
                <h4 class="right-menu-title">Thống kê nhanh</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal " id="chuky_form" method="POST">
                    {{csrf_field()}}
                    <div class="form-group ">
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
                            <input type="text" class="form-control" id="begin_date" name="begin_date">
                        </div>
                        <label for="code" class="col-sm-1 control-label">đến</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="first-digit-switch" class="col-sm-2 col-sm-offset-2">Chỉ xét giải
                            <span class="maudo">đặc biệt</span>
                        </label>
                        <div class="col-sm-1">
                            <input type="checkbox" data-toggle="toggle" data-size="mini" data-onstyle="primary"
                                   data-style="ios" id="special_only" name="special_only">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-eye"></i> Chuyển
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="form-group">
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="2" id="numbers" name="numbers"
                                  placeholder="Điền các bộ số bạn muốn xem (ngăn cách bằng dấu phẩy). Để trống để xem mọi bộ số"></textarea>
                    </div>
                </div>
                <br>
                <p class="chu15 daudong vietnghieng" style="padding-top:25px;">
                    <span class="maudo"> Hướng dẫn</span>: B1 - Chọn tỉnh, khoảng ngày và bấm
                    <span class="mauxanh">CHUYỂN</span>. =&gt; B2 - Chọn nhanh bộ số muốn xem (
                    <span class="maudo">KHÔNG</span> cần bấm Enter).</p>
            </div>
        </div>
        <div class="kqbackground vien">
            <link href="{{ asset('/frontend/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
            <script src="{{ asset('/frontend/js/bootstrap-toggle.min.js')}}" type=""></script>
            <script src="{{ asset('/frontend/js/thongkenhanh.js')}}" type=""></script>
            <script src="{{ asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Thống kê nhanh
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

                        từ {!! parseDate($start_date,'d-m-Y') !!} đến {!! parseDate($end_date,'d-m-Y') !!}
                    </h4>
                </div>
                <div class="panel-body">
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover"
                           id="bangtknhanh">
                        <thead class="center">
                        <tr class="info dosam">
                            <th class="center">Bộ số</th>
                            <th class="center">Ngày về gần nhất</th>
                            <th class="center">Tổng số lần xuất hiện</th>
                            <th class="center">Số ngày chưa về</th>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @foreach($data as $key => $results)
                            @if($results)
                                <tr id="{{sprintf('%01d', intval($key))}}">
                                    <td><b>{{$key}}</b></td>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"
                                           target="_blank">{{$results['latest']['day']}}</a></td>
                                    <td>{{$results['counter']}}</td>
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
    <script type="">
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
            $('#begin_date').datepicker('update', '{!! parseDate($start_date,'d-m-Y') !!}');

            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#date'));

            // Viet vao day
            $('table#bangtknhanh tbody tr').click(function () {
                $(this).toggleClass('act');
            });
        });
    </script>
@endsection