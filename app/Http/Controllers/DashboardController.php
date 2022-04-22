<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth;
use NumberFormatter;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
        // Spatie permissions
        $this->middleware('permission:view dashboard')->only('index');
        $this->middleware('permission:view customers')->only('map');

    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = Auth::user();
        event(new \App\Events\LoginHistory($email));
        
        function asSEK($value) {
            $fmt = numfmt_create( 'se-SE', NumberFormatter::CURRENCY );
            return numfmt_format_currency($fmt, $value, "SEK");
        }
        $critical = \App\Models\Services::where('service_status', 'In progress')->where('critical', '1')->whereNull('deleted_at')->count();
        $planned = \App\Models\Services::where('service_status', 'In progress')->where('service_date', '!=', '')->whereNull('deleted_at')->count();

        $monthlyInvoice = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->sum('monthlyCost');
        $agreements = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->count();

        $dateOverdue = \App\Models\Activities::where('activity_type', 'like', 'Overdue-date-%')->whereNull('deleted_at')->orderBy('id','desc')->count();    
        $counterOverdue = \App\Models\Activities::where('activity_type', 'like', 'Overdue-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->count();

        $dateNinty = \App\Models\Activities::where('activity_type', 'like', '90%-date-%')->whereNull('deleted_at')->orderBy('id','desc')->count();
        $counterNinty = \App\Models\Activities::where('activity_type', 'like', '90%-counter-%')->whereNull('deleted_at')->orderBy('id','desc')->count();
    
        $units = \App\Models\Units::whereNull('deleted_at')->count();


        $sumOverdue = intval($dateOverdue) + intval($counterOverdue);
        $sumNinty = intval($dateNinty) + intval($counterNinty);

        $operatingUnits = intval($units) - $sumNinty - $sumOverdue - $critical - $planned;
        $perc = round(intval($operatingUnits) / intval($units) * 100, 1);



        $sum = asSEK($monthlyInvoice);
        
        return view('dashboard')->with(['monthlyInvoice' => $sum, 'agreements' => $agreements, 'critical' => $critical, 'planned' => $planned, 'overdue' => $sumOverdue, 'ninty' => $sumNinty, 'operatingUnits' => $operatingUnits, 'units' => $units, 'perc' => $perc]);
    }

    public function map()
    {
        // https://github.com/LarsWiegers/laravel-maps
        
        return view('map');
    }
}
