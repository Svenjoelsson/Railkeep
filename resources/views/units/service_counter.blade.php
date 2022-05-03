
<?php 
    $id;
    $unit = \App\Models\Units::where('id', $id)->first();


    $ninty = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
    //echo $id;
    foreach ($ninty as $val) {
        $overdue1 = str_replace(env('THRESHOLD_SOON_OVERDUE')."-counter-","", $val->activity_type);

        echo '<a href="/units/'.$id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" data-toggle="tooltip" title="'.$overdue1.'" class="badge bg-warning">'.$val->activity_message.' '.$unit->maintenanceType.'</span></a>';
    }

    $counter = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
    //echo $id;
    foreach ($counter as $key) {
        $overdue = str_replace("Overdue-counter-","", $key->activity_type);
        echo '<a href="/units/'.$id.'"><span style="font-size:12px; margin-right:2px;" data-toggle="tooltip" title="'.$overdue.'" class="badge bg-danger">'.$key->activity_message.' '.$unit->maintenanceType.'</span></a>';
    }

    


    //echo $counter;
/*    $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();
    $units = \App\Models\Units::where('id', $id)->orderBy('created_at', 'desc')->first();
    $makelist = \App\Models\makeList::where('make', $units->make)->whereNull('deleted_at')->get();

    if ($activities->activity_message) {
        $arr = [];
        foreach ($makelist as $val) {
        $services = \App\Models\Services::where('unit', $units->unit)
            ->where('service_type', $val->serviceName)
            ->where('nextServiceCounter', '>', $activities->activity_message)
            ->where('service_status', '!=', 'In progress')
            ->orderBy('id', 'desc')
            ->first();
            if ($services) {
                $arr[$val->serviceName] = $services;

            }
        }
        usort($arr, function($a, $b) {
            return $a['nextServiceCounter'] <=> $b['nextServiceCounter'];
        });
        
        

    }

    if (!empty($arr)) {
        if ($arr[0]->nextServiceCounter != '') {
            $makelist = \App\Models\makeList::where('make', $units->make)->where('serviceName', $arr[0]->service_type)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
            $current = $activities->activity_message;
            $next = $arr[0]->nextServiceCounter;
            $math = $next - $current;


            $perc = $math/$makelist->counter*100;
            $color = "";

            // if  less than 10% left
            if (round($perc) <= 10) {
                $color = "bg-danger";
            }

            // if less than 20% left
            else if (round($perc) < 25) {
                $color = "bg-warning";
            }

            // if more than 20% left
            else  {
                $color = "bg-white";
            }
            
            ?>
            <span style="font-size:12px;" class="badge <?php echo $color; ?>">
            <?php
                
                //echo $services->service_type." ".$math." ".$maintenanceType;
            
            //echo $math;
            $now = $makelist->counter - $math;
            echo $now."/".$makelist->counter." ".$units->maintenanceType." (".round($perc, 1)."%)";
            //echo "/".$services->nextServiceCounter." "." ".$maintenanceType." (".round($perc, 1)."%)"; 
    }
    }
    
    echo "</span>";
     */
?>

