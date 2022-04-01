<?php

    $units = \App\Models\Units::where('unit', $unit)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
    echo $units->make."-".$units->unit;
?>