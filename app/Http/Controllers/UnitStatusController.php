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
                            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'Overdue-counter-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                            if ($duplicate) { 
                                \App\Models\Activities::where('id', $duplicate->id)->delete();
                            } else {
                                DB::table('activities')->insert([
                                    'activity_type' => 'Overdue-counter-'.$make->serviceName,
                                    'activity_id' => $unit->id,
                                    'activity_message' => $math,
                                    'created_at' => now()
                                ]);
                            }
                            
                        }
                        else if (round($perc, 1) <= $cal) {
                            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', env('THRESHOLD_SOON_OVERDUE').'-counter-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                            if ($duplicate) { 
                                \App\Models\Activities::where('id', $duplicate->id)->delete();
                            } else {
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
    }

    public function dates(Request $request)
    {
        $units = \App\Models\Units::whereNull('deleted_at')->get();
        foreach ($units as $unit) {
            $makes = \App\Models\makeList::where('make', $unit->make)->where('calendarDays', '!=', '')->whereNull('deleted_at')->get();
            if ($makes) {
                foreach ($makes as $make) {
                    $services = \App\Models\Services::where('service_type', $make->serviceName)->where('unit', $unit->unit)->whereNull('deleted_at')->where('nextServiceDate', '!=', null)->orderBy('id','desc')->first();
                    if ($services) {
                        if ($services->nextServiceDate < now()) {
                            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'Overdue-date-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                            if (!$duplicate) { 
                                DB::table('activities')->insert([
                                    'activity_type' => 'Overdue-date-'.$make->serviceName,
                                    'activity_id' => $unit->id,
                                    'activity_message' => '1',
                                    'created_at' => now()
                                ]);
                            }
                        }
                        $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', '90%-date-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                        if (!$duplicate) { 
                            $nextservicedate = strtotime($services->nextServiceDate->format('Y-m-d'));
                            $today = strtotime(date('Y-m-d'));
                            //$today = strtotime('2022-05-20');
                            $calc = $nextservicedate - $today;
                            $days = round($calc / (60 * 60 * 24));
                            $percLeft = $days/$make->calendarDays*100;

                            if ($percLeft <= 10 && $percLeft > 0) {

                                DB::table('activities')->insert([
                                    'activity_type' => '90%-date-'.$make->serviceName,
                                    'activity_id' => $unit->id,
                                    'activity_message' => '1',
                                    'created_at' => now()
                                ]);
                            }
                        }
                    }
                }
            }
        }

    }
}
