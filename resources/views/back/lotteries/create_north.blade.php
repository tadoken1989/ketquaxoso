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
                @component('back.components.box')
                    @slot('type')
                        success
                    @endslot
                    @slot('boxTitle')
                        @lang('Chi tiết giải')
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


                    {{--giải đặc biệt--}}

                    @include('back.partials.input', [
                        'input' => [
                            'name' => 'prize_number[0][0]',
                            'value' => '',
                            'input' => 'text',
                            'title' => __(getNameFromPrize(0)),
                            'required' => true,
                        ],
                    ])

                    {{--giải nhất--}}

                    @include('back.partials.input', [
                      'input' => [
                          'name' => 'prize_number[1][0]',
                          'value' => '',
                          'input' => 'text',
                          'title' => __(getNameFromPrize(1)),
                          'required' => true,
                      ],
                  ])

                    {{--giải nhì--}}

                    @include('back.partials.input', [
                     'input' => [
                         'name' => 'prize_number[2][0]',
                         'value' => '',
                         'input' => 'text',
                         'title' => __(getNameFromPrize(2).' số 1'),
                         'required' => true,
                     ],
                 ])


                    @include('back.partials.input', [
                     'input' => [
                         'name' => 'prize_number[2][1]',
                         'value' => '',
                         'input' => 'text',
                         'title' => __(getNameFromPrize(2) .' số 2'),
                         'required' => true,
                     ],
                 ])

                    {{--giải 3--}}

                    @include('back.partials.input', [
                    'input' => [
                        'name' => 'prize_number[3][0]',
                        'value' => '',
                        'input' => 'text',
                        'title' => __(getNameFromPrize(3) .' số 1'),
                        'required' => true,
                            ],
                        ])
                    @include('back.partials.input', [
                   'input' => [
                       'name' => 'prize_number[3][1]',
                       'value' => '',
                       'input' => 'text',
                       'title' => __(getNameFromPrize(3) .' số 2'),
                       'required' => true,
                           ],
                       ])
                    @include('back.partials.input', [
                  'input' => [
                      'name' => 'prize_number[3][2]',
                      'value' => '',
                      'input' => 'text',
                      'title' => __(getNameFromPrize(3) .' số 3'),
                      'required' => true,
                          ],
                      ])
                    @include('back.partials.input', [
                  'input' => [
                      'name' => 'prize_number[3][3]',
                      'value' => '',
                      'input' => 'text',
                      'title' => __(getNameFromPrize(3) .' số 4'),
                      'required' => true,
                          ],
                      ])
                    @include('back.partials.input', [
                  'input' => [
                      'name' => 'prize_number[3][4]',
                      'value' => '',
                      'input' => 'text',
                      'title' => __(getNameFromPrize(3) .' số 5'),
                      'required' => true,
                          ],
                      ])
                    @include('back.partials.input', [
                  'input' => [
                      'name' => 'prize_number[3][5]',
                      'value' => '',
                      'input' => 'text',
                      'title' => __(getNameFromPrize(3) .' số 6'),
                      'required' => true,
                          ],
                      ])

                    {{--het giai 3--}}

                    {{--giải 4--}}
                    @include('back.partials.input', [
                            'input' => [
                          'name' => 'prize_number[4][0]',
                          'value' => '',
                          'input' => 'text',
                          'title' => __(getNameFromPrize(4) .' số 1'),
                          'required' => true,
                              ],
                          ])
                    @include('back.partials.input', [
                            'input' => [
                          'name' => 'prize_number[4][1]',
                          'value' => '',
                          'input' => 'text',
                          'title' => __(getNameFromPrize(4).' số 2'),
                          'required' => true,
                              ],
                          ])
                    @include('back.partials.input', [
                            'input' => [
                          'name' => 'prize_number[4][2]',
                          'value' => '',
                          'input' => 'text',
                          'title' => __(getNameFromPrize(4).' số 3'),
                          'required' => true,
                              ],
                          ])
                    @include('back.partials.input', [
                            'input' => [
                          'name' => 'prize_number[4][3]',
                          'value' => '',
                          'input' => 'text',
                          'title' => __(getNameFromPrize(4).' số 4'),
                          'required' => true,
                              ],
                          ])
                    {{--het giải 4--}}

                    {{--giải 5--}}
                    @include('back.partials.input', [
                        'input' => [
                      'name' => 'prize_number[5][0]',
                      'value' => '',
                      'input' => 'text',
                      'title' => __(getNameFromPrize(5) .' số 1'),
                      'required' => true,
                          ],
                      ])
                    @include('back.partials.input', [
                      'input' => [
                    'name' => 'prize_number[5][1]',
                    'value' => '',
                    'input' => 'text',
                    'title' => __(getNameFromPrize(5) .' số 2'),
                    'required' => true,
                        ],
                    ])
                    @include('back.partials.input', [
                      'input' => [
                    'name' => 'prize_number[5][2]',
                    'value' => '',
                    'input' => 'text',
                    'title' => __(getNameFromPrize(5) .' số 3'),
                    'required' => true,
                        ],
                    ])

                    @include('back.partials.input', [
                      'input' => [
                    'name' => 'prize_number[5][3]',
                    'value' => '',
                    'input' => 'text',
                    'title' => __(getNameFromPrize(5) .' số 4'),
                    'required' => true,
                        ],
                    ])

                    @include('back.partials.input', [
                      'input' => [
                    'name' => 'prize_number[5][4]',
                    'value' => '',
                    'input' => 'text',
                    'title' => __(getNameFromPrize(5) .' số 5'),
                    'required' => true,
                        ],
                    ])


                    @include('back.partials.input', [
                      'input' => [
                    'name' => 'prize_number[5][5]',
                    'value' => '',
                    'input' => 'text',
                    'title' => __(getNameFromPrize(5) .' số 6'),
                    'required' => true,
                        ],
                    ])




                    {{--giải 6--}}

                    @include('back.partials.input', [
                          'input' => [
                        'name' => 'prize_number[6][0]',
                        'value' => '',
                        'input' => 'text',
                        'title' => __(getNameFromPrize(6).' số 1'),
                        'required' => true,
                            ],
                        ])

                    @include('back.partials.input', [
                         'input' => [
                       'name' => 'prize_number[6][1]',
                       'value' => '',
                       'input' => 'text',
                       'title' => __(getNameFromPrize(6).' số 2'),
                       'required' => true,
                           ],
                       ])

                    @include('back.partials.input', [
                         'input' => [
                       'name' => 'prize_number[6][2]',
                       'value' => '',
                       'input' => 'text',
                       'title' => __(getNameFromPrize(6).' số 3'),
                       'required' => true,
                           ],
                       ])

                    {{--het giai 6--}}

                    {{--giai 7--}}

                    @include('back.partials.input', [
                           'input' => [
                         'name' => 'prize_number[7][0]',
                         'value' => '',
                         'input' => 'text',
                         'title' => __(getNameFromPrize(7).'  số 1'),
                         'required' => true,
                             ],
                         ])
                    @include('back.partials.input', [
                          'input' => [
                        'name' => 'prize_number[7][1]',
                        'value' => '',
                        'input' => 'text',
                        'title' => __(getNameFromPrize(7).'  số 2'),
                        'required' => true,
                            ],
                        ])
                    @include('back.partials.input', [
                          'input' => [
                        'name' => 'prize_number[7][2]',
                        'value' => '',
                        'input' => 'text',
                        'title' => __(getNameFromPrize(7).'  số 3'),
                        'required' => true,
                            ],
                        ])
                    @include('back.partials.input', [
                          'input' => [
                        'name' => 'prize_number[7][3]',
                        'value' => '',
                        'input' => 'text',
                        'title' => __(getNameFromPrize(7) .'  số 4'),
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
                           'options' => [
                               '46' => 'Truyền Thống'
                           ],
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
