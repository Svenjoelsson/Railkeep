<?php

    $units = \App\Models\units::where('unit', $unit)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
    echo $units->make."-".$units->unit;
?>