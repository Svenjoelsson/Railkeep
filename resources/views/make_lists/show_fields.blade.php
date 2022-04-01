<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $makeList->id }}</p>
</div>

<!-- Make Field -->
<div class="col-sm-12">
    {!! Form::label('make', 'Make:') !!}
    <p>{{ $makeList->make }}</p>
</div>

<!-- Servicename Field -->
<div class="col-sm-12">
    {!! Form::label('serviceName', 'Servicename:') !!}
    <p>{{ $makeList->serviceName }}</p>
</div>

<!-- Operationdays Field -->
<div class="col-sm-12">
    {!! Form::label('operationDays', 'Operationdays:') !!}
    <p>{{ $makeList->operationDays }}</p>
</div>

<!-- Calendardays Field -->
<div class="col-sm-12">
    {!! Form::label('calendarDays', 'Calendardays:') !!}
    <p>{{ $makeList->calendarDays }}</p>
</div>

<!-- Countertype Field -->
<div class="col-sm-12">
    {!! Form::label('counterType', 'Countertype:') !!}
    <p>{{ $makeList->counterType }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $makeList->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $makeList->updated_at }}</p>
</div>

