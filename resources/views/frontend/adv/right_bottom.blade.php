@if(load_adv(5,'right_bottom'))

    <div class="kqvertimarginw">
        @foreach(load_adv(5,'right_bottom') as $item)

        <a rel="nofollow" href="{{ $item->url }}" target="_blank">
        <img src="{{ $item->image }}"
             alt="nha cai 388bet" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "311"; };  ?>" height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "190"; };  ?>">
    </a>
    @endforeach
    </div>
@endif
