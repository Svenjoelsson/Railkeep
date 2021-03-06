<?php 

namespace App\Traits;
use Illuminate\Http\Request;
use DB;
use DomPDF;
use Storage;

trait UnitStatusTrait {

    public function updateAll()
    {
        $units = \App\Models\Units::whereNull('deleted_at')->get();

        foreach ($units as $unit) { 
            $critical = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->first();
            
            $repair = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_type', 'Repair')->whereNull('deleted_at')->first();
            $report = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_type', 'Report')->whereNull('deleted_at')->get()->count();
        
            $manual = \App\Models\Units::where('unit', $unit->unit)->where('inService', '0')->whereNull('deleted_at')->first();
        
            $planned = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_date', '!=', '')->whereNull('deleted_at')->first();
            $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $unit->id)->orderBy('created_at', 'desc')->first();
        
            $dateOverdue = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();    
            $dateNinty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
        
            $counterOverdue = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
            $counterNinty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
            
            $partsCritical = \App\Models\Activities::where('activity_type', 'LIKE', 'Part%Critical')->where('activity_id', $unit->id)->first();
            $partsMaint = \App\Models\Activities::where('activity_type', 'PartOverdueMaint')->where('activity_id', $unit->id)->first();
            $partsEOL = \App\Models\Activities::where('activity_type', 'PartOverdueEOL')->where('activity_id', $unit->id)->first();
        
            if ($manual) {
                $newStatus = '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Manually set out of service"><i class="fas fa-ban"></i></span>';
            } 
            else {
                if ($critical) { // Critical in progress events
                    if ($critical->critical == '1') {
                        $newStatus = '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical service in progress"><i class="fas fa-ban"></i></span> <a href="services/'.$critical->id.'/edit"><span style="font-size:16px;" data-toggle="tooltip" title="['.$critical->service_type.'] '.$critical->service_desc.'" class="badge bg"><i style="color:red;" class="fas fa-exclamation"></i></span></a>';
                    }
                } 
                else if ($counterOverdue) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service counter overdue"><i class="fas fa-ban"></i></span>';
            
                } else if ($dateOverdue) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service date overdue"><i class="fas fa-ban"></i></span>';
                } else if ($partsCritical) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical part overdue"><i class="fas fa-ban"></i></span>';
                } else if ($repair) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="None critical repair in progress"><i style="color:white;" class="fas fa-exclamation"></i></span><a href="services/'.$repair->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="['.$repair->service_type."] ".$repair->service_desc.'"><i style="color:blue;" class="fas fa-tools"></i></span></a>';
                } else if ($partsMaint || $partsEOL) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="None critical part overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                } else if ($dateNinty) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service date soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                } else if ($counterNinty) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service counter soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                }
                else {
                    $newStatus =  '<span order="3" style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
                }
                if ($report) {
                    $newStatus .=  '<a href="units/"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="'.$report.' open reports"><i style="color:blue;" class="fas fa-receipt"></i></span></a>';
                }
                if ($planned) { // Planned events
                    $newStatus .=  '<span order="0"><a href="services/'.$planned->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="['.$planned->service_type."] ".$planned->service_date.'"><i style="color:blue;" class="fas fa-clock"></i></span></a></span>';
                }
            }
            //$newStatus = '';
            \App\Models\Units::where('id', $unit->id)->update(['unitStatus' => $newStatus]);


            $ninty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
            //echo $id;
            $nextCounter = '';
            foreach ($ninty as $val) {
                $overdue1 = str_replace(env('THRESHOLD_SOON_OVERDUE')."-counter-","", $val->activity_type);
                $nextCounter .= '<span order="'.$val->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" data-toggle="tooltip" title="'.$overdue1.'" class="badge bg-warning">'.$val->activity_message.' '.$unit->maintenanceType.'</span></a></span>';
            }
        
            $counter = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
            foreach ($counter as $key) {
                $overdue = str_replace("Overdue-counter-","", $key->activity_type);
                $nextCounter .= '<span order="'.$key->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; margin-right:2px;" data-toggle="tooltip" title="'.$overdue.'" class="badge bg-danger">'.$key->activity_message.' '.$unit->maintenanceType.'</span></a></span>';
            }
            \App\Models\Units::where('id', $unit->id)->update(['nextCounter' => $nextCounter]);

            



            $date = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();    
            $nextDate = '';
            foreach ($date as $key) {
                $overdue = str_replace("Overdue-date-","", $key->activity_type);
                $nextDate .= '<span order="'.$key->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; margin-right:2px;" data-toggle="tooltip" title="'.$overdue.'" class="badge bg-danger">'.$key->activity_message.'</span></a></span>';
            }
        
            $ninty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();
            //echo $id;
            foreach ($ninty as $val) {
                $overdue1 = str_replace(env('THRESHOLD_SOON_OVERDUE')."-date-","", $val->activity_type);
                $nextDate .= '<span order="'.$val->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" data-toggle="tooltip" title="'.$overdue1.'" class="badge bg-warning">'.$val->activity_message.'</span></a></span>';
            }
            \App\Models\Units::where('id', $unit->id)->update(['nextDate' => $nextDate]);
            
        }

    }



    public function updateOne($id)
    {
        $units = \App\Models\Units::where('id', $id)->whereNull('deleted_at')->get();

        foreach ($units as $unit) { 
            $critical = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->first();
            $repair = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_type', 'Repair')->whereNull('deleted_at')->first();
            
            $report = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_type', 'Report')->whereNull('deleted_at')->get()->count();

            $manual = \App\Models\Units::where('unit', $unit->unit)->where('inService', '0')->whereNull('deleted_at')->first();
        
            $planned = \App\Models\Services::where('unit', $unit->unit)->where('service_status', 'In progress')->where('service_date', '!=', '')->whereNull('deleted_at')->first();
            $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $unit->id)->orderBy('created_at', 'desc')->first();
        
            $dateOverdue = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();    
            $dateNinty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
        
            $counterOverdue = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
            $counterNinty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->first();
            
            $partsCritical = \App\Models\Activities::where('activity_type', 'LIKE', 'Part%Critical')->where('activity_id', $unit->id)->first();
            $partsMaint = \App\Models\Activities::where('activity_type', 'PartOverdueMaint')->where('activity_id', $unit->id)->first();
            $partsEOL = \App\Models\Activities::where('activity_type', 'PartOverdueEOL')->where('activity_id', $unit->id)->first();
        
            if ($manual) {
                $newStatus = '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Manually set out of service"><i class="fas fa-ban"></i></span>';
            } 
            else {
                if ($critical) { // Critical in progress events
                    if ($critical->critical == '1') {
                        $newStatus = '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical service in progress"><i class="fas fa-ban"></i></span> <a href="services/'.$critical->id.'/edit"><span style="font-size:16px;" data-toggle="tooltip" title="['.$critical->service_type.'] '.$critical->service_desc.'" class="badge bg"><i style="color:red;" class="fas fa-exclamation"></i></span></a>';
                    }
                } 
                else if ($counterOverdue) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service counter overdue"><i class="fas fa-ban"></i></span>';
            
                } else if ($dateOverdue) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Service date overdue"><i class="fas fa-ban"></i></span>';
                } else if ($partsCritical) {
                    $newStatus =  '<span order="1" style="font-size:16px;" class="badge bg-danger" data-toggle="tooltip" title="Critical part overdue"><i class="fas fa-ban"></i></span>';
                } else if ($repair) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="None critical repair in progress"><i style="color:white;" class="fas fa-exclamation"></i></span><a href="services/'.$repair->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="['.$repair->service_type."] ".$repair->service_desc.'"><i style="color:blue;" class="fas fa-tools"></i></span></a>';
                } else if ($partsMaint || $partsEOL) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="None critical part overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                } else if ($dateNinty) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service date soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                } else if ($counterNinty) {
                    $newStatus =  '<span order="2" style="font-size:16px;" class="badge bg-warning" data-toggle="tooltip" title="Service counter soon overdue"><i style="color:white;" class="fas fa-exclamation"></i></span>';
                }
                else {
                    $newStatus =  '<span order="3" style="font-size:16px;" class="badge bg-success"><i class="fas fa-check"></i></span></a>';
                }
                if ($report) {
                    $newStatus .=  '<a href="units/'.$id.'"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="'.$report.' open reports"><i style="color:blue;" class="fas fa-receipt"></i></span></a>';
                }
                if ($planned) { // Planned events
                    $newStatus .=  '<span order="0"><a href="services/'.$planned->id.'/edit"><span style="font-size:16px; margin-left:5px;" class="badge bg" data-toggle="tooltip" title="['.$planned->service_type."] ".$planned->service_date.'"><i style="color:blue;" class="fas fa-clock"></i></span></a></span>';
                }
                
            }
            //$newStatus = '';
            \App\Models\Units::where('id', $unit->id)->update(['unitStatus' => $newStatus]);


            $ninty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
            //echo $id;
            $nextCounter = '';
            foreach ($ninty as $val) {
                $overdue1 = str_replace(env('THRESHOLD_SOON_OVERDUE')."-counter-","", $val->activity_type);
                $nextCounter .= '<span order="'.$val->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" data-toggle="tooltip" title="'.$overdue1.'" class="badge bg-warning">'.$val->activity_message.' '.$unit->maintenanceType.'</span></a></span>';
            }
        
            $counter = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','asc')->get();
            foreach ($counter as $key) {
                $overdue = str_replace("Overdue-counter-","", $key->activity_type);
                $nextCounter .= '<span order="'.$key->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; margin-right:2px;" data-toggle="tooltip" title="'.$overdue.'" class="badge bg-danger">'.$key->activity_message.' '.$unit->maintenanceType.'</span></a></span>';
            }
            \App\Models\Units::where('id', $unit->id)->update(['nextCounter' => $nextCounter]);

            



            $date = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();    
            $nextDate = '';
            foreach ($date as $key) {
                $overdue = str_replace("Overdue-date-","", $key->activity_type);
                $nextDate .= '<span order="'.$key->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; margin-right:2px;" data-toggle="tooltip" title="'.$overdue.'" class="badge bg-danger">'.$key->activity_message.'</span></a></span>';
            }
        
            $ninty = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', env('THRESHOLD_SOON_OVERDUE').'-date-%')->whereNull('deleted_at')->orderBy('id','desc')->get();
            //echo $id;
            foreach ($ninty as $val) {
                $overdue1 = str_replace(env('THRESHOLD_SOON_OVERDUE')."-date-","", $val->activity_type);
                $nextDate .= '<span order="'.$val->activity_message.'"><a href="/units/'.$unit->id.'"><span style="font-size:12px; color:white !important; margin-right:2px;" data-toggle="tooltip" title="'.$overdue1.'" class="badge bg-warning">'.$val->activity_message.'</span></a></span>';
            }
            \App\Models\Units::where('id', $unit->id)->update(['nextDate' => $nextDate]);
            
        }

    }
}