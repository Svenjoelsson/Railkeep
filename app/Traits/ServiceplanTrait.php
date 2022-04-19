<?php 

namespace App\Traits;
use Illuminate\Http\Request;
use DB;
use DomPDF;
use Storage;

trait ServiceplanTrait {


    public function generate($id, $type)
    {
        $units = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->first();
        $makelist = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->orderBy('level')->get();
        $services = DB::table('services')->where('unit', $units->unit)->where('service_status', 'Done')->whereNull('deleted_at')->get();
        $activities = DB::table('activities')->where('activity_id', $id)->where('activity_type', 'UnitCounter')->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        $plannedService = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->orderBy('service_date', 'desc')->get();
        //serviceName
        $i = 0;
        $array = []; 
        $makeArray = []; 
        $serviceArray = []; 
        

        foreach ($makelist as $make) {
            $makeArray[$make->serviceName] = $make; 
        }

        foreach ($services as $service) { 
            $serviceArray[$service->service_type] = $service;
        }

        if ($plannedService) {
            $plannedArray = []; 

            foreach ($plannedService as $planned) { 
                $plannedArray[$planned->service_type] = $planned;
            }
        }
        
        $array['make'] = $makeArray;
        $array['services'] = $serviceArray;
        $array['planned'] = $plannedArray;
        $array['unit'] = $units->unit;
        $make = [];
        $make['make'] = $array;
        $make['activities'] = $activities;

        $fileName = 'service plan '.now().'.pdf';
        $pdf = DomPDF::loadView('email/service-plan-PDF', $make);
        $pdf->setPaper('A4', 'landscape');

        if ($type == 'download') {
            return $pdf->download($fileName);
        }
        else if ($type == 'attachment') {
            $pdf->render();
            $pdf = $pdf->output();

            return $pdf;
        }
        else {
            return 'error';
        }
    }
}