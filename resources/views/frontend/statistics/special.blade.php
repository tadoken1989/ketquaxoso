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
                        <label for="end_date">Xem đến ngày <span class="vietthuong">(từ 2001)</span></label> <input
                                type="text" class="form-control" value="{{ parseDate($date,'d-m-Y') }}" id="end_date"
                                name="end_date">
                    </div>
                    <div class="form-group col-sm-offset-4 col-sm-2">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-eye"></i>Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê chu kỳ đặc biệt Truyền
                        Thống</h4></div>
                <div class="panel-body">
                    <h4>1.Chu kì gần nhất của các <span class="maudo">số đầu</span> trong 2 số cuối giải đặc biệt</h4>
                    @if($raw && isset($raw['head']))
                        {!! $raw['head'] !!}
                    @endif
                    <h4>2. Chu kì gần nhất của các <span class="maudo">số cuối</span> trong 2 số cuối giải đặc biệt</h4>
                    @if($raw && isset($raw['foot']))
                        {!! $raw['foot'] !!}
                    @endif
                    <h4>3. Chu kì gần nhất của các <span class="maudo">tổng</span> của 2 số cuối giải đặc biệt</h4>
                    @if($raw && isset($raw['total']))
                        {!! $raw['total'] !!}
                    @endif
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
    <script type="text/javascript">

        var Core = {
            openLink : function ($this) {
                value = $($this).text();
                province = $($this).data('province');
                return window.open('{!! route('frontend.result_lottery_via_province',['slug'=> $provinceAlias]) !!}'+'?ngay='+value);
            }
        };

        $(document).ready(function () {
            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '01-01-2001'
            });

            // Link up
            link_selector_dpicker($('form#chuky_form select#code'), $('form#chuky_form input#end_date'));

            // Disable by default
            disable_combine('{!! get_alias_from_slug($provinceAlias) !!}', $('form#chuky_form input#end_date'));

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($date,'d-m-Y') !!}');
        });
    </script>
@endsection