<?php

if ($ecm == '1') {
    echo '<span style="font-size:16px;" class="badge bg-success" data-toggle="tooltip" title="Nordic Re-Finance is fully responsible">1</span>';
}
if ($ecm == '2') {
    echo '<span style="font-size:16px;" class="badge bg-info" data-toggle="tooltip" title="Nordic Re-Finance is responsible with delegation of return to service">2</span>';
}
if ($ecm == '3') {
    echo '<span style="font-size:16px;" class="badge bg-info" data-toggle="tooltip" title="Nordic Re-Finance is responsible with delegation of booking of service">3</span>';
}
if ($ecm == '4') {
    echo '<span style="font-size:16px;" class="badge bg-info" data-toggle="tooltip" title="Nordic Re-Finance is responsible with delegation of return to service and booking of service">4</span>';
}
if ($ecm == '5') {
    echo '<span style="font-size:16px;" class="badge bg-black" data-toggle="tooltip" title="Other entity is fully responsible">5</span>';
}

// Translation table
#'1' => 'Nordic Re-Finance is fully responsible', 
#'2' => 'Nordic Re-Finance responsible with delegation of return to service', 
#'3' => 'Nordic Re-Finance responsible with delegation of booking of service', 
#'4' => 'Nordic Re-Finance responsible with delegation of return to service and booking of service', 
#'5' => 'Customer is fully responsible'

?>
