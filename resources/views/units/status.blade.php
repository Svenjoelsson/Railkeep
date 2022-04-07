<?php
    $critical = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->first();
    //$services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->whereNotNull('nextServiceDate')->orderBy('nextServiceDate', 'asc')->first();
    $services = \App\Models\Services::where('unit', $unit)->whereNull('deleted_at')->where('nextServiceDate', '>', now())->orderBy('nextServiceDate', 'asc')->first();

    $repairs = \App\Models\Services::where('unit', $unit)->where('service_status', 'In progress')->whereDate('service_date', '<=', now())->whereNull('deleted_at')->first();
    $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();


    $units = \App\Models\Units::where('id', $id)->orderBy('created_at', 'desc')->first();
    $servicesDate = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->whereNotNull('nextServiceCounter')->orderBy('nextServiceCounter', 'desc')->first();
    

    if ($critical) {
        if ($critical->critical == '1') {
            echo '<a href="services/'.$critical->id.'/edit"><span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span></a>';
        } else {
            echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
        }
    } 
    else if ($repairs) {
        echo '<a href="services/'.$repairs->id.'/edit"><span style="font-size:16px;" class="badge bg-warning"><i style="color:white;" class="fas fa-exclamation"></i></span></a>';

    }

    else if ($services && $services->nextServiceDate != '') {
        $next = strtotime($services->nextServiceDate->format('Y-m-d'));
        $today = strtotime(date('Y-m-d'));
        $calc = $next - $today;
        $days = round($calc / (60 * 60 * 24));
        if ($days < 0) {
            echo '<a href="services/'.$services->id.'/edit"><span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span></a>';
        } else {
            echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
        }
        
    }

    else if ($servicesDate) {

        if ($servicesDate->nextServiceCounter != '') {
            $makelist = \App\Models\makeList::where('make', $units->make)->where('serviceName', $servicesDate->service_type)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();

            $current = $activities->activity_message;
            $next = $servicesDate->nextServiceCounter;
            $math = $next - $current;
            $perc = $math/$makelist->counter*100;

            // if  less than 10% left
            if (round($perc) <= 0) {
                echo '<span style="font-size:16px;" class="badge bg-danger"><i class="fas fa-ban"></i></span>';
            } else {
                    echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
                }
        }
    } else {
        echo '<span style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
    }
?>