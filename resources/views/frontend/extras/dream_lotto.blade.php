@extends('frontend.layouts.app')
@section('css')
    <link href="{{asset('/frontend/css/table-centered.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Sổ mơ - Giải mộng lô đề</h4>
            </div>
            <div class="panel-body">
                <form id="chuky_form" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group col-sm-6 daudong">
                        <label for="search_string">Giấc mơ</label>
                        <input type="text" class="form-control" id="search_string" name="search_string"
                               placeholder="Nhập giấc mơ" value="{{ $search_string }}">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="search_number">Bộ số</label>
                        <input type="text" class="form-control" id="search_number" name="search_number"
                               placeholder="Nhập bộ số" value="{{ $search_number }}">
                    </div>
                    <div class="col-sm-2 col-sm-offset-4">
                        <button type="submit" class="btn btn-primary">Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading center"><h4 class="right-menu-title">Sổ mơ - Trang 1</h4></div>
            <div class="panel-body">
                @include('frontend.block.social')
                <nav class="kqcenter">
                    {{ $links }}
                </nav>
                <table class="table table-condensed table-bordered qtk-hover kqbackground kqcenter kqvertimargin table-kq-bold-border">
                    <thead>
                    <tr class="info dosam">
                        <th class="text-center" style="width:15%;">Số thứ tự</th>
                        <th class="text-center">Giấc mơ</th>
                        <th class="text-center" style="width:30%">Bộ số</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($data)
                        @foreach($data as $key =>$item)
                            <tr>
                                <td>{{ $key+ 1 }}</td>
                                <td>{{ $item->dream_content }}</td>
                                <td>{{ $item->result_dream }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <nav class="kqbackground kqcenter">
                    {{ $links }}
                </nav>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        @include('frontend.block.newsLottery')
        @include('frontend.block.navRight')
    </div>
@endsection