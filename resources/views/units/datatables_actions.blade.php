{!! Form::open(['route' => ['units.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if(auth()->user()->hasPermissionTo('view units'))
    <a href="{{ route('units.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    @endif
    @if(auth()->user()->hasPermissionTo('edit units'))
    <a href="{{ route('units.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    @endif
    @if(auth()->user()->hasPermissionTo('delete units'))
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endif
</div>
{!! Form::close() !!}
