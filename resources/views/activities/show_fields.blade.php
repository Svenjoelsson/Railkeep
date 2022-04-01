<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $activities->id }}</p>
</div>

<!-- Activity Type Field -->
<div class="col-sm-12">
    {!! Form::label('activity_type', 'Activity Type:') !!}
    <p>{{ $activities->activity_type }}</p>
</div>

<!-- Activity Id Field -->
<div class="col-sm-12">
    {!! Form::label('activity_id', 'Activity Id:') !!}
    <p>{{ $activities->activity_id }}</p>
</div>

<!-- Activity Message Field -->
<div class="col-sm-12">
    {!! Form::label('activity_message', 'Activity Message:') !!}
    <p>{{ $activities->activity_message }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $activities->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $activities->updated_at }}</p>
</div>

