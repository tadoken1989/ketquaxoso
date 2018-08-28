<table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
       id="result_tab_{{ $resultLottery->province->alias }}" style="text-align:center;">
    <thead>
    <tr class="title_row">
        <td colspan="13" class="dosam chu18">
            <h2 class="martop10 chu22 kqcenter viethoa dosam vietdam"><a href="javascript:;" target="_blank">
                    <button class="btn btn-lg button-noborder col-sm-2 pull-left hidden-print">
                        <span class="lyphicon glyphicon glyphicon-print" onclick="return $('#region_table').printThis({loadCSS: 'http://static.ketqua.net/custom_css/print_style.css', title:'{!! $resultLottery->province->name !!}'});"></span></button>
                </a>Xổ số {{$resultLottery->province->name}}
                <button class="btn btn-lg button-noborder col-sm-2 pull-right hidden-print " onclick="return notification_switch();"><i class="fa fa-volume-up notification_switch rolling-finished"></i>
                </button>
            </h2>
            <span id="result_date">{{ parseStringToDate($resultLottery->result_day) }}</span>
        </td>
    </tr>
    </thead>
    <tbody>
    <?php $array_date_detail = sortDataResultLottery($resultLottery->resultsDetail->toArray()) ?>
    @if($array_date_detail)
        @foreach($array_date_detail as $key => $detail)
            @if($key != 4)
                <tr>
                    <td style="width:16%;vertical-align:middle;font-size:16px;@if($key == 0)color:red;@endif">{{ getNameFromPrize($key) }}</td>
                    @foreach($detail as $i => $d)
                        <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="{{col_span()/count($detail)}}" class="chu22 gray need_blank vietdam @if($key == 0){{  ('chu30 maudo') }} @endif stop-reload @if($key == 0)@endif" style="width:{{84/count($detail)}}%;" rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}
                        </td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td rowspan="2"
                        style="width:16%;vertical-align:middle;font-size:16px;">{{ getNameFromPrize($key) }}</td>
                    @foreach($detail as $i => $d)
                        @if($i < 4)
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="3" class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif" style="width:21%" rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td style="display:none"></td>
                    @foreach($detail as $i => $d)
                        @if($i >= 4)
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="4" class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif" style="width:28%" rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}</td>
                        @endif
                    @endforeach
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
    <span id="all_res_bdu" hidden></span>
    <span id="reload_link_bdu" hidden>http://ketqua.net/pre_loads/kq-bdu.raw</span>
    <span id="date_bdu" hidden>2018-06-15</span>
</table>
{{--<script type="text/javascript">--}}
    {{--$(document).ready(function(){--}}
        {{--setTimeout(function(){--}}
            {{--// Update name too--}}
            {{--$('#result_tab_bdu span#result_date').html('Thứ Sáu ngày 15-06-2018');--}}
            {{--// Reset all cell--}}
            {{--$('#result_tab_bdu span.need_blank').text('\xa0');--}}
            {{--$('#result_tab_bdu td.need_blank').text('\xa0');--}}
            {{--$('#loto_bdu td.need_blank').text('\xa0');--}}
            {{--$('#dau_bdu td.need_blank').text('\xa0');--}}
            {{--$('#duoi_bdu td.need_blank').text('\xa0');--}}
            {{--// Reload--}}
            {{--reload_result('bdu');--}}
        {{--}, 92000);--}}
    {{--});--}}
{{--</script>--}}
