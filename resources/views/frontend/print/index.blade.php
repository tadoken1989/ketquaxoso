<head>
    <meta charset="UTF-8">
</head>
<body>
<link href="http://static.ketqua.net/custom_css/print_standalone.css" rel="stylesheet">
<img src="http://upload.ketqua.net/upload/2016/03/31/20160331055241-c9a1f47f.png" height="70"
     style="margin-left: 70px; margin-top: 10px;">
<br><br>
<table class="font table table-condensed kqcenter kqvertimarginw table-kq-border table-kq-hover table-kq-north-west table-bordered kqbackground table-kq-bold-border"
       style="max-width:460px; min-width:460px;">
    <thead>
    <tr class="title_row">
        <td colspan="13">
            <h2 class="viethoa printh2 vietdam">Kết quả xổ số Truyền Thống</h2>{{ parseStringToDate($resultLottery->result_day) }}
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
                    @foreach($detail as $i => $d)
                        <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="{{col_span()/count($detail)}}"
                            class="chu22 gray need_blank vietdam @if($key == 0){{  ('chu30 maudo') }} @endif stop-reload @if($key == 0)@endif"
                            style="width:{{84/count($detail)}}%;"
                            rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}</td>
                    @endforeach
                </tr>
            @else
                <tr>
                    <td rowspan="2"
                        style="width:16%;vertical-align:middle;font-size:16px;">{{ getNameFromPrize($key) }}</td>
                    @foreach($detail as $i => $d)
                        @if($i < 3)
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="4"
                                class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif"
                                style="width:28%" rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    @foreach($detail as $i => $d)
                        <td style="display:none"></td>
                        @if($i >= 3)
                            <td id="rs_{{ $key }}_{{ $d['order'] }}" colspan="4"
                                class="chu22 gray need_blank vietdam @if($key == 0){{  ('maudo') }} @endif stop-reload @if($key == 0)@endif"
                                style="width:28%" rs_len="{{ strlen($d['prize_number']) }}">{{($d['prize_number'])}}</td>
                        @endif
                    @endforeach
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>

<p class="font chu18 vietnghieng" style="margin-bottom: 15px;margin-left:5px;"><span class="vietnghieng  vietdam"> {{ env('APP_URL') }}</span>- Diễn đàn, thảo luận, tụ hội anh tài !</p>
<table class="font table table-bordered table-condensed table-kq-north table-kq-border kqcenter table-kq-bold-border kqbackground"
       style="max-width:460px; min-width:460px;">
    <thead>
    <tr>
        <td colspan="9">Lô tô trực tiếp</td>
    </tr>
    </thead>
    <tbody style="font-weight:bold;">
    <?php
    $bingo = $resultLottery->resultsDetail;
    $bingo_sorted = $bingo->sortBy(function($rd) {
        return $rd->getTwoNumberFromPrizeNumber();
    });


    ?>
    @foreach($bingo_sorted->chunk(9) as $row)
        <tr>
            @foreach ($row as $b)
                <td class="chu17 vietdam need_blank @if($b->prize == 0){{  ('maudo') }} @endif">{{ $b->getTwoNumberFromPrizeNumber() }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<table class="dau font table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground"
       style="max-width:250px; min-width:250px;">
    <thead>
    <tr>
        <td style="width:15%;">Đầu</td>
        <td class="kqcenter">Lô tô</td>
    </tr>
    </thead>
    <tbody style="font-weight:bold;">
    @foreach($resultLottery->bingo_head() as $key => $rds)
        <tr>
            <td class="dosam chu15 kqcenter">
                {{$key}}
            </td>
            <td id="begin_with_0" class="chu15 need_blank">
                {!!
                $rds->map(function($item) {
                $b = $item->getTwoNumberFromPrizeNumber();
                if ($item->prize == 0) return "<span class='maudo'>$b</span>";
                return $b;
                })->implode('; ')
                !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<table class="duoi font table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground"
       style="max-width:250px; min-width:250px;">
    <thead>
    <tr>
        <td style="width:15%;">Đuôi</td>
        <td class="kqcenter">Lô tô</td>
    </tr>
    </thead>
    <tbody style="font-weight:bold;">
    @foreach($resultLottery->bingo_duoi() as $key => $rds)
        <tr>
            <td class="dosam chu15 kqcenter">
                {{$key}}
            </td>
            <td id="begin_with_0" class="chu15 need_blank">
                {!!
                $rds->map(function($item) {
                $b = $item->getTwoNumberFromPrizeNumber();
                if ($item->prize == 0) return "<span class='maudo'>$b</span>";
                return $b;
                })->implode('; ')
                !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<p class="font chu18 vietnghieng" style="margin-bottom: 15px;margin-left:70px;"> Chúc quý vị sức khoẻ và may mắn !</p>
</body>
<script type="2d7b71d8a58cdedd509457b8-text/javascript">
window.print();

</script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/2448a7bd/cloudflare-static/rocket-loader.min.js"
        data-cf-nonce="2d7b71d8a58cdedd509457b8-" defer=""></script>
