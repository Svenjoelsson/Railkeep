<?php
    $units = \App\Models\Units::where('id', $id)->orderBy('created_at', 'desc')->first();
    $services = \App\Models\Services::where('unit', $units->unit)->orderBy('nextServiceDate', 'desc')->first();

    

?>