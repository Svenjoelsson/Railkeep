<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit: *') !!} <span style="float:right"><small><a href="/units/create">Create new</a></small></span>
    <?php 
    $arr1 = [];
    $units = \App\Models\Units::all();
    foreach ($units as $key => $value1) {
        $arr1[$value1['unit']] = $value1['unit'];
    }
    ?>
    {!! Form::select('unit', $arr1, null, ['class' => 'form-control js-example-basic-single unitSelect', 'placeholder' => 'Select unit', 'required']) !!}
</div>

<!-- Customer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer: *') !!} <span style="float:right"><small><a href="/customers/create">Create new</a></small></span>
    <?php 
    $customers = \App\Models\Customers::all();
    foreach ($customers as $key => $value) {
        $arr[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customer', $arr, null, ['class' => 'form-control js-example-basic-single', 'placeholder' => 'Select customer', 'required']) !!}
</div>

<!-- Rentstart Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rentStart', 'Start date: *') !!}
    {!! Form::text('rentStart', null, ['class' => 'form-control','id'=>'rentStart', 'required']) !!}
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

<hr>

<div class="form-group col-sm-6">
    {!! Form::label('periodofnotice', 'Period of Notice: *') !!}
    {!! Form::select('periodofnotice', array('1 week' => '1 week', '1 months' => '1 months', '2 months' => '2 months', '3 months' => '3 months', '4 months' => '4 months', '5 months' => '5 months', '6 months' => '6 months', 'Terminated' => 'Terminated', 'Disabled' => 'Disabled', 'Auto' => 'Auto'), null, ['class' => 'form-control', 'placeholder' => 'Select one', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('autoextension', 'Auto renewal period: *') !!}
    {!! Form::select('autoextension', array('1 week' => '1 week', '1 months' => '1 months', '6 months' => '6 months', '12 months' => '12 months', '24 months' => '24 months', '36 months' => '36 months', '48 months' => '48 months', '60 months' => '60 months', 'Disabled' => 'Disabled'), null, ['class' => 'form-control', 'placeholder' => 'Select one', 'required']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#rentEnd').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        });        
    </script>
@endpush
<hr>
<div class="form-group col-sm-4">
    {!! Form::label('monthlyCost', 'Monthly cost:') !!}
    {!! Form::text('monthlyCost', null, ['class' => 'form-control']) !!}
</div>


<div class="form-group col-sm-4">
    {!! Form::label('counterCost', 'Counter cost:') !!}
    {!! Form::text('counterCost', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-4">
    {!! Form::label('currency', 'Currency: *') !!}
    {!! Form::select('currency', array('SEK' => 'SEK', 'DKK' => 'DKK', 'NOK' => 'NOK', 'EUR' => 'EUR'), null, ['class' => 'form-control', 'required']) !!}
</div>

<hr>
<!-- Service status Field -->
<div class="form-group col-sm-12">
    {!! Form::label('status', 'Status: *') !!}
    {!! Form::select('status', array('Active' => 'Active', 'Reserved' => 'Reserved', 'Done' => 'Done'), null, ['class' => 'form-control', 'required']) !!}
</div>