
<?php 
    //$activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();

    $units = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
    $services = \App\Models\services::where('unit', $units->unit)->whereNull('deleted_at')->whereNotNull('nextServiceDate')->orderBy('nextServiceDate', 'asc')->first();
    $plannedService = \App\Models\services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->where('service_type', '!=', 'Reparation')->orderBy('service_date', 'desc')->first();
    //$current = $activities->activity_message;
    //$next = $services->nextServiceCounter;
    //$perc = $current/$next*100;

    if ($plannedService) {
        echo "<span style='font-size:12px; margin-right:5px;' class='badge bg-primary'>".$plannedService->service_date."*"."</span>";
    } 

    if ($services && $services->nextServiceDate != '') {
    $next = strtotime($services->nextServiceDate->format('Y-m-d'));
    $today = strtotime(date('Y-m-d'));
    $calc = $next - $today;
    $days = round($calc / (60 * 60 * 24));

    if ($days < 14) {
        $color = "bg-warning";
    }
    if ($days > 15) {
        $color = "bg-success";
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
        // if no nextServiceDate is exists, we check if any service exists.

    
    
?>
