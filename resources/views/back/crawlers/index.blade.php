@extends('back.layout')

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/sweetalert2/6.3.8/sweetalert2.min.css">
@endsection

@section('main')

    <div class="row">
        <div class="col-md-12">
            @if (session('done'))
                @component('back.components.alert')
                    @slot('type')
                        success
                    @endslot
                    {!! session('done') !!}
                @endcomponent
            @endif
            <form method="post" action="{{ route('admin.crawler.get_by_province') }}">
                {{ csrf_field() }}
                <div class="form-group field-timeRange required">
                    <label class="control-label" for="date">Ngày cần lấy</label>
                    <input type="text" id="date" name="date" class="form-control" required aria-required="true">
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input"
                           onchange="Crawler.changeType(1)">
                    <label class="custom-control-label" for="customRadio1">Theo Miền</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" id="customRadio2" checked name="customRadio" class="custom-control-input"
                           onchange="Crawler.changeType(2)">
                    <label class="custom-control-label" for="customRadio2">Theo Tỉnh</label>
                </div>
                <div class="form-group" id="1">
                    <label for="province">Chọn tỉnh</label>
                    <select class="form-control" name="province" id="province">
                        <option value="0">Vui lòng chọn</option>
                        @if(isset($regions))
                            @foreach($regions as $key => $r)
                                <optgroup label="{{ $r->name }}">
                                    @if(count($r->provinces) > 0)
                                        @foreach($r->provinces as $p)
                                            <option value="{{ $p->id }}">Xổ Số {{ $p->name }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group" id="2" style="display: none">
                    <label for="regions">Chọn miền</label>
                    <select class="form-control" name="regions" id="regions">
                        <option value="0">Vui lòng chọn</option>
                        @if(isset($regions))
                            @foreach($regions as $key => $r)
                                <option value="{{ $r->id }}">Xổ Số {{ $r->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var Crawler = {
            changeType: function (i) {
                if (i === 2) {
                    $('#2').hide();
                    $('#1').show();
                } else if (i === 1) {
                    $('#1').hide();
                    $('#2').show();
                }
            }
        };
        $(document).ready(function () {
            var range = $('#date').datepicker({
                format: 'dd-mm-yyyy',
                maxDate: new Date(),
            });

        })
    </script>
@endsection