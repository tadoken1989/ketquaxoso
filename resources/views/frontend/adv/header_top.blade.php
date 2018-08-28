@if(load_adv(2,'header_top'))
    @foreach(load_adv(2,'header_top') as $item)
        <div class="col-sm-3 col-sm-offset-1">
            <a rel="nofollow" href="{{ $item->url }}" target="_blank"><img
                        style="display:block;float:right;"
                        src="{{ $item->image }}"
                        alt="nhà cái uy tín" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "350"; };  ?>" height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "90"; };  ?>"></a>
        </div>
    @endforeach

@endif
