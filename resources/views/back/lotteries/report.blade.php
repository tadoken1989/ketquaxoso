@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
@endsection
@section('button')
    <a href="{{ route('admin.lotteries.create',['region_id'=> 2]) }}" class="btn btn-sm btn-primary">@lang('Tạo KQMB')</a>
    <a href="{{ route('admin.lotteries.create',['region_id'=> 3]) }}" class="btn btn-sm btn-primary">@lang('Tạo KQMT')</a>
    <a href="{{ route('admin.lotteries.create',['region_id'=> 1]) }}" class="btn btn-sm btn-primary">@lang('Tạo KQMN')</a>
    <a href="{{ route('admin.lotteries.create',['region_id'=> 2,'type'=>'thantai']) }}" class="btn btn-sm btn-primary">@lang('Tạo KQ THẦN TÀI')</a>
    <a href="{{ route('admin.lotteries.create',['region_id'=> 2,'type'=>'636']) }}" class="btn btn-sm btn-primary">@lang('Tạo 6X36')</a>
    <a href="{{ route('admin.lotteries.create',['region_id'=> 2,'type'=>'123']) }}" class="btn btn-sm btn-primary">@lang('Tạo Điện toán 123')</a>
@endsection
@section('main')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box">
                @if (session('lotteries-ok'))
                    @component('back.components.alert')
                        @slot('type')
                            success
                        @endslot
                        {!! session('lotteries-ok') !!}
                    @endcomponent
                @endif
                @if (session('error'))
                    @component('back.components.alert')
                        @slot('type')
                            error
                        @endslot
                        {!! session('lotteries-error') !!}
                    @endcomponent
                @endif
                <div class="box-body table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Province')</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            @if(env('APP_DEBUG') == false)$.fn.dataTable.ext.errMode = 'none';
                    @endif
            var table = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    pageLength: 50,
                    order: [[0, 'desc']],
                    ajax: {
                        "url": "{!! route('admin.lotteries.data') !!}",
                        "contentType": "application/json",
                        "type": "GET",
                        "data": function (d) {
                            return d;
                        }
                    },
                    language: {
                        "url": "/js_lang/{!! trim(config('app.locale')) !!}.json"
                    },
                    columns: [
                        {data: 'result_day', name: 'result_day'},
                        {data: 'province.name', name: 'province.name'},
                        {data: 'status', name: 'status'},
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                        }
                    ]
                });
            $('#data-table').on('click', '.btn-active', function () {
                var $_this = $(this);
                swal({
                    title: "You are sure ?",
                    text: "You are sure",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yup,action now!",
                    cancelButtonText: "No, cancel it !",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then(function () {
                    if ($_this.data('id')) {
                        $.ajaxSetup({headers: {'X-CSRF-Token': $('input[name="_token"]').val()}});
                        $.ajax({
                            method: "post",
                            url: '/admin/_ajax/_model/active',
                            data: {'id': $_this.data('id'), 'model': $_this.data('model')},
                            beforeSend: function () {
                                swal.close();
                                $('.loading').show();
                            },
                            success: function (res) {
                                $('.loading').fadeOut();
                                if (res.status == 200) {
                                    swal("Success", "Action success", "success");
                                    var $span = $('span#status-' + $_this.data("id"));
                                    if (res.state == 0) {
                                        $span.removeClass('label-success');
                                        $span.addClass('label-warning');
                                        $span.html('<i class="fa fa-check-square-o"></i> lock');
                                        $_this.removeClass('btn-warning');
                                        $_this.addClass('btn-warning');
                                        $_this.html('<i class="fa fa-check-square-o"></i> Active');
                                    } else {
                                        $span.removeClass('label-warning');
                                        $span.addClass('label-success');
                                        $span.html('<i class="fa fa-check"></i> active');
                                        $_this.removeClass('btn-warning');
                                        $_this.addClass('btn-warning');
                                        $_this.html('<i class="fa fa-trash"></i> Lock');
                                    }
                                } else {
                                    swal("Error", "System error", "error");
                                }
                            },
                            error: function () {
                                $('.loading').fadeOut();
                                swal("Error", "System error", "error");

                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
