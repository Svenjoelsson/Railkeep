<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $serviceType->id }}</p>
</div>

<!-- Service Type Field -->
<div class="col-sm-12">
    {!! Form::label('service_type', 'Service Type:') !!}
    <p>{{ $serviceType->service_type }}</p>
</div>

<!-- Service Desc Field -->
<div class="col-sm-12">
    {!! Form::label('service_desc', 'Service Desc:') !!}
    <p>{{ $serviceType->service_desc }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $serviceType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $serviceType->updated_at }}</p>
</div>

