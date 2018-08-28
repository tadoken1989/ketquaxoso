@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
    <style>
        input, th span {
            cursor: pointer;
        }
    </style>
@endsection

@section('button')
    <a class="btn btn-primary" href="{{ route('notify.create') }}">@lang('New notify')</a>
@endsection

@section('main')

    <div class="row">
        <div class="col-md-12">
            @if (session('notify-ok'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('notify-ok') !!}
                @endcomponent
            @endif
            <div class="box">
                <div class="box-header with-border">
                    <div id="spinner" class="text-center"></div>
                </div>
                <div class="box-body table-responsive">
                    <table id="users" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Title')</th>
                            <th>@lang('Url')</th>
                            <th>@lang('Status')</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="pannel">
                            @include('back.notify.table', compact('notify'))
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

@endsection

@section('js')
    <script src="{{ asset('adminlte/js/back.js') }}"></script>
    <script>

        var notify = (function () {

            var onReady = function () {
                $('#pannel').on('click', 'td a.btn-danger', function (event) {
                    var that = $(this)
                    event.preventDefault()
                    swal({
                        title: '@lang('Really destroy notify ?')',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: '@lang('Yes')',
                        cancelButtonText: '@lang('No')'
                    }).then(function () {
                        back.spin()
                        $.ajax({
                            url: that.attr('href'),
                            type: 'DELETE'
                        })
                            .done(function () {
                                that.parents('tr').remove()
                                back.unSpin()
                            })
                            .fail(function () {
                                back.fail('@lang('Looks like there is a server issue...')')
                            }
                        )
                    })
                })
            }

            return {
                onReady: onReady
            }

        })()

        $(document).ready(notify.onReady)

    </script>
@endsection