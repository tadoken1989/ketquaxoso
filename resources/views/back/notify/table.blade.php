@foreach($notify as $notify)
    <tr>
        <td>{{ $notify->id }}</td>
        <td>{{ $notify->content }}</td>
        <td>{{ $notify->url }}</td>
        <td>
            @if($notify->status == 1)
                <span id="status-{{$notify->id}}" class="label label-success"><i class="fa fa-check"></i> Active</span>
            @else
                <span class="label label-warning"><i class="fa fa-check"></i> Disabled</span>
            @endif
        </td>
        <td><a class="btn btn-warning btn-xs btn-block" href="{{ route('notify.edit', [$notify->id]) }}" role="button"
               title="@lang('Edit')"><span class="fa fa-edit"></span></a></td>
        <td><a class="btn btn-danger btn-xs btn-block" href="{{ route('notify.destroy', [$notify->id]) }}" role="button"
               title="@lang('Destroy')"><span class="fa fa-remove"></span></a></td>
    </tr>
@endforeach

