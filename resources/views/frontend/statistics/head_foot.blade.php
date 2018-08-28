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
        <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê tần suất loto</h4>
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
                        <label for="date">Biên độ ngày</label>
                        <input type="text" class="form-control" value="{{ parseDate($date,'d-m-Y') }}" id="date"
                               name="date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="count">Khoảng ngày</label>
                        <div class="input-group bootstrap-touchspin">
                                <span class="input-group-addon bootstrap-touchspin-prefix">
                                </span>
                            <input type="text" id="count" class="form-control" name="count" value="{{ $count }}">
                        </div>
                    </div>
                    <div class="form-group col-sm-offset-4 col-sm-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i>Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê đầu đuôi loto Truyền Thống trong
                        vòng 20 ngày trước {{ parseDate($date,'d-m-Y') }}</h4></div>
                <div class="panel-body">
                    <table class="table table-condensed table-bordered qtk-hover table-responsive table-kq-bold-border kqbackground">
                        <thead>
                        <tr class="info">
                            <th class="center">Ngày</th>
                            <td class="center">Đầu <b>0</b></td>
                            <td class="center">Đầu <b>1</b></td>
                            <td class="center">Đầu <b>2</b></td>
                            <td class="center">Đầu <b>3</b></td>
                            <td class="center">Đầu <b>4</b></td>
                            <td>Đầu <b class="center">5</b></td>
                            <td class="center">Đầu <b>6</b></td>
                            <td class="center">Đầu <b>7</b></td>
                            <td class="center">Đầu <b>8</b></td>
                            <td class="center">Đầu <b>9</b></td>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @if($data && isset($data['head']))
                            <?php $counter = [] ?>
                            @foreach($data['head'] as $index_date => $head)
                                <tr>
                                    @foreach($head as $index =>$item)
                                        @if($index == 0)
                                            <td>
                                                <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=> parseDate($index_date,'d-m-Y')]) }}"
                                                   target="_blank">{{ parseDate($index_date,'d-m-Y') }}</a></td>
                                        @endif
                                        <td class="@if($item > 3)success vietdam @endif">{{ $item }} lần</td>
                                        <?php
                                        if (!isset($counter[$index])) {
                                            $counter[$index] = 0;
                                        }
                                        $counter[$index] = $counter[$index] + $item;
                                        ?>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                        <tr class="info vietdam">
                            <td><b>Tổng</b></td>
                            <td>{{  $counter[0] }} lần</td>
                            <td>{{  $counter[1] }} lần</td>
                            <td>{{  $counter[2] }} lần</td>
                            <td>{{  $counter[3] }} lần</td>
                            <td>{{  $counter[4] }} lần</td>
                            <td>{{  $counter[5] }} lần</td>
                            <td>{{  $counter[6] }} lần</td>
                            <td>{{  $counter[7] }} lần</td>
                            <td>{{  $counter[8] }} lần</td>
                            <td>{{  $counter[9] }} lần</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <div class="panel-heading center"><h4 class="right-menu-title">Thống kê theo đuôi loto</h4></div>
                    <table class="table table-condensed table-bordered qtk-hover table-responsive table-kq-bold-border kqbackground">
                        <thead>
                        <tr class="info">
                            <th class="center">Ngày</th>
                            <td class="center">Đuôi <b>0</b></td>
                            <td class="center">Đuôi <b>1</b></td>
                            <td class="center">Đuôi <b>2</b></td>
                            <td class="center">Đuôi <b>3</b></td>
                            <td class="center">Đuôi <b>4</b></td>
                            <td class="center">Đuôi <b>5</b></td>
                            <td class="center">Đuôi <b>6</b></td>
                            <td class="center">Đuôi <b>7</b></td>
                            <td class="center">Đuôi <b>8</b></td>
                            <td class="center">Đuôi <b>9</b></td>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @if($data && isset($data['foot']))
                            <?php $counter = [] ?>
                            @foreach($data['foot'] as $index_date => $head)
                                <tr>
                                    @foreach($head as $index =>$item)
                                        @if($index == 0)
                                            <td>
                                                <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=> parseDate($index_date,'d-m-Y')]) }}"
                                                   target="_blank">{{ parseDate($index_date,'d-m-Y') }}</a></td>
                                        @endif
                                        <td class="@if($item > 3)success vietdam @endif">{{ $item }} lần</td>
                                        <?php
                                        if (!isset($counter[$index])) {
                                            $counter[$index] = 0;
                                        }
                                        $counter[$index] = $counter[$index] + $item;
                                        ?>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                        <tr class="info vietdam">
                            <td><b>Tổng</b></td>
                            <td>{{  $counter[0] }} lần</td>
                            <td>{{  $counter[1] }} lần</td>
                            <td>{{  $counter[2] }} lần</td>
                            <td>{{  $counter[3] }} lần</td>
                            <td>{{  $counter[4] }} lần</td>
                            <td>{{  $counter[5] }} lần</td>
                            <td>{{  $counter[6] }} lần</td>
                            <td>{{  $counter[7] }} lần</td>
                            <td>{{  $counter[8] }} lần</td>
                            <td>{{  $counter[9] }} lần</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                    <hr>
                    <div class="panel-heading center"><h4 class="right-menu-title">Thống kê theo tổng loto</h4></div>
                    <table class="table table-condensed table-bordered qtk-hover table-responsive table-kq-bold-border kqbackground">
                        <thead>
                        <tr class="info">
                            <th class="center">Ngày</th>
                            <td class="center">Tổng <b>0</b></td>
                            <td class="center">Tổng <b>1</b></td>
                            <td class="center">Tổng <b>2</b></td>
                            <td class="center">Tổng <b>3</b></td>
                            <td class="center">Tổng <b>4</b></td>
                            <td class="center">Tổng <b>5</b></td>
                            <td class="center">Tổng <b>6</b></td>
                            <td class="center">Tổng <b>7</b></td>
                            <td class="center">Tổng <b>8</b></td>
                            <td class="center">Tổng <b>9</b></td>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @if($data && isset($data['totalHeadFoot']))
                            <?php $counter = [] ?>
                            @foreach($data['totalHeadFoot'] as $index_date => $head)
                                <tr>
                                    @foreach($head as $index =>$item)
                                        @if($index == 0)
                                            <td>
                                                <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=> parseDate($index_date,'d-m-Y')]) }}"
                                                   target="_blank">{{ parseDate($index_date,'d-m-Y') }}</a></td>
                                        @endif
                                        <td class="@if($item > 3)success vietdam @endif">{{ $item }} lần</td>
                                        <?php
                                        if (!isset($counter[$index])) {
                                            $counter[$index] = 0;
                                        }
                                        $counter[$index] = $counter[$index] + $item;
                                        ?>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                        <tr class="info vietdam">
                            <td><b>Tổng</b></td>
                            <td>{{  $counter[0] }} lần</td>
                            <td>{{  $counter[1] }} lần</td>
                            <td>{{  $counter[2] }} lần</td>
                            <td>{{  $counter[3] }} lần</td>
                            <td>{{  $counter[4] }} lần</td>
                            <td>{{  $counter[5] }} lần</td>
                            <td>{{  $counter[6] }} lần</td>
                            <td>{{  $counter[7] }} lần</td>
                            <td>{{  $counter[8] }} lần</td>
                            <td>{{  $counter[9] }} lần</td>
                        </tr>
                        </tbody>
                    </table>
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
    <script type="">
        $(document).ready(function () {
            $('#date').datepicker({
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
            link_selector_dpicker($('form#main_form select#code'), $('form#main_form input#date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#main_form input#date'));

            // Set the curerent last day
            $('#date').datepicker('update', '{!! parseDate($date,'d-m-Y') !!}');

            $('#count').TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                postfix: ' ngày'
            });
        });
    </script>
@endsection