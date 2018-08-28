@foreach(load_menu() as $parent)
    <div class="kqvertimarginw">
        @if(count($parent['children']) > 8)
            <div class="sidebar-nav">
                <h3 class="right-menu-title">
                    @if($parent['id'] == 6)
                        <i class="fa fa-diamond"></i>
                    @elseif($parent['id'] == 7)
                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                    @elseif($parent['id'] == 8)
                        <i class="fa fa-bar-chart"></i>
                    @endif
                    <a href="{{ url($parent['slug']) }}"> @if($parent['id'] >= 6  && $parent['id'] < 9) {{$parent['name']}}  @endif </a>
                </h3>
            </div>

            <div class="panel-body pad0">
                <div class="table-responsive">
                    <table class="table table-bordered mar0">
                        <tbody>
                        @foreach (array_chunk($parent['children'],2) as $child)
                            <tr class="right-menu-row">
                                @foreach($child as $item)
                                    <td class="right-menu-item"><a {{ currentRouteCheck(url($item['slug'])) }} href="{{ url($item['slug']) }}">{{$item['name']}}</a>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endforeach
@include('frontend.adv.right_bottom')