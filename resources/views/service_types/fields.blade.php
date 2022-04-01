<!-- Service Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_type', 'Service Type:') !!}
    {!! Form::text('service_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Service Desc Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('service_desc', 'Service Desc:') !!}
    {!! Form::textarea('service_desc', null, ['class' => 'form-control']) !!}
</div>
