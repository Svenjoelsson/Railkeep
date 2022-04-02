
<?php 
    $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $id)->orderBy('created_at', 'desc')->first();
    $units = \App\Models\Units::where('id', $id)->orderBy('created_at', 'desc')->first();
    $services = \App\Models\Services::where('unit', $units->unit)->where('nextServiceCounter', '>', $activities->activity_message)->whereNull('deleted_at')->whereNotNull('nextServiceCounter')->orderBy('nextServiceCounter', 'asc')->first();

    if ($services) {
        if ($services->nextServiceCounter != '') {
            $makelist = \App\Models\makeList::where('make', $units->make)->where('serviceName', $services->service_type)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();

            $current = $activities->activity_message;
            $next = $services->nextServiceCounter;
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
                $color = "bg-success";
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
    
    
     
?>
</span>