<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $services->id }}</p>
</div>

<!-- Unit Field -->
<div class="col-sm-12">
    {!! Form::label('unit', 'Unit:') !!}
    <p>{{ $services->unit }}</p>
</div>

<!-- Customer Field -->
<div class="col-sm-12">
    {!! Form::label('customer', 'Customer:') !!}
    <p>{{ $services->customer }}</p>
</div>

<!-- Service Type Field -->
<div class="col-sm-12">
    {!! Form::label('service_type', 'Service Type:') !!}
    <p>{{ $services->service_type }}</p>
</div>

<!-- Service Desc Field -->
<div class="col-sm-12">
    {!! Form::label('service_desc', 'Service Desc:') !!}
    <p>{{ $services->service_desc }}</p>
</div>

<!-- Service Date Field -->
<div class="col-sm-12">
    {!! Form::label('service_date', 'Service Date:') !!}
    <p>{{ $services->service_date }}</p>
</div>

<!-- Service Date Field -->
<div class="col-sm-12">
    {!! Form::label('service_status', 'Status:') !!}
    <p>{{ $services->service_status }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $services->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $services->updated_at }}</p>
</div>

