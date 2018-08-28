@extends('frontend.layouts.index')
@section('css')
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê theo ngày</h4>
            </div>
            <div class="panel-body">
                <form id="chuky_form" method="POST">
                    {{csrf_field()}}
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
                        <label for="day_of_week">Vào ngày</label>
                        <select name="day_of_week" id="day_of_week" class="form-control">
                            <option value="0" @if($day_of_week == 0)selected @endif>Chủ nhật</option>
                            <option value="1" @if($day_of_week == 1)selected @endif>Thứ hai</option>
                            <option value="2" @if($day_of_week == 2)selected @endif>Thứ ba</option>
                            <option value="3" @if($day_of_week == 3)selected @endif>Thứ tư</option>
                            <option value="4" @if($day_of_week == 4)selected @endif>Thứ năm</option>
                            <option value="5" @if($day_of_week == 5)selected @endif>Thứ sáu</option>
                            <option value="6" @if($day_of_week == 6)selected @endif>Thứ bảy</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="day_method">Trong khoảng</label>
                        <select name="day_method" id="day_method" class="form-control">
                            <option value="4" @if($day_method == 4)selected @endif>4 tuần trước</option>
                            <option value="8" @if($day_method == 8)selected @endif>8 tuần trước</option>
                            <option value="12" @if($day_method == 12)selected @endif>12 tuần trước</option>
                            <option value="24" @if($day_method == 24)selected @endif>24 tuần trước</option>
                            <option value="36" @if($day_method == 36)selected @endif>36 tuần trước</option>
                            <option value="48" @if($day_method == 48)selected @endif>48 tuần trước</option>
                            <option value="60" @if($day_method == 60)selected @endif>60 tuần trước</option>
                            <option value="66" @if($day_method == 66)selected @endif>66 tuần trước</option>
                            <option value="72" @if($day_method == 72)selected @endif>72 tuần trước</option>
                            <option value="80" @if($day_method == 80)selected @endif>80 tuần trước</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4"><i class="fa fa-eye"></i> Xem
                        kết quả
                    </button>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê theo
                        ngày {{ get_name_from_slug($provinceAlias) }} cho các
                        @if($day_of_week == 0)
                            Chủ nhật
                        @elseif($day_of_week ==1)
                            Thứ hai
                        @elseif($day_of_week ==2)
                            Thứ ba
                        @elseif($day_of_week ==3)
                            Thứ tư
                        @elseif($day_of_week ==4)
                            Thứ năm
                        @elseif($day_of_week ==5)
                            Thứ sáu
                        @elseif($day_of_week ==6)
                            Thứ bảy
                        @endif
                        trong
                        {{ $day_method }}
                        tuần trước</h4></div>
                <div class="panel-body">
                    @include('frontend.block.social')
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

@endsection