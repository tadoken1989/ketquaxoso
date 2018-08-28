@extends('frontend.layouts.index')
@section('content')
<div class="col-sm-7">
    <div class="panel panel-default">
        <div class="panel-heading center">
            <h4 class="right-menu-title">{{$detail->name}}</h4>
        </div>
        <div class="panel-body">
            <div class="panel-body pad0">
                <div class="table-responsive">
                    <table class="table table-bordered mar0">
                    <tbody>
                @foreach ($list->chunk(2) as $sl)
                    <tr class="right-menu-row">
                    @foreach($sl as $item)
                        <td class="right-menu-item all-table"><a href="/chu-ky">{{$item['name']}}</a></td>
                    @endforeach
                    </tr>
                @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div> 
    </div>     
</div>      
  
@endsection
@section('navRightBottom')
    @include('frontend.block.navRight')
@endsection 