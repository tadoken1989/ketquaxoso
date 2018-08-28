@extends('frontend.layouts.app')
@section('css')
    <style type="text/css">
        .toggle.ios, .toggle-on.ios, .toggle-off.ios {
            border-radius: 20px;
        }

        .toggle.ios .toggle-handle {
            border-radius: 20px;
        }
    </style>
    <link href="/frontend/css/table-centered.css" rel="stylesheet">
    <link href="frontend/css/caukiemtra.css" rel="stylesheet">
@endsection
@section('content')
    <div class="col-sm-7">
        <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Lịch sử cầu loto</h4>
                    </div>
                    <div class="modal-body">
                        <p class="“text-justify”">Liệt kê số lượng và độ dài cầu loto trong khoảng ngày và vị trí cầu
                            bạn chọn.</p>
                        <p class="“text-justify”">Vị trí được đếm bắt đầu từ giải đặc biêt, mỗi chữa cố đứng với 1 đơn
                            vị</p>
                        <a href=/frontend/images/20160130200746-34ce78b3.png"
                           target="_blank">Xem thêm cách SOI CẦU ?</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
        <link href="{{asset('/frontend/bootstrap/css/bootstrap-toggle.min.css')}}" rel="stylesheet">
        <script src="{{asset('/frontend/bootstrap/js/bootstrap-toggle.min.js')}}" type=""></script>
        <div class="panel panel-default">
            <div class="panel-heading center">
                <h4 class="right-menu-title">Kiểm tra lịch sử cầu loto</h4>
            </div>
            <div class="panel-body">
                <form method="POST">
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
                        <label for="begin_date">Từ ngày</label>
                        <input type="text" class="form-control" value="{{parseDate($begin_date,'d-m-y')}}" id="begin_date" name="begin_date">
                    </div>
                    <div class="form-group col-sm-3 daudong">
                        <label for="end_date">Đến ngày</label>
                        <input type="text" class="form-control" value="{{parseDate($end_date,'d-m-y')}}" id="end_date" name="end_date">
                    </div>
                    <div class="form-group col-sm-2 daudong">
                        <label for="pos_1">Vị trí 1</label>
                        <input type="text" class="form-control" id="pos_1" name="pos_1" placeholder="Vị trí đầu tiên"
                               value="{{ $pos_1 }}">
                    </div>
                    <div class="form-group col-sm-2 daudong">
                        <label for="pos_2">Vị trí 2</label>
                        <input type="text" class="form-control" id="pos_2" name="pos_2" placeholder="Vị trí thứ hai"
                               value="{{ $pos_2 }}">
                    </div>
                    <div class="form-group form-group col-sm-2 daudong">
                        <label for="bt_switch">Bạch thủ</label><br>
                        <input type="checkbox" class="form-control" data-toggle="toggle" data-size="mini"
                               data-onstyle="success" data-style="ios"
                               @if(isset($bach_thu) && $bach_thu == 'on') checked @endif
                               id="bt_switch" name="bach_thu">
                    </div>
                    <div class="form-group col-sm-2" style="margin:25px 0 0 50px;">
                        <button type="submit" class="btn btn-primary">Xem kết quả</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading center"><h4 class="right-menu-title">Lịch sử cầu {{ get_name_from_slug($provinceAlias)  }} vị trí {{ $pos_1 }} và {{ $pos_2 }}</h4>
            </div>
            <div class="panel-body">
                @include('frontend.block.social')
                {!! $raw !!}
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
            openLink: function ($this) {
                value = $($this).text();
                province = $($this).data('province');
                pos_1 = $($this).data('pos_1');
                pos_2 = $($this).data('pos_2');
                begin_date = $($this).parent('td').parent('tr').find('td:nth-child(2)').text();
                end_date = $($this).parent('td').parent('tr').find('td:nth-child(3)').text();
                code = $($this).data('code');
                if (value == 'Xem chi tiết') {
                    return window.open('{!! route('frontend.inspired.view_province_cau_details') !!}' + '?province_alias=' + province.trim() +'&begin_date='+begin_date+'&end_date='+end_date+'&pos_1='+pos_1+'&pos_2='+pos_2,'_bank');
                } else {
                    return window.open('{!! route('frontend.result_lottery_via_province',['slug'=> $provinceAlias]) !!}' + '?ngay=' + value);
                }
            }
        };
        $(document).ready(function () {
            $('#begin_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-20y'
            });

            // Set the curerent begin day
            $('#begin_date').datepicker('update', '{!! parseDate($begin_date,'d-m-Y') !!}');

            $('#end_date').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'd-m-yyyy', // Site date format
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-20y'
            });

            // Set the curerent last day
            $('#end_date').datepicker('update', '{!! parseDate($end_date,'d-m-Y') !!}');

            // Toggle the class and the text of button on switching
            $('button.danhsachtoggle').click(function () {
                $(this).toggleClass('btn-danger');
                if ($(this).hasClass('btn-danger'))
                    $(this).text('Ẩn danh sách');
                else
                    $(this).text('Xem danh sách');

                return true;
            });

        });
    </script>
@endsection