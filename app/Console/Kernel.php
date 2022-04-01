<?php

namespace App\Console;

use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
            $activity = \App\Models\Activities::where('activity_type', 'Schedule-oos-email')->whereNull('deleted_at')->get();
            
            foreach ($activity as $val) {
                if ($val->activity_message < now()) {
                    $services = \App\Models\Services::where('id', $val->activity_id)->first();
                    
                    $data = array(
                        'serviceId' => $services->id,
                        'unit' => $services->unit, 
                        'serviceDate' => $services->service_date, 
                        'serviceDesc' => $services->service_desc, 
                        'serviceType' => $services->service_type,
                        'critical' => $services->critical
                    );
                    
                    Mail::send('email/out-of-service', $data, function($message) use ($data) {
                    $message->to('joel@gjerdeinvest.se', 'joel@gjerdeinvest.se')
                    ->subject('Unit out of service - #'.$data["serviceId"]);
                    $message->from('joel@gjerdeinvest.se', env('APP_NAME'));
                    });

                \App\Models\Activities::where('id', $val->id)->delete();
                }
            } 



        })->everyMinute()->timezone('Europe/Stockholm');


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
