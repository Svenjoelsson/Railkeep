

<!-- Partnumber Field -->
<div class="form-group col-sm-6">
    {!! Form::label('partNumber', 'Partnumber:') !!}
    {!! Form::number('partNumber', null, ['class' => 'form-control']) !!}
</div>

<!-- Partname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('partName', 'Partname:') !!}
    {!! Form::text('partName', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', array('New' => 'New', 'Used' => 'Used', 'Repairable' => 'Repairable', 'On service' => 'On service', 'Discarded' => 'Discarded'), null, ['class' => 'form-control js-example-basic-single']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('batch', 'Batch:') !!}
    {!! Form::text('batch', null, ['class' => 'form-control'] ) !!}
</div>



<div class="form-group col-sm-6">
    {!! Form::label('eol', 'End of life (hours/kilometers):') !!}
    {!! Form::number('eol', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('eolDate', 'End of life (date):') !!}
    {!! Form::text('eolDate', null, ['class' => 'form-control service_date'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('maintenance', 'Next maintenance (counter):') !!}
    {!! Form::number('maintenance', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('critical', 'Critical:') !!}
    {!! Form::select('critical', array('0' => 'No', '1' => 'Yes'), null, ['class' => 'form-control'] ) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('.service_date').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush