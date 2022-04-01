<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit:') !!} <span style="float:right"><small><a href="/units/create">Create new</a></small></span>
    <?php 
    $arr1 = [];
    $units = \App\Models\Units::all();
    foreach ($units as $key => $value1) {
        $arr1[$value1['unit']] = $value1['unit'];
    }
    ?>
    {!! Form::select('unit', $arr1, null, ['class' => 'form-control js-example-basic-single unitSelect', 'placeholder' => 'Select unit']) !!}
</div>

<!-- Customer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer:') !!} <span style="float:right"><small><a href="/customers/create">Create new</a></small></span>
    <?php 
    $customers = \App\Models\Customers::all();
    foreach ($customers as $key => $value) {
        $arr[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customer', $arr, null, ['class' => 'form-control js-example-basic-single', 'placeholder' => 'Select customer']) !!}
</div>

<!-- Rentstart Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rentStart', 'Start date:') !!}
    {!! Form::text('rentStart', null, ['class' => 'form-control','id'=>'rentStart']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#rentStart').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Rentend Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rentEnd', 'End date:') !!}
    {!! Form::text('rentEnd', null, ['class' => 'form-control','id'=>'rentEnd']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#rentEnd').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        })
    </script>
@endpush

<!-- Service status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', array('Active' => 'Active', 'Reserved' => 'Reserved', 'Done' => 'Done'), null, ['class' => 'form-control']) !!}
</div>