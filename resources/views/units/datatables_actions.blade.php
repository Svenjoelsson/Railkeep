{!! Form::open(['route' => ['units.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(auth()->user()->hasPermissionTo('view units'))
    <a href="{{ route('units.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    @endif
</div>
{!! Form::close() !!}
