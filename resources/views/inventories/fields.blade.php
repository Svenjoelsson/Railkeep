<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit:') !!} <span style="float:right"><small><a href="/units/create">Create new</a></small></span>
    <?php 
    $arr1 = [];
    $units = \App\Models\units::all();
    foreach ($units as $key => $value1) {
        $arr1[$value1['unit']] = $value1['unit'];
    }
    ?>
    {!! Form::select('unit', $arr1, null, ['class' => 'form-control js-example-basic-single js-example-basic-single-modal', 'placeholder' => 'Select unit']) !!}
</div>

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

<!-- Usagecounter Field -->
<div class="form-group col-sm-6">
    {!! Form::label('usageCounter', 'Usagecounter:') !!}
    {!! Form::number('usageCounter', null, ['class' => 'form-control'] ) !!}
</div>


<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', array('New' => 'New', 'Used' => 'Used', 'Repairable' => 'Repairable', 'On service' => 'On service', 'Discarded' => 'Discarded'), null, ['class' => 'form-control js-example-basic-single js-example-basic-single-modal']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('batch', 'Batch:') !!}
    {!! Form::text('batch', null, ['class' => 'form-control'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('maintenance', 'Maintenance date:') !!}
    {!! Form::text('maintenance', null, ['class' => 'form-control service_date'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('eol', 'End of life (hours/kilometers):') !!}
    {!! Form::number('eol', null, ['class' => 'form-control'] ) !!}
</div>
<hr>
<div class="form-group col-sm-6">
    {!! Form::label('dateMounted', 'Date mounted:') !!}
    {!! Form::text('dateMounted', null, ['class' => 'form-control service_date'] ) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('dateUnmounted', 'Date unmounted:') !!}
    {!! Form::text('dateUnmounted', null, ['class' => 'form-control service_date'] ) !!}
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