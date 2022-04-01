<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $vendors->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $vendors->name }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $vendors->address }}</p>
</div>

<!-- Contact Name Field -->
<div class="col-sm-12">
    {!! Form::label('contact_name', 'Contact name:') !!}
    <p>{{ $vendors->contact_name }}</p>
</div>

<!-- Contact Phone Field -->
<div class="col-sm-12">
    {!! Form::label('contact_phone', 'Phone:') !!}
    <p><a href="tel:{{ $vendors->contact_phone }}">{{ $vendors->contact_phone }}</a></p>
</div>

<!-- Contact Email Field -->
<div class="col-sm-12">
    {!! Form::label('contact_email', 'Email:') !!}
    <p><a href="mailto:{{ $vendors->contact_email }}">{{ $vendors->contact_email }}</a></p>
</div>

