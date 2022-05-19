<?php
    $critical = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->first();
    //$services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->whereNotNull('nextServiceDate')->orderBy('nextServiceDate', 'asc')->first();
    //$services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->where('nextServiceDate', '>', now())->orderBy('nextServiceDate', 'asc')->first();
    $manual = \App\Models\Units::where('unit', $unit)->where('inService', '0')->whereNull('deleted_at')->first();

    $planned = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->where('service_date', '!=', '')->whereNull('deleted_at')->first();
    $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();

    $dateOverdue = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();    
    $dateNinty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();

    $counterOverdue = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
    $counterNinty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
    
    $partsCritical = \App\Models\Activities::where('activity_type', 'LIKE', 'Part%Critical')->where('activity_id', $id)->first();
    $partsMaint = \App\Models\Activities::where('activity_type', 'PartOverdueMaint')->where('activity_id', $id)->first();
    $partsEOL = \App\Models\Activities::where('activity_type', 'PartOverdueEOL')->where('activity_id', $id)->first();

if ($manual) {
    echo '<span style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Manually set out of service"><i class="fas fa-ban"></i></span>';
} 
else {
    if ($critical) { // Critical in progress events
        if ($critical->critical == '1') {
            echo '<span style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical service in progress"><i class="fas fa-ban"></i></span>';
            echo '<a href="services/'.$critical->id.'/edit"><span style="font-size:16px;" data-toggle="tooltip" title="['.$critical->service_type.'] '.$critical->service_desc.'" class="badge bg"><i style="color:red;" class="fas fa-exclamation"></i></span></a>';
        }
    } 
    else if ($dateOverdue) {
        echo '<span style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service date overdue"><i class="fas fa-ban"></i></span>';
    }
    else if ($partsCritical) {
        echo '<span style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical part overdue"><i class="fas fa-ban"></i></span>';

    } else if ($partsMaint || $partsEOL) {
        echo '<span style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="None critical part overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';

    } else if ($dateNinty) {
        echo '<span style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service date soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';

    } else if ($counterOverdue) {
        echo '<span style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service counter overdue"><i class="fas fa-ban"></i></span>';

    } else if ($counterNinty) {
        echo '<span style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service counter soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';

    } 
    else {
        echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
    }
    if ($planned) { // Planned events

        echo '<a href="services/'.$planned->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="['.$planned->service_type."] ".$planned->service_date.'"><i style="color:blue;" class="fas fa-clock"></i></span></a>';

    }

}
?>