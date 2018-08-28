@if(load_adv(1,'baloon_left'))
    @foreach(load_adv(1,'baloon_left') as $item)
        <div class="baloon baloon-left" id="baloon-left">
            <a class="toggle" onclick="return balloon_toggle(0);" id="toggle-bl-left">Ẩn quảng cáo</a><br>
            <a rel="nofollow" title="" alt""="" href="{{ $item->url }}"
            target="_blank"><img src="{{ $item->image }}" alt="" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "200"; };  ?>" height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "200"; };  ?>"></a>
        </div>
    @endforeach
@endif
