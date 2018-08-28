@extends('frontend.layouts.app')
@section('css')
    <style>
        .big-container {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-10">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thống kê chu kì dàn đặc biệt</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Thống kê chu kì của dàn số đặc biệt các tỉnh. Cho biết ngưỡng cực đại
                            không xuất hiện của các số thuộc dàn trong giải đặc biệt, lần xuất hiện gần nhất trong
                            khoảng ngày bạn chọn, hoặc lần xuất hiện gần đây nhất.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê bảng đặc biệt tháng</h4>
            </div>
            <div class="panel-body">
                <form method="POST" id="main_form">
                    {{ csrf_field() }}
                    <div class="form-group col-sm-3 daudong">
                        <label for="code">Chọn năm</label>
                        <select name="year" id="code" class="form-control">
                            @for($i = 2002;$i<= date('Y');$i ++)ss
                            @if($i == $year)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="code">Chọn tháng</label>
                        <select name="month" id="code" class="form-control">
                            @for($i = 1;$i<= 12;$i ++)ss
                            @if($i == $month)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-2" style="margin-top: 25px; margin-left: 100px">
                        <button type="submit" class="btn btn-primary">Xem kết quả</button>
                    </div>
                </form>
            </div>
            <div class="panel-body scroll">
                <div class="kqbackground vien">
                    <div class="kqbackground">
                        {!! $raw !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table#dacbiettuan td').click(function () {
                $(this).toggleClass('act');
            });
            // Make the last 2 character bold for all maudo
            $('.emphasis2').each(function () {
                $(this).html(
                    $(this).html().substr(0, $(this).html().length - 2)
                    + "<span style='font-size:16px;' class='dosam'>"
                    + $(this).html().substr(-2)
                    + "</span>");
            });
        });

    </script>
@endsection