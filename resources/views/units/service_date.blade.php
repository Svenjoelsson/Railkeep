<?php 

    $date = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();    
    //echo $id;
    foreach ($date as $key) {
        $overdue = str_replace("Overdue-date-","", $key->activity_type);
        echo '<a href="/units/'.$id.'"><span style="font-size:12px; margin-right:2px;" class="badge bg-danger">'.$overdue.'</span></a>';
    }

    $ninty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', '90%-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();
    //echo $id;
    foreach ($ninty as $val) {
        $overdue1 = str_replace("90%-date-","", $val->activity_type);
        echo '<a href="/units/'.$id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" class="badge bg-warning">'.$overdue1.'</span></a>';
    }


    //$activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();

   /* $units = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
    $services = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->where('nextServiceDate', '>', now())->orderBy('nextServiceDate', 'asc')->first();
    $plannedService = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->where('service_type', '!=', 'Reparation')->orderBy('service_date', 'asc')->first();
    //$current = $activities->activity_message;
    //$next = $services->nextServiceCounter;
    //$perc = $current/$next*100;


    if ($services && $services->nextServiceDate != '') {
    $next = strtotime($services->nextServiceDate->format('Y-m-d'));
    $today = strtotime(date('Y-m-d'));
    $calc = $next - $today;
    $days = round($calc / (60 * 60 * 24));

    if ($days < 14) {
        $color = "bg-warning";
    }
    if ($days > 15) {
        $color = "bg-white";
    }
    if ($days < 0) {
        $color = "bg-danger";
    }

    
?>

<span style="font-size:12px;" class="badge <?php echo $color; ?>">
<?php
    
    echo $services->nextServiceDate->format('Y-m-d')." (".$days." days)";
?>
</span>
<?php

    } 

    if ($plannedService) {
        echo "<span style='font-size:12px; margin-right:5px;' class='badge bg-primary'>".$plannedService->service_date."*"."</span>";
    } 
        // if no nextServiceDate is exists, we check if any service exists.

    */
    
?>
