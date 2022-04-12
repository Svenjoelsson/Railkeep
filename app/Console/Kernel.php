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
