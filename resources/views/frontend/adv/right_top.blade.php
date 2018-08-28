@if(load_adv(5,'right_top'))
<div class="kqvertimarginw">
    @foreach(load_adv(5,'right_top') as $item)
    <a rel="nofollow" href="{{ $item->url }}" target="_blank">
        <img src="{{ $item->image }}" alt=" " width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "311"; };  ?>"
             height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "200"; };  ?>" style="margin-bottom:10px;"></a>
     @endforeach
    </div>
 @endif
