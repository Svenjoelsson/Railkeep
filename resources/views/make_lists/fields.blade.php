<!-- Make Field -->
<div class="form-group col-sm-6">
    {!! Form::label('make', 'Make:') !!}
    {!! Form::text('make', null, ['class' => 'form-control makeBlur']) !!}
</div>

<!-- Servicename Field -->
<div class="form-group col-sm-6">
    {!! Form::label('serviceName', 'Servicename:') !!}
    {!! Form::text('serviceName', null, ['class' => 'form-control']) !!}
</div>

<!-- Operationdays Field -->
<div class="form-group col-sm-6">
    {!! Form::label('operationDays', 'Operationdays:') !!}
    {!! Form::number('operationDays', null, ['class' => 'form-control']) !!}
</div>

<!-- Calendardays Field -->
<div class="form-group col-sm-6">
    {!! Form::label('calendarDays', 'Calendardays:') !!}
    {!! Form::number('calendarDays', null, ['class' => 'form-control']) !!}
</div>

<!-- Counter Field -->
<div class="form-group col-sm-6">
    {!! Form::label('counter', 'Counter:') !!}
    {!! Form::number('counter', null, ['class' => 'form-control']) !!}
</div>

<!-- Countertype Field -->
<div class="form-group col-sm-6">
    {!! Form::label('counterType', 'Counter type:') !!}
    {!! Form::select('counterType', array('Km' => 'Kilometers', 'h' => 'Hours'), null, ['class' => 'form-control js-example-basic-single counterType', 'placeholder' => 'Select type']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('level', 'Service level:') !!}
    {!! Form::number('level', null, ['class' => 'form-control']) !!}
</div>
