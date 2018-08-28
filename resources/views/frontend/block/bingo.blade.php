<table class="table table-bordered table-condensed table-kq-north table-kq-border kqcenter table-kq-bold-border kqbackground table-kq-hover" id="loto_mb">
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