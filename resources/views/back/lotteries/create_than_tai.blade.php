@extends('back.layout')

@section('css')
    <style>
        textarea {
            resize: vertical;
        }
    </style>
    <link href="{{ asset('adminlte/plugins/colorbox/colorbox.css') }}" rel="stylesheet">
@endsection
@section('main')
    <form method="post" action="{{ route('admin.lotteries.store') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-8">
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
                @component('back.components.box')
                    @slot('type')
                        success
                    @endslot
                    @slot('boxTitle')
                        @lang('Chi tiết giải THẦN TÀI')
                    @endslot
                    @include('back.partials.input', [
                        'input' => [
                            'name' => 'status',
                            'value' => isset($resultLottery) ? $resultLottery->status : false,
                            'input' => 'checkbox',
                            'title' => __('Status'),
                            'label' => __('Active'),
                        ],
                    ])


                    {{--giải nhất--}}

                    @include('back.partials.input', [
                      'input' => [
                          'name' => 'prize_number[1][0]',
                          'value' => '',
                          'input' => 'text',
                          'title' => "Số Trúng Giải",
                          'required' => true,
                      ],
                  ])
                    {{--hết giải --}}

                @endcomponent
                <button type="submit" class="btn btn-primary">@lang('Submit')</button>
            </div>
            <div class="col-md-4">
                @component('back.components.box')
                    @slot('type')
                        warning
                    @endslot
                    @slot('boxTitle')
                        @lang('Thông tin mở giải')
                    @endslot
                    @include('back.partials.input', [
                       'input' => [
                           'name' => 'province',
                           'values' => isset($resultLottery) ? $resultLottery->province : collect(),
                           'input' => 'select',
                           'options' => $provinces,
                       ],
                   ])
                @endcomponent

                @component('back.components.box')
                    @slot('type')
                        warning
                    @endslot
                    @slot('boxTitle')
                        Ngày mở giải
                    @endslot
                    @include('back.partials.input', [
                       'input' => [
                           'name' => 'result_day',
                           'value' => isset($resultLottery) ? $resultLottery->result_day : '',
                           'input' => 'text',
                           'required' => true,
                       ],
                   ])
                @endcomponent
            </div>
        </div>
        <!-- /.row -->
    </form>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#result_day').datepicker({
                autoclose: true,
                language: 'vi',
                format: 'dd-mm-yyyy', // site_date_format
                weekStart: 1,
                endDate: new Date(),
                todayBtn: 'linked',
                todayHighLight: true,
                startDate: '-16y'
            });
        });
    </script>
    <script src="{{ asset('adminlte/plugins/colorbox/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/voca/voca.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

@endsection
