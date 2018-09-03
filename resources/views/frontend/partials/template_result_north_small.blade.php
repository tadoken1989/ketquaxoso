<table class="table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border tb-phoi-border watermark"
       id="result_tab_mb">
    <thead>
    <tr class="title_row">
        <td class="color333" colspan="13">
            <div class="col-sm-10">
                    <span class="pull-left col-sm-5 chu15"
                          id="result_date">{{ parseStringToDate($resultLottery->result_day) }}</span>
                <span class="pull-right col-sm-5  chu15">KTTG: <span id="rs_8_0" rs_len="4"
                                                                                 class="need_blank">{{ $resultLottery->lotteries_db_content }}</span>
                    </span>
            </div>
        </td>
    </tr>
    </thead>
    <tbody>
    <?php $array_date_detail = sortDataResultLottery($resultLottery->resultsDetail->toArray()) ?>
    @if($array_date_detail)
        @foreach($array_date_detail as $key => $detail)
            @if($key != 3 && $key != 5)
                <tr>
                    <td style="width:16%;vertical-align:middle;font-size:16px;@if($key == 0)color:red;@endif">{{ getNameFromPrize($key) }}</td>
                    @foreach($detail as $i => $d)`
                        @php($d['prize_number'] = $d['prize_number']  ? $d['prize_number'] : __('errors.prize-number-null'))
                        <td id="rs_{{ $key }}_{{ $d['order'] }}"
                            colspan="{{col_span()/count($detail)}}"
                            class="chu22 gray need_blank vietdam @if($key == 0){{  ('chu30 maudo') }} @endif stop-reload @if($key == 0)@endif"
                            style="width:{{84/count($detail)}}%;"
                            rs_len="{{ strlen($d['prize_number']) }}">{!! ($d['prize_number']) !!}</td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td rowspan="2"
                        style="width:16%;vertical-align:middle;font-size:16px;">{{ getNameFromPrize($key) }}</td>
                    @foreach($detail as $i => $d)
                        @if($i < 3)
                            @php($d['prize_number'] = $d['prize_number']  ? $d['prize_number'] : __('errors.prize-number-null'))
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="4"
                                class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif"
                                style="width:28%"
                                rs_len="{{ strlen($d['prize_number']) }}">{!! ($d['prize_number']) !!}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach($detail as $i => $d)
                        <td style="display:none"></td>
                        @if($i >= 3)
                            @php($d['prize_number'] = $d['prize_number']  ? $d['prize_number'] : __('errors.prize-number-null'))
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="4"
                                class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif"
                                style="width:28%"
                                rs_len="{{ strlen($d['prize_number']) }}">{!! ($d['prize_number']) !!}</td>
                        @endif
                    @endforeach
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>