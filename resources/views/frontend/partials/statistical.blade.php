<div class="kqbackground vien">
    <div class="kqbackground">
        <p style="text-align:center;color: #990000"><span
                    style="font-size:21px;">Thống kê nhanh {{ $name }}</span><br><a
                    href="javascript:;">xem chi tiết &gt;&gt;</a></p>
        <p class="kqbackground text-center" style="margin-top:-10px;"> Thống kê dưới đây tính đến trước giờ kết quả
            ngày: {{ date('d-m-Y') }}
        </p>
    </div>
    <table class="table table-condensed kqcenter table14force background-border table-kq-hover">
        <thead>
        <tr class="info">
            <td colspan="12"
                class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border">
                <b>12 bộ số xuất hiện <span class="maudo">nhiều</span> nhất trong 40 lần quay gần nhất</b>
            </td>
        </tr>
        </thead>
        <?php $data = statistical_two_number_top($resultLottery->province->id, 41, 'DESC'); ?>
        <tbody>
        @if($data && $data['count'])
            @foreach(array_chunk($data['count'],6) as $key => $value)
                <tr class="bang_kqnhanh_bold_bottom">
                    @foreach($value as $key => $item)
                        <td class="bang_kqnhanh_bold_left">
                            <b>
                                <?php
                                $prize = array_search($item, $data['value']);
                                unset($data['value'][$prize])
                                ?>
                                {{ $prize }}
                            </b>
                        </td>
                        <td>{{ $item }} lần</td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <table class="table table-condensed kqcenter table14force background-border">
        <thead>
        <tr class="info">
            <td colspan="12"
                class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border">
                <b>12 bộ số xuất hiện <span class="maudo">ít</span> nhất trong 40 lần quay gần nhất</b>
            </td>
        </tr>
        </thead>
        <?php $data = statistical_two_number_top($resultLottery->province->id, 41, 'ASC'); ?>
        <tbody>
        @if($data && $data['count'])
            @foreach(array_chunk($data['count'],6) as $key => $value)
                <tr class="bang_kqnhanh_bold_bottom">
                    @foreach($value as $key => $item)
                        <td class="bang_kqnhanh_bold_left">
                            <b>
                                <?php
                                $prize = array_search($item, $data['value']);
                                unset($data['value'][$prize])
                                ?>
                                {{ $prize }}
                            </b>
                        </td>
                        <td>{{ $item }} lần</td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <?php
    $data = get_day_lotto_not_return($resultLottery->province->id);
    ?>
    <table class="table table-condensed kqcenter table14force background-border">
        <thead>
        <tr class="info">
            <td class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border"
                colspan="12"><b>Những bộ số không ra từ 10 ngày trở lên (<span class="maudo">Lô khan</span>)</b>
            </td>
        </tr>
        </thead>
        <tbody>
        @if($data && $data['count'])
            @foreach(array_chunk($data['count'],6) as $key => $value)
                <tr class="bang_kqnhanh_bold_bottom">
                    @foreach($value as $key => $item)
                        @if( (countDateDiff(parseDate($item)) > 10))
                            <td class="bang_kqnhanh_bold_left">
                                <b>
                                    <?php
                                    $prize_number = array_search($item, $data['value']);
                                    unset($data['value'][$prize_number])
                                    ?>
                                    {{ $prize_number }}
                                </b>
                            </td>
                            <td class="bang_kqnhanh_bold_right">{{ countDateDiff(parseDate($item)) - 1 }} ngày</td>
                       @endif
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    {{--<table class="table table-condensed kqcenter table14force background-border">--}}
    {{--<thead>--}}
    {{--<tr class="info">--}}
    {{--<td class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border"--}}
    {{--colspan="12"><b>Những bộ số xuất hiện liên tiếp (<span class="maudo">Lô rơi</span>)</b></td>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--<tr class="bang_kqnhanh_bold_bottom">--}}
    {{--<td class="bang_kqnhanh_bold_left"><b>82</b></td>--}}
    {{--<td>4 ngày</td>--}}
    {{--<td class="bang_kqnhanh_bold_left"><b>00</b></td>--}}
    {{--<td>2 ngày</td>--}}
    {{--<td class="bang_kqnhanh_bold_left"><b>06</b></td>--}}
    {{--<td>2 ngày</td>--}}
    {{--<td class="bang_kqnhanh_bold_left"><b>61</b></td>--}}
    {{--<td>2 ngày</td>--}}
    {{--<td class="bang_kqnhanh_bold_left"><b>96</b></td>--}}
    {{--<td>2 ngày</td>--}}
    {{--<td class="bang_kqnhanh_bold_left"></td>--}}
    {{--<td class="bang_kqnhanh_bold_right"></td>--}}
    {{--</tr>--}}
    {{--</tbody>--}}
    {{--</table>--}}
    <?php $list_heads = get_bingo_head($resultLottery->province->id) ?>
    <table class="table table-condensed kqcenter table14force background-border">
        <thead>
        <tr class="info">
            <td class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border"
                colspan="10"><b>Thống kê theo <span class="maudo">đầu</span> số</b></td>
        </tr>
        </thead>
        <tbody>
        @if($list_heads)
            <?php $i = -1 ?>
            @foreach(array_chunk($list_heads,5) as $key => $value)
                <tr>
                    @foreach($value as $index => $item)
                        <?php $i ++ ?>
                        <td class="bang_kqnhanh_bold_left"><b>Đầu {{ $i }}</b></td>
                    <td>{{ $item }} lần</td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    <?php $list_ends = get_bingo_end($resultLottery->province->id) ?>
    <table class="table table-condensed kqcenter table14force background-border">
        <thead>
        <tr class="info">
            <td class="bang_kqnhanh_bold_right bang_kqnhanh_bold_left bang_kqnhanh_bold_bottom bang_kqnhanh_bold_top border"
                colspan="10"><b>Thống kê theo <span class="maudo">đuôi</span> số</b></td>
        </tr>
        </thead>
        <tbody>
        @if($list_ends)
            <?php $i = -1 ?>
            @foreach(array_chunk($list_ends,5) as $key => $value)
                <tr>
                    @foreach($value as $index => $item)
                        <?php $i ++ ?>
                        <td class="bang_kqnhanh_bold_left"><b>Đuôi {{ $i }}</b></td>
                        <td>{{ $item }} lần</td>
                    @endforeach
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>