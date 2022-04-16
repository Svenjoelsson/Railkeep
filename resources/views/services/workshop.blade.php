<?php 

$serviceVendor = \App\Models\serviceVendor::where('serviceId', $id)->get();
if (!empty($serviceVendor)) {
    foreach ($serviceVendor as $key) {
        $vendor = \App\Models\Vendors::where('id', $key->vendorId)->whereNull('deleted_at')->first();
        if (isset($vendor)){
            //echo $key->vendorId;
            echo $vendor->name." (".$vendor->address.")<br />";
        }
    }
}


?>