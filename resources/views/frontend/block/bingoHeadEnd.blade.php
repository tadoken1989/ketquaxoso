<div class="row" style="margin-bottom: -19px; margin-top: 10px;">
    <div class="col-xs-5">
        <table class="table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground table-kq-hover" style="margin-left: 3px;" id="dau_mb">
            <thead>
            <tr>
                <td style="width:16%;">Đầu</td>
                <td class="bang_kqnhanh_bold_bottomw">Lô tô</td>
            </tr>
            </thead>
            <tbody style="font-weight:bold;">
            @foreach($resultLottery->loadByHead() as $key => $rds)
                <tr>
                    <td class="dosam chu15 kqcenter">
                        {{$key}}
                    </td>
                    <td id="begin_with_{{$key}}" class="chu15 need_blank">
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
    </div>
    <div class="col-xs-5">
        <table class="table table-hover table-bordered table-condensed table-kq-north-west table-kq-border table-kq-bold-border kqbackground table-kq-hover" style="margin-left: -3px;" id="duoi_mb">
            <thead>
            <tr>
                <td style="width:16%;">Đuôi</td>
                <td>Lô tô</td>
            </tr>
            </thead>
            <tbody></tbody>
            <tbody style="font-weight:bold;">
            @foreach($resultLottery->loadByFoot() as $key => $rds)
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
    </div>
</div>