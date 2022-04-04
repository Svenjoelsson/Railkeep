<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ReportsController extends Controller
{
    //

    public function returns ($api, $type, $year, $month)
    {
        $from = $year.'-'.$month.'-01';
        $to = $year.'-'.$month.'-31';
        $units = \App\Models\Rent::whereBetween('rentEnd', [$from, $to])->get();

        if ($api == 'api') {
            return $units;
        }
        else if ($api == 'view') {
            return view('reports.rental.'.$type)->with(['period' => $year.'-'.$month, 'model' => 'rental', 'type' => $type, 'units' => $units]);
        } 
        else {
            return 'No api type was provided, give either view or api as value';
        }
        //return view('services.edit')->with('services', $services);
    }


    public function counter($api, $type, $year, $month)
    {
        $from = strtotime($year.'-'.$month.'-01');
        $to = strtotime($year.'-'.$month.'-31');
        $counters = \App\Models\Activities::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();


        if ($api == 'api') {
            return $counters;
        }
        else if ($api == 'view') {
            return view('reports.counter.'.$type)->with(['period' => $year.'-'.$month, 'model' => 'rental', 'type' => $type, 'counters' => $counters]);
        } 
        else {
            return 'No api type was provided, give either view or api as value';
        }

        //return view('services.edit')->with('services', $services);
    }
}