
<?php 


$inventory = \App\Models\inventory::where('id', $id)->orderBy('created_at', 'desc')->first();
echo $inventory->usageCounter;
/*
$units = \App\Models\Units::where('id', $id)->orderBy('created_at', 'desc')->first();
$services = \App\Models\services::where('unit', $units->unit)->orderBy('nextServiceCounter', 'desc')->first();
if ($services) {
    if ($services->nextServiceCounter != '') {

    

    $current = $activities->activity_message;
    $next = $services->nextServiceCounter;
    $perc = $current/$next*100;
    
    if ($perc > 90) {
        $color = "badge-warning";
    }
    if ($perc < 90) {
        $color = "badge-success";
    }
    if ($perc > 100) {
        $color = "badge-danger";
    }

    ?>
    <span style="font-size:12px;" class="badge <?php echo $color; ?>">
    <?php
    echo $current;
    echo "/".$services->nextServiceCounter." "." ".$maintenanceType." (".round($perc, 1)."%)"; 
}
}


 
?>
</span>