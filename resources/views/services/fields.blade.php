<?php 
if (isset($_GET["unit"])) {
        
    $unit = \App\Models\Units::where('unit', $_GET["unit"])->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
    $counter = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-counter-'.$_GET["service_type"])->whereNull('deleted_at')->orderBy('id','desc')->get();
    $date = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-date-'.$_GET["service_type"])->whereNull('deleted_at')->orderBy('id','desc')->get();    
    
    if (count($counter) != '0' || count($date)!= '0') {
        echo '<div class="alert alert-info" role="alert">';
        echo "This event will update an overdue service.";
        echo '</div>';
    }
}


?>

<!-- Unit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit', 'Unit: *') !!} <span style="float:right"><small><a href="/units/create">Create new</a></small></span>
    <?php 
    $arr1 = [];
    if (Auth::user()->role == 'customer' || Auth::user()->role == 'inspector') {
        $units = \App\Models\Units::where('customer', Auth::user()->name)->whereNull('deleted_at')->get();
    } else {
        $units = \App\Models\Units::whereNull('deleted_at')->get();
    }
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
        if (Auth::user()->role == 'customer' || Auth::user()->role == 'inspector') {
            $customers = \App\Models\Customers::where('name', Auth::user()->name)->get();
    } else {
        $customers = \App\Models\Customers::all();
    }
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
    $arr1 = ['Report' => 'Report'];
    if (Auth::user()->role == 'inspector') { ?>
    {!! Form::select('service_type', $arr1, null, ['class' => 'form-control js-example-basic-service-type', 'required']) !!}
    <?php } else { ?>
    {!! Form::select('service_type', $arr1, null, ['class' => 'form-control serviceSelect js-example-basic-service-type', 'required']) !!}
    <?php } ?>
</div>

<!-- Service Customer contact Field -->
<div class="form-group col-sm-6">

    {!! Form::label('customerContact', 'Customer Contact: *') !!} <span style="float:right"><small><a href="/contacts/create">Create new</a></small></span>
    <?php 
    if (Auth::user()->role == 'customer' || Auth::user()->role == 'inspector') {
            $customers = \App\Models\contacts::where('customer', Auth::user()->name)->get();
    } else {
        $customers = \App\Models\contacts::all();
    }
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
<?php if (Auth::user()->role != 'inspector') { ?>
<div class="form-group col-sm-6">
    <input type="checkbox" name="oos" checked class="btn-check hide" id="oos" autocomplete="off">
    <label class="btn btn-outline-info hide" for="oos">Set unit Out of service</label>
</div>
<?php } ?>

<!-- Service Desc Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('service_desc', 'Description: *') !!} <span style="float:right"><small><a style="cursor: pointer;" class="clearField">Clear</a></small></span>
    {!! Form::textarea('service_desc', null, ['class' => 'form-control descSelect ', 'rows' => '3', 'required']) !!}
</div>

<div class="form-group col-sm-12 col-lg-12">
    <label>Open reports</label>
    <table class="table openreports">
        <thead>
            <tr>
                <td>#</td>
                <td>Critical</td>
                <td>Description</td>
                <td>Created at</td>
            </tr>
        </thead>
        <tbody id="openreportsBody">

        </tbody>
    </table>
</div>

<?php if (Auth::user()->role != 'inspector') { ?>
<!-- Service Date Field -->
<div class="form-group col-sm-6 hide">
    {!! Form::label('service_date', 'Service Date:') !!}
    {!! Form::text('service_date', null, ['class' => 'form-control service_date']) !!}
</div>

<!-- Service Date Field -->
<div class="form-group col-sm-6 hide">
    {!! Form::label('service_end', 'Service End:') !!}
    {!! Form::text('service_end', null, ['class' => 'form-control service_end']) !!}
</div>

<?php } ?>

@push('page_scripts')
    <script type="text/javascript">
    $( document ).ready(function() {

    });
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
        <?php 
        if (isset($_GET["unit"])) { ?>
            $('.unitSelect').val('<?php echo $_GET["unit"]; ?>').trigger('change');
        <?php } ?>

        <?php
        if (isset($_GET["unit"])) { ?>
            $('.serviceSelect').prop( "disabled", true);
            setTimeout(
            function() 
            {
                
            $('.serviceSelect').val('<?php echo $_GET["service_type"]; ?>').trigger('change');
            $('.serviceSelect').prop( "disabled", false);
            }, 500);
        <?php } ?>
    </script>
@endpush