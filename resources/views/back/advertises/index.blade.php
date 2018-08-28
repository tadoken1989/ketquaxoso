@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
@endsection

@section('button')
    <a href="{{ route('admin.advertises.create') }}" class="btn btn-primary">@lang('New Advertise')</a>
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Url')</th>
                            <th>@lang('Position')</th>
                            <th>@lang('Sort')</th>
                            <th>@lang('Image')</th>
                            <th>@lang('Width')</th>
                            <th>@lang('Height')</th>
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
                        "url": "{!! route('admin.advertises.data') !!}",
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
                        {data: 'name', name: 'name'},
                        {data: 'url', name: 'url'},
                        {data: 'position_to_advertise', name: 'position_to_advertise'},
                        {data: 'sort_by', name: 'sort_by'},
                        {data: 'width', name: 'width'},
                        {data: 'height', name: 'height'},
                        {data: 'images', name: 'images'},
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
