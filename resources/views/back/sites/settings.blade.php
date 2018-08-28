@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/bootstrap-slider/slider.css') }}">
@endsection

@section('main')
    <div class="row">
        <div class="col-md-12">
            @if ($errors->count())
                @component('back.components.alert')
                    @slot('type')
                        danger
                    @endslot
                    @lang('There is some validation issue...')
                @endcomponent
            @endif
            @if (session('ok'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('ok') !!}
                @endcomponent
            @endif
            <div class="row">
                <div class="col-md-12">

                    <div class="nav-tabs-custom">
                        <ul class="nav nav-pills">
                            @foreach($groups as $index =>$group)
                                <li @if($index == 0) class="active" @endif><a href="#tab_{{ $group->name }}"
                                                                              data-toggle="tab">{{ $group->label }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach($groups as $index => $group)
                                <div class="tab-pane fade @if($index == 0) active in @endif" id="tab_{{$group->name}}">
                                    <form method="post" action="{{ route('sites.update', ['page' => $index])}}">
                                        {{ method_field('PUT') }}
                                        {{ csrf_field() }}
                                        @foreach($group->settings as $setting)
                                            @if($setting->type =='textarea')
                                                @include('back.partials.input', [
                                                   'input' => [
                                                       'name' => $setting->name,
                                                       'value' => isset($setting) ? $setting->value : '',
                                                       'input' => 'text',
                                                       'title' => $setting->label,
                                                       'input' => 'textarea',
                                                       'rows' => 5,
                                                       'required' => false,
                                                   ]
                                               ])
                                            @else
                                                @include('back.partials.input', [
                                                    'input' => [
                                                        'title' => $setting->label,
                                                        'name' => $setting->name,
                                                        'value' => isset($setting->value) ? old($setting->value,$setting->value): '',
                                                        'input' => $setting->type,
                                                        'required' => false,
                                                    ],
                                                ])
                                            @endif
                                        @endforeach
                                        <button class="btn btn-primary" type="submit">@lang('Submit')</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
@endsection