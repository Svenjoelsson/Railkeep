<!-- Unit Field -->
<?php 


    
?>



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
<<<<<<< HEAD
    $customers = \\App\Models\Customers::all();
=======
    $customers = \App\Models\customers::all();
>>>>>>> parent of df25d446 (bug fix)
    foreach ($customers as $key => $value) {
        $arr[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customer', $arr, null, ['class' => 'form-control js-example-basic-single customerSelect customerSelectDisable', 'placeholder' => 'Select customer', 'required']) !!}
    <input type="hidden" class="customerSelect" name="customer">
</div>

<!-- Service Type Field -->
<div class="form-group col-sm-6">

    {!! Form::label('service_type', 'Service type: *') !!} <span style="float:right"><small><a href="{{ route('makeLists.create') }}">Create new</a></small></span>
    <?php 
    $arr1 = [];
    $service_type = \App\Models\serviceType::all();
    foreach ($service_type as $key => $value1) {
        $arr1[$value1['service_type']] = $value1['service_type'];
    }
    ?>
    {!! Form::select('service_type', $arr1, null, ['class' => 'form-control serviceSelect js-example-basic-single', 'required']) !!}


</div>

<!-- Service Customer contact Field -->
<div class="form-group col-sm-6">

    {!! Form::label('customerContact', 'Customer Contact: *') !!} <span style="float:right"><small><a href="/contacts/create">Create new</a></small></span>
    <?php 
    $customers = \App\Models\contacts::all();
    $arr3 = [];
    foreach ($customers as $key => $value) {
        $arr3[$value['name']] = $value['name'];
    }



            /*$data = array(
                'serviceId' => $services->id,
                'unit' => $services->unit, 
                'serviceDate' => $services->service_date, 
                'serviceDesc' => $services->service_desc, 
                'serviceType' => $services->service_type
            );*/
            //echo $data; 
    ?>
    {!! Form::select('customerContact', $arr3, null, ['class' => 'form-control contactpersons', 'placeholder' => 'Select contact', 'required']) !!}


</div>
<div class="form-group col-sm-6">
    <input type="checkbox" name="critical" value="1" class="btn-check" id="critical" autocomplete="off">
    <label class="btn btn-outline-danger" for="critical">Critical</label>
    
</div>

<div class="form-group col-sm-6">
    <input type="checkbox" name="oos" checked class="btn-check" id="oos" autocomplete="off">
    <label class="btn btn-outline-primary" for="oos">Set unit Out of service</label>
    
</div>

<!-- Service Desc Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('service_desc', 'Description: *') !!} <span style="float:right"><small><a style="cursor: pointer;" class="clearField">Clear</a></small></span>
    {!! Form::textarea('service_desc', null, ['class' => 'form-control descSelect', 'required']) !!}
</div>

<!-- Service Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_date', 'Service Date: *') !!}
    {!! Form::text('service_date', null, ['class' => 'form-control service_date', 'required']) !!}
</div>

<!-- Service Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_end', 'Service End:') !!}
    {!! Form::text('service_end', null, ['class' => 'form-control service_end']) !!}
</div>



@push('page_scripts')
    <script type="text/javascript">
        $('.service_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: true,
            showTodayButton: true,
            showClear: true,
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-clock-o",
                clear: "fa fa-trash-o"
            }
        });
        $('.service_end').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: true,
            showTodayButton: true,
            showClear: true,
            sideBySide: true,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-clock-o",
                clear: "fa fa-trash-o"
            }
        });
    </script>
@endpush