{!! Form::open(['route' => ['rents.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    @if (auth()->user()->hasPermissionTo('edit agreements')) 
    <a href="{{ route('rents.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    @endif
</div>
{!! Form::close() !!}
