@extends('frontend.layouts.index')
@section('navLeft')
    @include('frontend.block.navLeft')
    @include('frontend.partials.left_date')
@endsection
@section('content')
    <div class="col-sm-5">
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Dò xổ số {{ get_name_from_slug($provinceAlias)}}</h4>
            </div>
            <div class="panel-body">
                <form method="POST" id="doxoso">
                    {{ csrf_field() }}
                    <div class="form-group col-sm-3 daudong">
                        <label for="code">Tỉnh</label>
                        <select name="code" id="code" class="form-control">
                            @if(isset($provinceAlias) && $provinceAlias == 'mien bac')
                                <option data-province="mb" value="mien-bac" selected>Truyền thống</option>
                            @else
                                <option data-province="mb" value="mien-bac">Truyền thống</option>
                            @endif
                            @foreach(load_province() as $pro)
                                @if($pro->region_id != 2)
                                    @if(isset($provinceAlias) && $provinceAlias == $pro->slug)
                                        <option data-province="{{ $pro->alias }}" value="{{$pro->slug}}" selected>{{$pro->name}}</option>
                                    @else
                                        <option data-province="{{ $pro->alias }}" value="{{$pro->slug}}">{{$pro->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="form-control">Ngày</label>
                        <input type="text" class="form-control" id="date" value="{{ parseDate($date,'d-m-Y') }}"
                               name="date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="form-control">Vé số</label>
                        <input type="text" class="form-control" id="number_string" name="number_string"
                               placeholder="Vé số của bạn" value="{{ $number_string }}">
                    </div>
                    <div col-sm-2="" col-sm-offset-4="">
                        <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-4">Dò vé số</button>
                    </div>
                </form>
            </div>
        </div>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <script src="{{asset('/frontend/js/doxoso_support.js')}}" type=""></script>
        <legend class="kqvertimarginw kqbackground dosam"><p class="text-center">Dò xổ
                số {{ get_name_from_slug($provinceAlias) }} ngày {{ parseDate($date,'d-m-Y') }}</p></legend>
{{--        @include('frontend.block.social')--}}
        @if($data_result && $number_string != '')
        <h4>Dò số <span id="doxoso_number_string">{{ $number_string }}</span></h4>
        <h5 id="prize_win"></h5>
        <h5 id="loto_win"></h5>
        @endif
        <div class="kqbackground vien tb-phoi">
            <div class="outer_result_mb">
                <div class="result_div ">
                    <div class="color333">
                        @if($data_result)
                            @if($data_result->province->region_id == 2)
                                @include('frontend.partials.template_result_north',['resultLottery'=>$data_result])
                                @include('frontend.block.bingo',['resultLottery'=>$data_result])
                                @include('frontend.block.bingoHeadEnd',['resultLottery'=>$data_result])
                            @else
                                @include('frontend.partials.template_result_south',['resultLottery'=>$data_result])
                                @include('frontend.block.bingo',['resultLottery'=>$data_result])
                                @include('frontend.block.bingoHeadEnd',['resultLottery'=>$data_result])
                            @endif
                        @endif
                    </div>
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
            $('#date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-4y'
            });
            // Set the curerent begin day
            $('#date').datepicker('update', '{!! parseDate($date,'d-m-Y') !!}');
        });
    </script>
@endsection