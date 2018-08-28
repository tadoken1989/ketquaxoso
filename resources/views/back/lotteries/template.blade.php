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

    @yield('form-open')
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8">
            @if (session('ok'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('lotteries-ok') !!}
                @endcomponent
            @endif
            @if($resultLottery->province->region_id == 2 && $resultLottery->type == 'normal')
                @include('back.partials.boxinput', [
                    'box' => [
                        'type' => 'box-primary',
                        'title' => __('KTTG'),
                    ],
                    'input' => [
                        'name' => 'lotteries_db_content',
                        'value' => isset($resultLottery) ? $resultLottery->lotteries_db_content : '',
                        'input' => 'text',
                        'required' => true,
                    ],
                ])
            @endif
            @component('back.components.box')
                @slot('type')
                    success
                @endslot
                @slot('boxTitle')
                    @lang('Chi tiết giải')
                @endslot
                @foreach($resultLottery->resultsDetail as $detail)
                    @include('back.partials.input', [
                        'input' => [
                            'name' => 'prize_number['.$detail->prize.']['.$detail->order.']',
                            'value' => isset($detail) ? $detail->prize_number : '',
                            'input' => 'text',
                            'title' => __(getNameFromPrize($detail->prize)),
                            'required' => true,
                        ],
                    ])
                @endforeach
                @include('back.partials.input', [
                    'input' => [
                        'name' => 'status',
                        'value' => isset($detail) ? $detail->status : false,
                        'input' => 'checkbox',
                        'title' => __('Status'),
                        'label' => __('Active'),
                    ],
                ])
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
                        'value' => isset($resultLottery) ? $resultLottery->province->name : '',
                        'input' => 'text',
                        'required' => true,
                        'disabled'=>'disabled'
                    ],
                ])
                @include('back.partials.input', [
                   'input' => [
                       'name' => 'result_day',
                       'value' => isset($resultLottery) ? $resultLottery->result_day : '',
                       'input' => 'text',
                       'required' => true,
                       'disabled'=>'disabled'
                   ],
               ])
            @endcomponent
        </div>
    </div>
    <!-- /.row -->
    </form>

@endsection

@section('js')

    <script src="{{ asset('adminlte/plugins/colorbox/jquery.colorbox-min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/voca/voca.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

@endsection