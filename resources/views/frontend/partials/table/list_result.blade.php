<link href="{{asset('/frontend/css/03.css')}}" rel="stylesheet">
<table class="table table-condensed table-bordered table-kq-hover kqcenter kqbackground table-kq-bold-border"
       style="text-align:center;" id="region_table">
    <thead>
    <tr>
        <td class="dosam chu16" colspan="{{ count($resultLottery) + 1 }}">
            <p class="kqcenter viethoa dosam vietdam chu17">
                <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print "
                        onclick="return $('#region_table').printThis({loadCSS: '/frontend/css/print_style.css', title:'Xổ số {{ $region->name }}'});">
                    <span class="lyphicon glyphicon glyphicon-print"></span></button>
                Xổ số {{ $region->name }}
                <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print "
                        onclick="return notification_switch();"><i
                            class="fa fa-volume-up notification_switch rolling-finished" style="color:black;"></i>
                </button>
            </p>
            {{ parseStringToDate($date) }}
        </td>
    </tr>
    <?php $data = parseDataDetailResultLottery($resultLottery->toArray()) ?>
    <tr class="info chu14 viethoa">
        <td>Tỉnh</td>
        @foreach($resultLottery as $d => $detail)
            <td>{{ $detail->province->name }}</td>
        @endforeach
    </tr>
    </thead>
    <tbody>
    {{--foreach via total prize [0->8]--}}
    @foreach($data as $key => $detail)
        @foreach($detail as $index => $value)
            <tr>
                @if($index == 0)
                    <td rowspan="{{ count($detail) }}"
                        class="@if($key%2 != 0) {{ ('darkbg') }} @endif kqcenter">{{ getNameFromPrize($key) }}</td>
                @endif
                @foreach($value as $i => $d)
                    @if($i%2 == 0)
                        <td id="kt_{{ $key }}_{{ $d['order'] }}"
                            class="@if($key%2 != 0) {{ ('darkbg') }} @endif chu19 vietdam @if($key == 0 || $key == 8){{  ('maudo stop-reload') }} @endif"
                            rs_len="{{ strlen($d['prize_number']) }}"> {{$d['prize_number']}}
                        </td>
                    @else
                        <td id="ks_{{ $key }}_{{ $d['order'] }}"
                            class="@if($key%2 != 0) {{ ('darkbg') }} @endif chu19 vietdam @if($key == 0 || $key == 8){{  ('maudo stop-reload') }} @endif"
                            rs_len="{{ strlen($d['prize_number']) }}"> {{$d['prize_number']}}
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>