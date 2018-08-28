@if(load_adv(5,'header'))
    @foreach(load_adv(5,'header') as $item)
        <div class="row kqvertimargin">
            <div class="col-sm-10 kqcenter ">
                <a rel="nofollow" href="{{ $item->url }}"
                   target="_blank"><img src="{{ $item->image }}" alt="nha cai dafabet" width="<?php if(!empty($item->width)) { echo $item->width; } else { echo "1072"; };  ?>" height="<?php if(!empty($item->height)) { echo $item->height; } else { echo "90"; };  ?>"></a>
            </div>
        </div>
    @endforeach
@endif
