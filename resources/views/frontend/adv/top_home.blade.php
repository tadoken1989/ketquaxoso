@if(load_adv(5,'top_home'))
    @foreach(load_adv(5,'top_home') as $item)
        <a rel="nofollow" href="{{ $item->url }}" target="_blank"> <img
                    src="{{ $item->image }}" alt="12bet" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "530"; };  ?>"
                    height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "90"; };  ?>" style="margin-bottom: 5px;"></a>
    @endforeach
@endif
