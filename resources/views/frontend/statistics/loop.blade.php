@extends('frontend.layouts.index')
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Thống kê chu kỳ</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Thống kê có biết ngày xuất hiện gần nhất và chu kì không xuất hiện
                            dàinhất của các bộ số bạn chọn.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Thống kê chu kỳ dài nhất bộ số không ra</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('frontend.statistics.loop.search') }}" id="chuky_form"
                      method="POST">
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
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary daudong"><i class="fa fa-arrow-right"></i> Chọn
                                tỉnh
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="numbers" class="col-sm-2 control-label">Bộ số</label>
                        <div class="col-sm-7">
                            <textarea class="form-control" rows="2" id="numbers" name="numbers"
                                      placeholder="Điền các bộ số bạn muốn xem (ngăn cách bằng dấu phẩy). Để trống để xem mọi bộ số">{{ $numbers }}</textarea>
                        </div>
                    </div>
                    <p class="chu15 daudong vietnghieng"><span class="maudo"> Hướng dẫn</span>:
                        B1 - Chọn tỉnh. =&gt; B2 - Chọn nhanh bộ số muốn xem (<span class="maudo">KHÔNG</span> cần bấm
                        Enter). Bấm TRỢ GIÚP để xem thêm hướng dẫn.</p>
                </form>
            </div>
        </div>
        <div class="kqbackground vien">
            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Thống kê chu kỳ Truyền Thống, tần suất
                        xổsố, loto miền bắc, truyền thống, miền nam - KetQua.net</h4></div>
                <div class="panel-body">
                    <table class="table-kq-bold-border kqbackground table table-condensed table-bordered qtk-hover">
                        <thead>
                        <tr class="info dosam">
                            <th class="center">Bộ số</th>
                            <th class="center">Chu kỳ dài nhất không về</th>
                            <th class="center">Khoảng thời gian của chu kỳ</th>
                            <th class="center">Ngày xuất hiện gần đây nhất</th>
                        </tr>
                        </thead>
                        <tbody class="center">
                        @if(isset($data) && count($data) > 0)
                            <?php   $i = 0; ?>
                            @foreach($data as $key => $item)
                                <tr id="{{ $i }}">
                                    <td><b>{{ $key }}</b></td>
                                    <td> {{ $item['counter']['count'] }}</td>
                                    <td>
                                        từ <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($item['counter']['from'])]) }}" target="_blank">{{ $item['counter']['from'] }}</a> đến
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>parseDate($item['counter']['to'])]) }}" target="_blank">{{ $item['counter']['to'] }}</a></td>
                                    <td>
                                        <a href="{{ route('frontend.result_lottery_via_province',['slug'=> $provinceAlias,'ngay'=>$item['latest']['day']]) }}"
                                           target="_blank">{{ parseDate($item['latest']['day'],'d-m-Y') }}</a> -
                                        ({{ countDateDiff(parseDate($item['latest']['day'])) }} ngày trước)
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            @endforeach
                        @endif
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
    <script type="text/javascript">
        function parse_numbers_string(numbers_string) {
            numbers = numbers_string.split(',');
            select_num = [];
            for (i = 0; i < numbers.length; i++) {
                cur_number = numbers[i].trim();
                if (cur_number.length == 0)
                    continue;
                if (isNaN(cur_number))
                    continue;
                number_val = parseInt(cur_number) % 100;
                if (number_val < 0 || number_val > 99)
                    continue;
                if (select_num.indexOf(number_val))
                    select_num.push(number_val);
            }
            fade_period = 500;
            if (select_num.length == 0) {
                $('tr').fadeIn(fade_period);
                return;
            }
            for (i = 0; i < 100; i++) {
                select_string = 'tr#' + i;
                if (select_num.indexOf(i) == -1)
                    $(select_string).fadeOut(fade_period); else $(select_string).fadeIn(fade_period);
            }
            return;
        }

        $(document).ready(function () {
            parse_numbers_string($('#numbers').val());
            $('#numbers').keyup(function () {
                parse_numbers_string($('#numbers').val());
            });
        });
    </script>
@endsection