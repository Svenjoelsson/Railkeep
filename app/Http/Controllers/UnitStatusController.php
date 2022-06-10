<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class UnitStatusController extends Controller
{
    public function counter(Request $request)
    {
        // unitStatus/counter
        $units = \App\Models\Units::whereNull('deleted_at')->get();

        foreach ($units as $unit) {
            $makes = \App\Models\makeList::where('make', $unit->make)->where('counter', '!=', '')->whereNull('deleted_at')->get();
            $counter = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'UnitCounter')->whereNull('deleted_at')->orderBy('id','desc')->first();

            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-counter-%')->get();
            if ($duplicate) {
                foreach ($duplicate as $x) {
                    \App\Models\Activities::where('id', $x->id)->delete();
                }
            }
            if ($makes) {
                foreach ($makes as $make) {
                    $services = \App\Models\Services::where('service_type', $make->serviceName)->where('unit', $unit->unit)->whereNull('deleted_at')->where('nextServiceCounter', '!=', null)->orderBy('id','desc')->first();
                    if ($services) {

                        $current = $counter->activity_message;
                        $next = $services->nextServiceCounter;
                        $math = $next - $current;
                        $perc = $math/$make->counter*100;
                        $cal = 100-intval(env('THRESHOLD_SOON_OVERDUE'));

                        if ($services->nextServiceCounter < $counter->activity_message) {
                            DB::table('activities')->insert([
                                'activity_type' => 'Overdue-counter-'.$make->serviceName,
                                'activity_id' => $unit->id,
                                'activity_message' => $math,
                                'created_at' => now()
                            ]);
                            
                            
                        }
                        else if (round($perc, 1) <= $cal) {
                            DB::table('activities')->insert([
                                'activity_type' => env('THRESHOLD_SOON_OVERDUE').'-counter-'.$make->serviceName,
                                'activity_id' => $unit->id,
                                'activity_message' => $math,
                                'created_at' => now()
                            ]);
                            
                        }
                        
                    }
                }
            }
        }
    }

    public function dates(Request $request)
    {
        $units = \App\Models\Units::whereNull('deleted_at')->get();
        foreach ($units as $unit) {
            $makes = \App\Models\makeList::where('make', $unit->make)->where('calendarDays', '!=', '')->whereNull('deleted_at')->get();

            $duplicate1 = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-date-%')->get();
            if ($duplicate1) {
                foreach ($duplicate1 as $y) {
                    \App\Models\Activities::where('id', $y->id)->delete();
                }
            }
            if ($makes) {
                foreach ($makes as $make) {
                    $services = \App\Models\Services::where('service_type', $make->serviceName)->where('unit', $unit->unit)->whereNull('deleted_at')->where('nextServiceDate', '!=', null)->orderBy('id','desc')->first();
                    if ($services) {
                        if ($services->nextServiceDate < now()) {
                                DB::table('activities')->insert([
                                    'activity_type' => 'Overdue-date-'.$make->serviceName,
                                    'activity_id' => $unit->id,
                                    'activity_message' => $services->nextServiceDate->format('Y-m-d'),
                                    'created_at' => now()
                                ]);
                            }
                        

                            $nextservicedate = strtotime($services->nextServiceDate->format('Y-m-d'));
                            $today = strtotime(date('Y-m-d'));
                            //$today = strtotime('2022-05-20');
                            $calc = $nextservicedate - $today;
                            $days = round($calc / (60 * 60 * 24));
                            $percLeft = $days/$make->calendarDays*100;

                            if ($percLeft <= 10 && $percLeft > 0) {

                                DB::table('activities')->insert([
                                    'activity_type' => env('THRESHOLD_SOON_OVERDUE').'-date-'.$make->serviceName,
                                    'activity_id' => $unit->id,
                                    'activity_message' => $services->nextServiceDate->format('Y-m-d'),
                                    'created_at' => now()
                                ]);
                            }
                        }
                    }}
                }
            }
            public function parts(Request $request)
            { 
                $mountedParts = \App\Models\InventoryLog::whereNull('dateUnmounted')->whereNull('deleted_at')->get();
                foreach ($mountedParts as $part) {
                    $mountedParts = \App\Models\InventoryLog::whereNull('dateUnmounted')->whereNull('deleted_at')->get();
        
                    $yesterdate = date('Y-m-d',strtotime("-1 days"))." 00:%";
                    $yesterday = \App\Models\Activities::where('activity_id', $part->unit)->where('activity_type', 'UnitCounter')->where('created_at', 'like', $yesterdate)->whereNull('deleted_at')->orderBy('id','asc')->first();    
                    $today = \App\Models\Activities::where('activity_id', $part->unit)->where('activity_type', 'UnitCounter')->where('created_at', 'like', date('Y-m-d')." 00:%")->whereNull('deleted_at')->orderBy('id','asc')->first();    
                    $calc = $today->activity_message - $yesterday->activity_message;
                    
                    $addCalc = intval($part->counter) + intval($calc);
                    // Update DB
                    \App\Models\InventoryLog::where('id', $part->id)->update(['counter' => $addCalc]);
        
                    $x = \App\Models\inventory::where('id', $part->part)->first();
                    // if part counter is more than part->next maintenance
                    if ($x->maintenance != NULL) {
                        if ($addCalc > $x->maintenance) {
                            if ($x->critical == "1") {
                                \App\Models\Activities::insert(['activity_type' => 'PartOverdueMaintCritical', 'activity_id' => $part->unit, 'activity_message' => $part->part, 'created_at' => now()]);
                            } else {
                                \App\Models\Activities::insert(['activity_type' => 'PartOverdueMaint', 'activity_id' => $part->unit, 'activity_message' => $part->part, 'created_at' => now()]);
                            }
                        }
                    }
                    // if part counter is more than part->EOL
                    if ($x->eol != NULL) {
                        if ($addCalc > $x->eol) {
                            if ($x->critical == "1") {
                                \App\Models\Activities::insert(['activity_type' => 'PartOverdueEOLCritical', 'activity_id' => $part->unit, 'activity_message' => $part->part, 'created_at' => now()]);
                            } else {
                                \App\Models\Activities::insert(['activity_type' => 'PartOverdueEOL', 'activity_id' => $part->unit, 'activity_message' => $part->part, 'created_at' => now()]);
                            }
                        }
                    }
        
                }
            }


        }

