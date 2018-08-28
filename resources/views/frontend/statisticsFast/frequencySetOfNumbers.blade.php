@extends('frontend.layouts.index')
@section('css')
    <style type="text/css">
        table#tansuatboso tbody tr.act {
            background-color: #ffbf00;
            color: black;
        }

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
                <h4 class="right-menu-title">Thống kê tần suất bộ số</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="chuky_form" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="code" class="col-sm-3 control-label">Tỉnh</label>
                        <div class="col-sm-5">
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
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-3 control-label">Số ngày</label>
                        <div class="col-sm-5">
                            <select name="day_count" id="day_count" class="form-control">
                                <option value="10" @if($day_count == 10)selected @endif>10 ngày trước</option>
                                <option value="20" @if($day_count == 20)selected @endif>20 ngày trước</option>
                                <option value="30" @if($day_count == 30)selected @endif>30 ngày trước</option>
                                <option value="50" @if($day_count == 50)selected @endif>50 ngày trước</option>
                                <option value="120" @if($day_count == 120)selected @endif>120 ngày trước</option>
                                <option value="240" @if($day_count == 240)selected @endif>240 ngày trước</option>
                                <option value="300" @if($day_count == 300)selected @endif>300 ngày trước</option>
                                <option value="365" @if($day_count == 365)selected @endif>365 ngày trước</option>
                                <option value="400" @if($day_count == 400)selected @endif>400 ngày trước</option>
                                <option value="450" @if($day_count == 450)selected @endif>450 ngày trước</option>
                                <option value="500" @if($day_count == 500)selected @endif>500 ngày trước</option>
                                <option value="5000" @if($day_count == 5000)selected @endif>5000 ngày trước</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="kqcenter">
                            <label for="first-digit-switch">Chỉ xét giải
                                <span class="maudo">đặc biệt</span>
                            </label>
                            <input type="checkbox" @if(isset($special_only) && $special_only =='on') checked @endif data-toggle="toggle" data-size="mini" data-onstyle="primary" data-style="ios" id="special_only" name="special_only">

                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4">
                        <i class="fa fa-eye"></i> Xem
                    </button>
                </form>
                <br>
                <hr>
                <div class="form-group">
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="2" id="numbers" name="numbers"
                                  placeholder="Điền các bộ số bạn muốn xem (ngăn cách bằng dấu phẩy). Để trống để xem mọi bộ số"></textarea>
                    </div>
                </div>
                <p class="chu15 daudong vietnghieng" style="padding-top:15px;">
                    <span class="maudo"> Hướng dẫn</span>: B1 - Chọn tỉnh, số ngày và bấm
                    <span class="mauxanh">XEM</span>. =&gt; B2 - Chọn nhanh bộ số muốn xem (
                    <span class="maudo">KHÔNG</span> cần bấm Enter).</p>
            </div>
        </div>
        <div class="kqbackground vien">
            <link href="{{ asset('frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
            <script src="{{ asset('frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>
            <script src="{{ asset('frontend/js/thongkenhanh.js')}}" type=""></script>
            <script src="{{ asset('frontend/js/stupidtable.min.js')}}" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Thống kê tần suất bộ số
                        {{ get_name_from_slug($provinceAlias) }}
                        trong {{ $day_count }} ngày trước</h4>
                </div>
                <div class="panel-body">
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover"
                           id="tansuatboso">
                        <thead>
                        <tr class="info dosam">
                            <th class="center">Bộ số</th>
                            <th class="center">Tổng số ngày về</th>
                            <th class="center">Tổng số lần về</th>
                            <th class="center">Tần số theo ngày</th>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @foreach($data as $key => $value)
                            @if(isset($value['total_lotto']) && $value['total_lotto'] > 0)
                            <tr id="{{sprintf('%01d', intval($key))}}">
                                <td><b>{{ $key }}</b></td>
                                <td>{{$value['total_day']}} ngày (<span class="maudo vietdam">{{ percentTotalReturn($value['total_day'],$day_count) }}</span>%)</td>
                                <td>{{$value['total_lotto']}} lần (<span class="maudo vietdam"> {{ percentTotalReturn($value['total_lotto'],$total) }}</span>%)
                                </td>
                                <td>{{ percentTotalReturn($value['total_lotto'],$value['total_day'],1)}} lần/ngày
                                    (<span class="maudo vietdam">{{ percentTotalReturn($value['total_lotto'],$value['total_day']) }}</span>%)
                                </td>
                            </tr>
                            @else
                            <tr id="{{sprintf('%01d', intval($key))}}">
                                <td><b>{{ $key }}</b></td>
                                <td colspan="3">Bộ số này không xuất hiện trong khoảng ngày bạn chọn</td>
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
    <script type="text/javascript">// Viet vao day
        $('table#tansuatboso tbody tr').click(function () {
            $(this).toggleClass('act');
        });
    </script>
@endsection