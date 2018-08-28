<!DOCTYPE html>
<html lang="vi">
<head>
    @include('frontend.block.meta')
    @yield('meta')
    <link rel="shortcut icon" href="{{asset('/frontend/images/ketqua.jpg')}}">
    <title>{{ setting('seo.title') }}</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Latest compiled and minified CSS -->
    <link href="{{asset('/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/province_menu.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/row_no_gutter.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/table_kq.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/global.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/balloon.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/BreakingNews.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/css/metisMenu.css')}}" rel="stylesheet">
    @yield('css')
    <script src="{{asset('/frontend/js/jquery-2.1.3.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/jquery.printElement.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/qxssupport.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/customize_calendar.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/balloon.js')}}" type="text/javascript"></script>
    <script src="{{asset('/frontend/js/BreakingNews.js')}}" type="text/javascript"></script>
    @yield('header')
    {!! setting('header.addon') !!}
</head>
<body>
<div class="container big-container">
    <h1 class="mainh1">Kết quả xổ số trực tiếp - Soi cầu, Thống kê xoso miền bắc nam xsmb xsmn</h1>
    {{--NAV--}}
    @include('frontend.block.nav')
    {{--HEADER--}}
    @include('frontend.block.header')
    <div class="row">
        {{--NAV-LEFT--}}
        @yield('navLeft')
        {{--@include('frontend.block.navLeft')--}}
        {{--CONTENT--}}
        @yield('content')
        {{--NAV-RIGHT--}}
        <div class="col-sm-3">
            {{-- navRightTop --}}
            @yield('navRightTop')
            {{-- navRightBottom --}}
            @yield('navRightBottom')
        </div>
    </div>
    @include('frontend.block.footer')
    @yield('extra-js')
</div>
</body>
</html>