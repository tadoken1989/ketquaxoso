@if(load_adv(1,'baloon_right'))
    @foreach(load_adv(1,'baloon_right') as $item)
        <div class="baloon baloon-right" id="baloon-right">
            <a class="toggle" onclick="return balloon_toggle(1);" id="toggle-bl-right">Ẩn quảng cáo</a><br>
            <a rel="nofollow" href="http://click.mibet.com/#utm_source=ballonright&amp;utm_medium=ketqua"
               target="_blank"><img src="http://img.ketqua.net/images/2018/06/15/3df80cfd7f76c7929ea06286f26df568.gif"
                                    alt="" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "200"; };  ?>" height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "200"; };  ?>"></a>
        </div>
    @endforeach
@endif
