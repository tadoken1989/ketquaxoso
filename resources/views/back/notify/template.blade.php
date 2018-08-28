@extends('back.layout')

@section('main')

    @yield('form-open')
    {{ csrf_field() }}

    <div class="row">

        <div class="col-md-12">
            @include('back.partials.boxinput', [
                'box' => [
                    'type' => 'box-primary',
                    'title' => __('Content'),
                ],
                'input' => [
                    'name' => 'content',
                    'value' => isset($notify) ? $notify->content : '',
                    'input' => 'text',
                    'required' => true,
                ],
            ])
            @include('back.partials.boxinput', [
                'box' => [
                    'type' => 'box-primary',
                    'title' => __('Url'),
                ],
                'input' => [
                    'name' => 'url',
                    'value' => isset($notify) ? $notify->url : '',
                    'input' => 'url',
                    'required' => true,
                ],
            ])
            @include('back.partials.input', [
                    'input' => [
                        'name' => 'status',
                        'value' => isset($notify) ? $notify->status : false,
                        'input' => 'checkbox',
                        'title' => __('Status'),
                        'label' => __('Active'),
                    ],
                ])
            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
        </div>

    </div>
    <!-- /.row -->
    </form>

@endsection
