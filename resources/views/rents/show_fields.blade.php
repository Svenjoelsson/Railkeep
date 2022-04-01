<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $rent->id }}</p>
</div>

<!-- Unit Field -->
<div class="col-sm-12">
    {!! Form::label('unit', 'Unit:') !!}
    <p>{{ $rent->unit }}</p>
</div>

<!-- Customer Field -->
<div class="col-sm-12">
    {!! Form::label('customer', 'Customer:') !!}
    <p>{{ $rent->customer }}</p>
</div>

<!-- Rentstart Field -->
<div class="col-sm-12">
    {!! Form::label('rentStart', 'Rentstart:') !!}
    <p>{{ $rent->rentStart }}</p>
</div>

<!-- Rentend Field -->
<div class="col-sm-12">
    {!! Form::label('rentEnd', 'Rentend:') !!}
    <p>{{ $rent->rentEnd }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $rent->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $rent->updated_at }}</p>
</div>

