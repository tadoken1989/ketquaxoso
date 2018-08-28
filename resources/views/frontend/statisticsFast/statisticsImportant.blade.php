@extends('frontend.layouts.index')
@section('css')
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê quan trọng</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="chuky_form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Tỉnh</label>
                        <div class="col-sm-3">
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
                        <button type="submit" class="btn btn-primary col-sm-2"><span class="glyphicon glyphicon-forward"
                                                                                     aria-hidden="true"></span> Chuyển
                            Tỉnh
                        </button>
                    </div>
                </form>
                <hr>
                <div class="form-group">
                    <label for="viewmode" class="col-sm-3 col-sm-offset-1 control-label">Chọn thống kê muốn xem</label>
                    <div class="col-sm-6">
                        <select name="viewmode" id="viewmode" class="form-control">
                            <option value="top27">27 bộ số xuất hiện nhiều nhất trong 30 ngày trước</option>
                            <option value="bottom10">10 bộ số xuất hiện ít nhất trong 30 ngày trước</option>
                            <option value="nolast10">Những bộ số không xuất hiện trong vòng 10 lần gần nhất</option>
                            <option value="longstreak">Những bộ số xuất hiện liên tiếp</option>
                            <option value="longest_streaks_end_last_day">Những bộ số xuất hiện liên tiếp và kết thúc vào
                                ngày hôm nay
                            </option>
                        </select>
                    </div>
                </div>
                <hr>
                <p class="chu15 daudong vietnghieng" style="padding-top:25px;"><span class="maudo"> Hướng dẫn</span>: B1
                    - Chọn tỉnh và bấm <span class="mauxanh">CHUYỂN</span>. =&gt; B2 - Chọn kiểu thống kê muốn xem
                    (<span class="maudo">KHÔNG</span> cần bấm Enter).</p>
            </div>
        </div>
        <div class="kqbackground vien">
            <script src="{{asset('/frontend/js/qtk_thongkequantrong.js')}}" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê quan
                        trọng {{ get_name_from_slug($provinceAlias) }} trong 30 lần quay số</h4></div>
                <div class="panel-body">
                    @include('frontend.block.social')
                    <div id="top27" class="viewpart" style="display: block;">
                        <legend><p class="text-center dosam kqbackground qtk-ganhon">27 bộ số xuất hiện nhiều lần
                                nhất</p></legend>
                        <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                            <thead>
                            <tr class="info">
                                <th class="center">Bộ số</th>
                                <th class="center">Số ngày chưa về</th>
                                <th class="center">Ngày về gần nhất</th>
                                <th class="center">Tổng số lần về</th>
                            </tr>
                            </thead>
                            <tbody class="center">
                            @foreach(array_slice(array_sort_key($data,'counter',SORT_DESC),0,27) as $key => $results)
                                <tr id="{{sprintf('%01d', intval($key))}}">
                                    <td><b>{{ $results['latest']['numbers'] }}</b></td>
                                    <td>{{countDateDiff($results['latest']['day'])}}</td>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($results['latest']['day'])]) }}"
                                           target="_blank">{{ parseDate($results['latest']['day']) }}</a>
                                    </td>
                                    <td>{{$results['counter']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($raw)
                        {!! $raw !!}
                    @endif
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
    </script>
@endsection