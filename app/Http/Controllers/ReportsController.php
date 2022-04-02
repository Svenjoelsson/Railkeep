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

    public function returns($type, $year, $month)
    {
        $from = $year.'-'.$month.'-01';
        $to = $year.'-'.$month.'-31';
        $units = \App\Models\Rent::whereBetween('rentEnd', [$from, $to])->get();

        //return view('services.edit')->with('services', $services);
        return view('reports.rental.'.$type)->with(['period' => $year.'-'.$month, 'model' => 'rental', 'type' => $type, 'units' => $units]);
    }


    public function counter($type, $year, $month)
    {
        $from = strtotime($year.'-'.$month.'-01');
        $to = strtotime($year.'-'.$month.'-31');
        $counters = \App\Models\Activities::whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to)->get();

        //return view('services.edit')->with('services', $services);
        return view('reports.counter.'.$type)->with(['period' => $year.'-'.$month, 'model' => 'rental', 'type' => $type, 'counters' => $counters]);
    }
}
