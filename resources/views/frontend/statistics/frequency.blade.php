@extends('frontend.layouts.index')
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tần số nhịp loto</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Thống kê số lần xuất hiện, vị trí và nhịp ngày giữa các lần xuất hiện
                            của một bộ số trong khoảng ngày bạn chọn.</p>
                        <p class="“text-justify”">Vị trí G3-5 : con loto thứ 5 của giải 3</p>
                        <p class="“text-justify”">Nhịp: số ngày giữa 2 lần xuất hiện con loto bạn chọn.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <link href="{{ asset('/frontend/css/table-centered.css') }}" rel="stylesheet">
        <script src="{{ asset('/frontnend/js/bootstrap-datepicker.vi.min.js') }}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê tần suất nhịp loto</h4>
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
                            <input type="text" class="form-control" value="{{ $start_date }}" id="begin_date"
                                   name="begin_date">
                        </div>
                        <label for="code" class="col-sm-1 control-label">Đến</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" value="{{ $end_date }}" id="end_date"
                                   name="end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Cặp số khảo sát</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="number" name="number" placeholder="Bộ số"
                                   value="{{ $number }}">
                        </div>
                        <label for="code" class="col-sm-2 control-label">Theo thứ</label>
                        <div class="col-sm-3">
                            <select name="day_ow" id="day_ow" class="form-control">
                                <option value="0" @if($day_ow == 0)selected @endif>Chủ nhật</option>
                                <option value="1" @if($day_ow == 1)selected @endif>Thứ hai</option>
                                <option value="2" @if($day_ow == 2)selected @endif>Thứ ba</option>
                                <option value="3" @if($day_ow == 3)selected @endif>Thứ tư</option>
                                <option value="4" @if($day_ow == 4)selected @endif>Thứ năm</option>
                                <option value="5" @if($day_ow == 5)selected @endif>Thứ sáu</option>
                                <option value="6" @if($day_ow == 6)selected @endif>Thứ bảy</option>
                                <option value="7" @if($day_ow == 7)selected @endif>Tất cả các thứ</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4"><i class="fa fa-eye"></i> Xem
                        kết quả
                    </button>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                        <thead>
                        <tr class="info dosam">
                            <th class="center">Ngày</th>
                            <th class="center">Thứ</th>
                            <th class="center">Số lần về</th>
                            <th class="center">Về ở giải</th>
                            <th class="center">Số nhịp xuất hiện</th>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @if($list_results)
                            <?php $count = 0 ?>
                            @foreach($list_results as $key =>$item)
                                <tr>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($item['result_day'])]) }}"
                                           target="_blank">{{ parseDate($item['result_day'],'d-m-Y') }}</a>
                                    </td>
                                    <td>{{ convert_to_vn(parseStringToDay($item['result_day'])) }}</td>
                                    <td> {{ $item['counter'] }}</td>
                                    <?php $count = $count + intval($item['counter']) ?>
                                    <td>{{ getShortNameFromPrize($item['prize']) }}-{{$item['order'] + 1}};</td>
                                    <td>
                                        @if($key != (count($list_results)-1))
                                        {{ countBetweenDateDiff($list_results[$key+1]['result_day'],$item['result_day']) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="info vietdam center">
                                <td><b>Tổng số lần về:</b></td>
                                <td colspan="4" class="maudo">{{ $count }} lần</td>
                            </tr>
                        @endif
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#begin_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
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
            $('#begin_date').datepicker('update', '{!! parseDate($start_date,'d-m-Y') !!}');

            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'dd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });

            // Link up
            link_selector_dpicker($('form#main_form select#code'), $('#end_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#end_date'));

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');
        });
    </script>
@endsection