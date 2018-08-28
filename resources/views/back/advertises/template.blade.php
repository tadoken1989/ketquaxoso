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
            @if (session('advertises-ok'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('advertises-ok') !!}
                @endcomponent
            @endif
            @include('back.partials.boxinput', [
                'box' => [
                    'type' => 'box-primary',
                    'title' => __('Name'),
                ],
                'input' => [
                    'name' => 'name',
                    'value' => isset($adv) ? $adv->name : '',
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
                       'value' => isset($adv) ? $adv->url : '',
                       'input' => 'text',
                       'required' => true,
                   ],
               ])
            @include('back.partials.boxinput', [
              'box' => [
                  'type' => 'box-primary',
                  'title' => __('Sắp xếp'),
              ],
              'input' => [
                  'name' => 'sort_by',
                  'value' => isset($adv) ? $adv->sort_by : '',
                  'input' => 'number',
                  'required' => true,
              ],
          ])
            @include('back.partials.boxinput', [
          'box' => [
              'type' => 'box-primary',
              'title' => __('Height'),
          ],
          'input' => [
              'name' => 'height',
              'value' => isset($adv) ? $adv->height : '',
              'input' => 'number',
              'required' => false,
          ],
      ])
            @include('back.partials.boxinput', [
          'box' => [
              'type' => 'box-primary',
              'title' => __('Width'),
          ],
          'input' => [
              'name' => 'width',
              'value' => isset($adv) ? $adv->width : '',
              'input' => 'number',
              'required' => false,
          ],
      ])
            @include('back.partials.boxinput', [
                 'box' => [
                     'type' => 'box-primary',
                     'title' => __('Information'),
                 ],
                 'input' => [
                     'name' => 'information',
                     'value' => isset($adv) ? $adv->information : '',
                     'input' => 'textarea',
                     'rows' => 3,
                     'required' => true,
                 ],
             ])
            <button type="submit" class="btn btn-primary">@lang('Submit')</button>
        </div>

        <div class="col-md-4">
            @component('back.components.box')
                @slot('type')
                    warning
                @endslot
                @slot('boxTitle')
                    @lang('Position')
                @endslot
                <select title="position_to_advertise" class="form-control" id="position_to_advertise"
                        name="position_to_advertise">
                    @foreach($positions as $position)
                        @if(isset($adv) && trim($adv->position_to_advertise) == trim($position))
                            <option value="{{ $position }}" selected> {{ $position }}</option>
                        @else
                            <option value="{{ $position }}"> {{ $position }}</option>
                        @endif
                    @endforeach
                </select>
            @endcomponent
            @component('back.components.box')
                @slot('type')
                    primary
                @endslot
                @slot('boxTitle')
                    @lang('Image')
                @endslot
                <img id="img" src="@isset($adv) {{ $adv->image }} @endisset" alt="" class="img-responsive">
                @slot('footer')
                    <div class="{{ $errors->has('image') ? 'has-error' : '' }}">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <a href="" class="popup_selector btn btn-primary"
                                   data-inputid="image">@lang('Select an image')</a>
                            </div>
                            <!-- /btn-group -->
                            <input class="form-control" type="text" id="image" name="image"
                                   value="{{ old('image', isset($adv) ? $adv->image : '') }}">
                        </div>
                        {!! $errors->first('image', '<span class="help-block">:message</span>') !!}
                    </div>
                @endslot
            @endcomponent
            @component('back.components.box')
                @slot('type')
                    success
                @endslot
                @slot('boxTitle')
                    @lang('Status')
                @endslot
                @include('back.partials.input', [
                    'input' => [
                        'name' => 'status',
                        'value' => isset($adv) ? $adv->status : false,
                        'input' => 'checkbox',
                        'title' => __('Status'),
                        'label' => __('Status'),
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
    <script>

        CKEDITOR.replace('information', {customConfig: '/adminlte/js/ckeditor.js'})

        $('.popup_selector').click(function (event) {
            event.preventDefault()
            var updateID = $(this).attr('data-inputid')
            var elfinderUrl = '/elfinder/popup/'
            var triggerUrl = elfinderUrl + updateID
            $.colorbox({
                href: triggerUrl,
                fastIframe: true,
                iframe: true,
                width: '70%',
                height: '70%'
            })
        })

        function processSelectedFile(filePath, requestingField) {
            $('#' + requestingField).val('\\' + filePath)
            $('#img').attr('src', '\\' + filePath)
        }

    </script>

@endsection
