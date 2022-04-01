<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $serviceVendor->id }}</p>
</div>

<!-- Serviceid Field -->
<div class="col-sm-12">
    {!! Form::label('serviceId', 'Serviceid:') !!}
    <p>{{ $serviceVendor->serviceId }}</p>
</div>

<!-- Vendorid Field -->
<div class="col-sm-12">
    {!! Form::label('vendorId', 'Vendorid:') !!}
    <p>{{ $serviceVendor->vendorId }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $serviceVendor->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $serviceVendor->updated_at }}</p>
</div>

