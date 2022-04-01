<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit:') !!}
    {!! Form::text('unit', null, ['class' => 'form-control']) !!}
</div>

<!-- Make Field -->
<div class="form-group col-sm-6">
    {!! Form::label('make', 'Make:') !!}
    <a style="float:right;" href="{{ route('makeLists.index') }}">
        Manage
    </a>
    {!! Form::select('make', $maka, null, ['class' => 'form-control js-example-basic-single makeSelect', 'placeholder' => 'Select make']) !!}
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', 'Model:') !!}
    {!! Form::text('model', null, ['class' => 'form-control']) !!}
</div>

<!-- Year Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year_model', 'Year Model:') !!}
    {!! Form::text('year_model', null, ['class' => 'form-control']) !!}
</div>

<!-- Traction Force Field -->
<div class="form-group col-sm-6">
    {!! Form::label('traction_force', 'Traction Force:') !!}
    {!! Form::text('traction_force', null, ['class' => 'form-control']) !!}
</div>
<hr>
<div class="form-group col-sm-6">
    {!! Form::label('currentCounter', 'Current counter:') !!}
    {!! Form::text('currentCounter', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('maintenanceType', 'Maintenance type:') !!}
    {!! Form::select('maintenanceType', array('Km' => 'Kilometers', 'h' => 'Hours'), null, ['class' => 'form-control js-example-basic-single maintenanceType', 'placeholder' => 'Select type']) !!}
</div>

