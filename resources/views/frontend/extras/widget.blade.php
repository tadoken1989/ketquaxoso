@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table-centered.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="kqbackground">
            <legend><p class="text-center mautrang nendosam chu16">WIDGET KETQUA.NET</p></legend>
            <form class="form-inline" id="chuky_form" method="POST">
                <label for="code" class="col-sm-1 control-label daudong">Tỉnh</label>
                <div class="form-group col-sm-3">
                    <select name="widget_code" id="widget_code" class="form-control">
                        @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                            <option data-province="mb" value="mb" selected>Truyền thống</option>
                        @else
                            <option data-province="mb" value="mb">Truyền thống</option>
                        @endif
                        @foreach(load_province() as $pro)
                            @if($pro->region_id != 2)
                                @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                    <option data-province="{{ $pro->alias }}" value="{{$pro->alias}}" selected>{{$pro->name}}</option>
                                @else
                                    <option data-province="{{ $pro->alias }}" value="{{$pro->alias}}">{{$pro->name}}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>
                <label for="code" class="col-sm-2 control-label">Chiều rộng</label>
                <div class="form-group col-sm-2">
                    <select name="widget_width" id="widget_width" class="form-control">
                        <option value="0">Tự chiếm hết chiều rộng</option>
                        <option value="1">300px</option>
                        <option value="2">500px</option>
                    </select>
                </div>
            </form>
            <br>
            <hr>
            <label for="widgetsource" class="daudong">Copy mã nguồn dưới đây và để vào nơi nào bạn muốn đặt widget trênwebsite của bạn:</label>
            <pre id="widgetsource_pre" style="margin: 10px;"></pre>
            <hr>
            <div id="widgetkq"></div>
            <script src="{{ asset('/frontend/js/widgetgenerate.js')}}" type="text/javascript"></script>
        </div>
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
@endsection