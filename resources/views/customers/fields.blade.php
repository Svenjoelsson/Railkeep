<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name: *') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::select('country', array('Sweden' => 'Sweden', 'Denmark' => 'Denmark', 'Norway' => 'Norway'), null, ['class' => 'form-control js-example-basic-single']) !!}
</div>