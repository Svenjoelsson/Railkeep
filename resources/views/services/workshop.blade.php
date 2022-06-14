<?php 

$serviceVendor = \App\Models\serviceVendor::where('serviceId', $id)->get();
$full = '';
if (!empty($serviceVendor)) {
    foreach ($serviceVendor as $key) {
        $vendor = \App\Models\Vendors::where('id', $key->vendorId)->whereNull('deleted_at')->first();
        if (isset($vendor)){
            //echo $key->vendorId;
            $full .= $vendor->name." (".$vendor->address.")<br />";
        }
    }
    $out = strlen($full) > 50 ? substr($full,0,44)." [...]" : $full;
    echo $out;

}


?>