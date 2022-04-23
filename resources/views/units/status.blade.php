<?php
    $critical = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->first();
    //$services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->whereNotNull('nextServiceDate')->orderBy('nextServiceDate', 'asc')->first();
    //$services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->where('nextServiceDate', '>', now())->orderBy('nextServiceDate', 'asc')->first();

    $planned = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->where('service_date', '!=', '')->whereNull('deleted_at')->first();
    $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();

    $dateOverdue = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();    
    $dateNinty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();

    $counterOverdue = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
    $counterNinty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();


    if ($critical) { // Critical in progress events
        if ($critical->critical == '1') {
            echo '<a href="services/'.$critical->id.'/edit"><span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span></a>';
        } else {
            echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
        }
    } 
     else if ($dateOverdue) {
        echo '<span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span>';
    } else if ($dateNinty) {
        echo '<span style="font-size:16px;" class="badge bg-warning"><i style="color:white;" class="fas fa-exclamation"></i></span>';

    } else if ($counterOverdue) {
        echo '<span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span>';

    } else if ($counterNinty) {
        echo '<span style="font-size:16px;" class="badge bg-warning"><i style="color:white;" class="fas fa-exclamation"></i></span>';

    } 
    else {
        echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
    }
    if ($planned) { // Planned events

        echo '<a href="services/'.$planned->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="'.$planned->service_type." ".$planned->service_date.'"><i style="color:blue;" class="fas fa-clock"></i></span></a>';

    }
?>