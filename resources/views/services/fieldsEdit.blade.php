<!-- Unit Field -->
<?php 
    $unit = \App\Models\Units::where('unit', $services->unit)->orderBy('created_at', 'desc')->first();
    $make = \App\Models\makeList::where('make', $unit->make)->where('serviceName', $services->service_type)->orderBy('created_at', 'desc')->first();
    
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
    {!! Form::select('unit', $arr1, null, ['class' => 'form-control js-example-basic-single unitSelect', 'disabled', 'placeholder' => 'Select unit']) !!}
</div>  
<input type="hidden" name="unit" value="{{ $services->unit }}">

<!-- Customer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer', 'Customer: *') !!} <span style="float:right"><small><a href="/customers/create">Create new</a></small></span>
    <?php 
    $customers = \App\Models\Customers::all();
    foreach ($customers as $key => $value) {
        $arr[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customer', $arr, null, ['class' => 'form-control js-example-basic-single customerSelect customerSelectDisable', 'disabled', 'placeholder' => 'Select customer']) !!}
    <input type="hidden" class="customerSelect" value="{{ $services->customer }} name="customer">
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
    {!! Form::text('service_type', null, ['class' => 'form-control', 'disabled', 'required']) !!}

</div>

<div class="form-group col-sm-6">

    {!! Form::label('customerContact', 'Customer Contact: *') !!} <span style="float:right"><small><a href="/contacts/create">Create new</a></small></span>
    <?php 
    $customers = \App\Models\Contacts::all();
    $arr2 = [];
    foreach ($customers as $key => $value) {
        $arr2[$value['name']] = $value['name'];
    }
    ?>
    {!! Form::select('customerContact', $arr2, null, ['class' => 'form-control contactpersons disableAll', 'disabled', 'placeholder' => 'Select contact', 'required']) !!}


</div>

<div class="form-group col-sm-12">
    <input type="checkbox" name="critical" value="1" class="btn-check" id="btn-check-outlined" disabled autocomplete="off" <?php if (!empty($services->critical)) { echo "checked"; } ?>>
    <label class="btn btn-outline-danger" for="btn-check-outlined">Critical</label>
    
</div>

<!-- Service Desc Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('service_desc', 'Description: *') !!} <span style="float:right"><small><a style="cursor: pointer;" class="clearField">Clear</a></small></span>
    {!! Form::textarea('service_desc', null, ['class' => 'form-control disableAll descSelect', 'required', 'rows' => '10']) !!}
</div>


<!-- Service Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_date', 'Service Date: *') !!}
    {!! Form::text('service_date', null, ['class' => 'form-control disableAll service_date', 'required']) !!}
</div>

<!-- Service Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_end', 'Service End:') !!}
    {!! Form::text('service_end', null, ['class' => 'form-control disableAll service_date service_end']) !!}
</div>

<!-- Service status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_status', 'Status: *') !!}
    {!! Form::select('service_status', array('In progress' => 'In progress', 'Done' => 'Done'), null, ['class' => 'form-control disableAll serviceStatus']) !!}
</div>
<?php 
    if ($make !== null && isset($make->calendarDays)) {
?>
<div class="form-group col-sm-6 hiddenInputs" style="display:none;">
    {!! Form::label('nextServiceDate', 'Next service date: *') !!}
    <span style="float:right"><a href="#" onclick="calcDays()">Calculate (<span id="newServiceDay"></span>)</a></span>

    <?php 
        
        $make = \App\Models\makeList::where('make', $unit->make)->where('serviceName', $services->service_type)->orderBy('created_at', 'desc')->first();
        $new = strtotime($services->service_end);
        $date = strtotime("+".intval($make->calendarDays)." days", $new);
        $newDate = date('Y-m-d', $date);

    ?>
    {!! Form::text('nextServiceDate', null, ['class' => 'form-control disableAll service_date nextDate']) !!}
</div>

<?php } else { ?>
    <div class="form-group col-sm-6 hiddenInputs" style="display:none;">
    <input type="hidden" name="nextServiceDate" value=''>
    </div>
<?php } ?>

<?php 
    
$id = \App\Models\Units::where('unit', $services->unit)->orderBy('created_at', 'desc')->first();
$unitData = \App\Models\Activities::where('activity_type', 'UnitCounter')->where('activity_id', $unit->id)->orderBy('created_at', 'desc')->first();
//$newCounter = intval($unitData->activity_message) + $make->counter;
//echo $unitData->activity_message;
?>
<?php 
//dd($make);
if ($make !== null && isset($make->counter)) {
?>
<div class="form-group col-sm-6 hiddenInputs" style="display:none;">
    {!! Form::label('currentCounter', 'Counter at service: *') !!}
    {!! Form::text('currentCounter', intval($unitData->activity_message), ['class' => 'form-control disableAll currentCounter']) !!}
    <small>Will override GPS tracker counter.</small>
</div>

<div class="form-group col-sm-6 hiddenInputs" style="display:none;">
    
    {!! Form::label('nextServiceCounter', 'Next service counter in: *') !!}
    <span style="float:right"><a href="#" onclick="calcCounter()">Calculate (<span id="newService"></span>)</a></span>
    {!! Form::number('nextServiceCounter', null, ['class' => 'form-control disableAll nextCounter']) !!}
    <small>    
        <?php
        
        echo "Current: ".$unitData->activity_message." ".$id->maintenanceType;
        ?>
    </small>
</div>

<?php 
    } else { ?>
        <input type="hidden" name="currentCounter">
    <?php } ?>
<div class="form-group col-sm-6 col-lg-6 hiddenInputs" style="display:none;">
    {!! Form::label('remarks', 'Remark/comment: ') !!}
    {!! Form::textarea('remarks', null, ['class' => 'form-control disableAll', 'rows' => '4']) !!}
</div>
<div class="form-group col-sm-6 col-lg-6 hiddenInputs" style="display:none;">
    {!! Form::label('notPerformedActions', 'Not performed actions: ') !!} 
    {!! Form::textarea('notPerformedActions', null, ['class' => 'form-control disableAll', 'rows' => '4']) !!}

</div>

@push('page_scripts')





<?php if ($make) { ?>

    <script type="text/javascript">
        
       $('#newService').append('+'+'<?php echo $make->counter ?>');
       $('#newServiceDay').append('+'+'<?php echo $make->calendarDays ?>'+' days');

       function calcCounter () {
            var current = $('.currentCounter').val();
            var interval = '<?php echo $make->counter ?>';
            $('.nextCounter').val(parseInt(interval) + parseInt(current));
            
        }

        function calcDays () {
            var current = $('.service_end').val();
            if (current === '') {
                alert('Service End must be filled in!');
            } else {

                var interval = '<?php echo $make->calendarDays ?>';
                var new_date = moment(current, "YYYY-MM-DD").add(parseInt(interval), 'days');

                $('.nextDate').val(new_date.format('YYYY-MM-DD'));

            }
            
        }
        </script>
<?php } ?>

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

        if ($('.serviceStatus').val() == 'Done') {
            $('.hiddenInputs').show();
            $('.disableAll').prop( "disabled", true);
        }

        $('.serviceStatus').on('change', function() {
            if ($(this).val() == 'Done'){
                $('.hiddenInputs').show();
            }
        });


        
        
    </script>
@endpush