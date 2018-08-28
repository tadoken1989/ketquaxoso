@extends('frontend.layouts.app')
@section('css')
    <style type="text/css">
        .watermark {
            background-position: center;
            background-repeat: no-repeat;
            background-size: 350px;
            background-image: url(http://img.ketqua.net/images/2017/08/02/594480f2bf8fb2960100d9d8bdfcd12e.png);
        }

        .big-container {
            width: 1400px !important;
        }

        .color333 {
            color: #333 !important
        }

        .tb-phoi {
            width: 24%;
            float: left;
            margin: 0px 6px 12px 7px;
        }

        .tb-phoi-border {
            border: 1px solid #eee !important;
        }

        .tb-phoi-4 {
            display: none
        }

        .tb-phoi-6 {
            width: 100%
        }

        .phoi-size {
            font-size: 18px !important;
            padding: 5px !important
        }
    </style>
@endsection
@section('content')
    <div class="col-sm-10">
        <div class="kqbackground viento">
            <script src="{{asset('/frontend/js/bootstrap-datepicker.vi.min.js')}}" type=""></script>
            <link href="{{asset('/frontend/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
            <script src="{{asset('/frontend/js/jquery.bootstrap-touchspin.min.js')}}" type=""></script>
            <div class="panel panel-default">
                <div class="panel-heading center">
                    <h4 class="right-menu-title">Tạo phôi kết quả xổ số truyền thống</h4>
                </div>
                <div class="panel-body" style="padding-left: 100px !important;">
                    <form method="POST">
                        {{ csrf_field() }}
                        <div class="form-group col-sm-3">
                            <label for="date">Biên độ ngày</label>
                            <input type="text" class="form-control" id="date" value="{{ parseDate($date,'d-m-Y') }}" name="date">
                        </div>
                        <div class="form-group col-sm-3">
                            <label for="count">Số ngày <span class="vietthuong">(max= 40 ngày)</span></label>
                            <div class="input-group bootstrap-touchspin">
                                <span class="input-group-addon bootstrap-touchspin-prefix">
                                </span>
                                <input type="text" id="count" class="form-control" name="count" value="{{ $count }}">
                            </div>
                        </div>
                        <div class="form-group col-sm-3" style="padding:24px 0 0 100px">
                            <button type="submit" class="btn btn-primary">Tạo phôi truyền thống</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading center"><h4 class="right-menu-title">Tạo phôi kết quả - Tổng hợp kết quả xổsố, tra cứu kqxs</h4></div>
                <div class="panel-body">
                    @foreach($data as $resultLottery)
                    <div class="kqbackground vien tb-phoi">
                        <div id="outer_result_mb">
                            <div class="result_div " id="result_mb">
                                <div class="row">
                                    <div class="col-sm-6 tb-phoi-6">
                                        <div class="color333">
                                            @include('frontend.partials.template_result_north_small',['resultLottery'=>$resultLottery,'province'=>$resultLottery->province])
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endsection
        @section('extra-js')
            <script type="text/javascript">

                $(document).ready(function () {
                    $('#date').datepicker({
                        autoclose: true,
                        language: 'vi',
                        format: 'd-m-yyyy', // Mysql date format
                        endDate: new Date(),
                        todayBtn: 'linked',
                        todayHighLight: true,
                        startDate: '-4y'
                    });

                    // Set the curerent last day
                    $('#date').datepicker('update', '{!! parseDate($date,'d-m-Y') !!}');

                    $('#count').TouchSpin({
                        min: 1,
                        max: 40,
                        step: 1,
                        postfix: ' ngày'
                    });
                });
            </script>
@endsection