<?php

namespace App\Console;

use Mail;
use DomPDF;
use Storage;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            DB::table('activities')->insert([
                'activity_type' => 'CronJob',
                'activity_id' => '',
                'activity_message' => 'Running Tracker API',
                'created_at' => now()
            ]);


            $response = Http::get('https://nordicrefinance.cpctracking.dk/api/v2/external/trackers?api_key=V7ibePYiafPg4jASdx5qJuZX');
            //dd($response->json());
    
            $units = \App\Models\Units::whereNull('deleted_at')->where('trackerId', '!=', '')->get();
            $data = $response->json();
            foreach ($data['data'] as $val) {
                foreach ($units as $unit) {
                if (intval($unit->trackerId) == $val['physical_id']) {
                    
                    if ($unit->maintenanceType == 'Km') {
                        $counter = round($val['tripmeter'] / 1000);
    
                    }
                    if ($unit->maintenanceType == 'h') {
                        $counter = $val['running_hours'];
                    }
                    DB::table('activities')->insert([
                        'activity_type' => 'UnitCounter',
                        'activity_id' => $unit->id,
                        'activity_message' => $counter,
                        'created_at' => now()
                    ]);
                }
            }
    
            }
        })->everySixHours()->timezone('Europe/Stockholm');


        $schedule->call(function () {
            $activity = \App\Models\Activities::where('activity_type', 'Schedule-oos-email')->whereNull('deleted_at')->get();
            
            foreach ($activity as $val) {
                
                if ($val->activity_message < now()) {
                    $services = \App\Models\Services::where('id', $val->activity_id)->first();
                    $unit = \App\Models\Units::where('unit', $services->unit)->first();

                    $data = array(
                        'serviceId' => $services->id,
                        'unit' => $services->unit, 
                        'serviceDate' => $services->service_date, 
                        'serviceDesc' => $services->service_desc, 
                        'serviceType' => $services->service_type,
                        'critical' => $services->critical
                    );

                    // Create PDF generated file
                    $filePath = public_path('uploads/services/'.$val->activity_id.'/');
                    if (!file_exists($filePath)) {
                        mkdir($filePath, 0777, true);
                    }
                    $filePath1 = public_path('uploads/units/'.$unit->id.'/');
                    if (!file_exists($filePath1)) {
                        mkdir($filePath1, 0777, true);
                    }

                    $fileName = 'out-of-service '.now().'.pdf';

                    DomPDF::loadView('email/out-of-service-PDF', $data)
                    ->save($filePath . $fileName)
                    ->save($filePath1 . $fileName);

                   

                    Mail::send('email/out-of-service', $data, function($message) use ($data, $filePath, $fileName) {
                    $message->to('joel@gjerdeinvest.se', 'joel@gjerdeinvest.se')
                    ->subject('Unit out of service - #'.$data["serviceId"]);
                    $message->attach($filePath.$fileName);
                    $message->from('joel@gjerdeinvest.se', env('APP_NAME'));
                    });

                    DB::table('activities')->insert([
                        'activity_type' => 'Unit',
                        'activity_id' => $unit->id,
                        'activity_message' => 'Unit is now out of service.',
                        'created_at' => now()
                    ]);

                \App\Models\Activities::where('id', $val->id)->delete();
                }
            } 



        })->everyMinute()->timezone('Europe/Stockholm');


        $schedule->call(function () {
        // CHECK COUNTERS
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
                            } 
                            DB::table('activities')->insert([
                                'activity_type' => 'Overdue-counter-'.$make->serviceName,
                                'activity_id' => $unit->id,
                                'activity_message' => $math,
                                'created_at' => now()
                            ]);
                            
                        }
                        else if (round($perc, 1) <= $cal) {
                            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', env('THRESHOLD_SOON_OVERDUE').'-counter-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                            if ($duplicate) { 
                                \App\Models\Activities::where('id', $duplicate->id)->delete();
                            } 
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

        // CHECK DATES
        $units = \App\Models\Units::whereNull('deleted_at')->get();
        foreach ($units as $unit) {
            $makes = \App\Models\makeList::where('make', $unit->make)->where('calendarDays', '!=', '')->whereNull('deleted_at')->get();
            if ($makes) {
                foreach ($makes as $make) {
                    $services = \App\Models\Services::where('service_type', $make->serviceName)->where('unit', $unit->unit)->whereNull('deleted_at')->where('nextServiceDate', '!=', null)->orderBy('id','desc')->first();
                    if ($services) {
                        if ($services->nextServiceDate < now()) {
                            $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'Overdue-date-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                            if ($duplicate) { 
                                \App\Models\Activities::where('id', $duplicate->id)->delete();
                            }
                            DB::table('activities')->insert([
                                'activity_type' => 'Overdue-date-'.$make->serviceName,
                                'activity_id' => $unit->id,
                                'activity_message' => $services->nextServiceDate,
                                'created_at' => now()
                            ]);
                            
                        }
                        $duplicate = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', env('THRESHOLD_SOON_OVERDUE').'-date-'.$make->serviceName)->whereNull('deleted_at')->orderBy('id','desc')->first();
                        if ($duplicate) { 
                            \App\Models\Activities::where('id', $duplicate->id)->delete();
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
                                    'activity_message' => $services->nextServiceDate,
                                    'created_at' => now()
                                ]);
                            }
                        
                    }
                }
            }
        }

    })->everyThirtyMinutes()->timezone('Europe/Stockholm');
    //})->everyMinute()->timezone('Europe/Stockholm');
        

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
