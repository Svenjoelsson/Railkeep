{!! Form::open(['route' => ['services.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
<?php
$activities = \App\Models\Activities::where('activity_type', 'Schedule-oos-email')->where('activity_id', $id)->first();
if ($activities) { ?>
    <a class='btn btn-default btn-xs' data-toggle='tooltip' title='Email will be sent at: {{ $activities->activity_message }}'>
        <i style='color:blue;' class='fa fa-envelope'></i>
    </a>
<?php } else { ?>
    <a class='btn btn-default btn-xs'>
        <i style='color:gray;' class='fa fa-envelope'></i>
    </a>
<?php } ?>

    
    @if (Auth::user()->role == 'user')
    <a href="{{ route('services.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-eye"></i>
    </a>
    @endif
    <a href="{{ route('services.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    @if (Auth::user()->role == 'user')
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
    @endif
</div>
{!! Form::close() !!}
