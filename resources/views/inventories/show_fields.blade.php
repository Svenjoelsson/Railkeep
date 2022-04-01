<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $inventory->id }}</p>
</div>

<!-- Unit Field -->
<div class="col-sm-12">
    {!! Form::label('unit', 'Unit:') !!}
    <p>{{ $inventory->unit }}</p>
</div>

<!-- Partnumber Field -->
<div class="col-sm-12">
    {!! Form::label('partNumber', 'Partnumber:') !!}
    <p>{{ $inventory->partNumber }}</p>
</div>

<!-- Partname Field -->
<div class="col-sm-12">
    {!! Form::label('partName', 'Partname:') !!}
    <p>{{ $inventory->partName }}</p>
</div>

<!-- Usagecounter Field -->
<div class="col-sm-12">
    {!! Form::label('usageCounter', 'Usagecounter:') !!}
    <p>{{ $inventory->usageCounter }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $inventory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $inventory->updated_at }}</p>
</div>

