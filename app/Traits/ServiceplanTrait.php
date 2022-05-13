<?php 

namespace App\Traits;
use Illuminate\Http\Request;
use DB;
use DomPDF;
use Storage;

trait ServicePlanTrait {

    public function unitLookup($id, $type, $service)
    {
        $test = $this->generate($id, 'raw');
        //$unit = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->first();
        //$services = DB::table('services')->where('unit', $unit->unit)->where('service_type', $type)->where('service_status', 'Done')->whereNull('deleted_at')->get();
        $val = DB::table('activities')->where('activity_id', $id)->where('activity_type', $service)->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        if ($val) {
            if (str_contains($service, 'Overdue')) {
                $overdue = str_replace("Overdue-counter-","", $val->activity_type);
            }
            //$new = str_replace("-counter-", "", $val->activity_type);
            if (str_contains($service, env('THRESHOLD_SOON_OVERDUE'))) {
                $overdue = str_replace(env('THRESHOLD_SOON_OVERDUE')."-counter-","", $val->activity_type);
            }
            $next = intval($test['make']['services'][$overdue]->nextServiceCounter);
            $current = intval($test['activities']->activity_message);
            $calc = $next - $current;
            return ($calc);
        }
        //dd($activities);
        
        //return $services;
    }

    public function generate($id, $type)
    {
        $units = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->first();
        $makelist = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->where('level', '!=', '')->orderBy('level', 'asc')->get();
        $services = DB::table('services')->where('unit', $units->unit)->where('service_status', 'Done')->whereNull('deleted_at')->get();
        $activities = DB::table('activities')->where('activity_id', $id)->where('activity_type', 'UnitCounter')->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        $plannedService = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->orderBy('service_date', 'desc')->get();
        $emptyLevel = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->whereNull('level')->orderBy('level', 'asc')->get();

        //serviceName
        $i = 0;
        $array = []; 
        $makeArray = []; 
        $serviceArray = []; 
        

        foreach ($makelist as $make) {
            $makeArray[$make->serviceName] = $make; 
        }
        if ($emptyLevel) {
            foreach ($emptyLevel as $make1) {
                $makeArray[$make1->serviceName] = $make1; 
            }
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
        else if ($type == 'raw') {
            unset($make['make']['make']);
            unset($make['make']['unit']);
            unset($make['make']['planned']);
            return $make;
        }
        else {
            return 'error';
        }
    }
}