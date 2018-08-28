@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table-centered.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Lịch tường thuật trực tiếp và kết quả bóng đá</h4>
            </div>
            <div class="panel-body">
                <iframe src="http://android.livescore.com/" width="100%" height="1500"
                        style="border:0px double #00EDFF"></iframe>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection
@section('extra-js')
@endsection