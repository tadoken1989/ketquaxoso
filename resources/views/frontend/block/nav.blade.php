<nav class="navbar navbar-default kqvertimargin" id="ketqua_head_menu">
    <div class="container-fluid">
        <ul class="nav navbar-nav" style="margin-bottom:-2px;" id="head_menu">
            @foreach(load_menu() as $parent)
                @if(count($parent['children']) == 0)
                    <li>
                        <h2 class="menuh2"><a href="{{ url($parent['slug']) }}">{{$parent['name']}}</a></h2>
                    </li>
                @else
                    <li class="dropdown ">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true">{{$parent['name']}}<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach ($parent['children'] as $child)
                                <li {{ currentRouteCheckMenu(url($child['slug'])) }} ><a href="{{url($child['slug'])}}">{{$child['name']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</nav>