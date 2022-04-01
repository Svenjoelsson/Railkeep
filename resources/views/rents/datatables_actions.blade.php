{!! Form::open(['route' => ['rents.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('rents.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
</div>
{!! Form::close() !!}
