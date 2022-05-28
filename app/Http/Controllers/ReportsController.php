<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use AmrShawky\LaravelCurrency\Facade\Currency;


class ReportsController extends Controller
{
    //

    public function rental ($api, $type, $year, $month)
    {

        if ($type == 'returns') {
            $from = $year.'-'.$month.'-01';
            $to = $year.'-'.$month.'-31';
            $units = \App\Models\Rent::whereBetween('rentEnd', [$from, $to])->whereNull('deleted_at')->get();

            if ($api == 'api') {
                return $units;
            }
            else if ($api == 'view') {
                return view('reports.rental.'.$type)->with(['period' => $year.'/'.$month, 'model' => 'rental', 'type' => $type, 'units' => $units]);
            } 
            else {
                return 'No api type was provided, give either view or api as value';
            }
        } 
        
        else if ($type == 'invoice') { 
            $results = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->get();
            if ($api == 'api') {
                return $results;
            }
            else if ($api == 'view') {
                return view('reports.rental.'.$type)->with(['period' => $year.'/'.$month,'year' => $year, 'month' => $month, 'model' => 'rental', 'type' => $type, 'results' => $results]);
            } 
            else {
                return 'No api type was provided, give either view or api as value';
            }
        }
        else if ($type == 'invoice_counter') { 
            $results = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->get();
            if ($api == 'api') {
                return $results;
            }
            else if ($api == 'view') {
                return view('reports.rental.'.$type)->with(['period' => $year.'/'.$month,'year' => $year, 'month' => $month, 'model' => 'rental', 'type' => $type, 'results' => $results]);
            } 
            else {
                return 'No api type was provided, give either view or api as value';
            }
        }         else if ($type == 'invoice_monthly') { 
            $results = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->get();
            if ($api == 'api') {
                return $results;
            }
            else if ($api == 'view') {
                return view('reports.rental.'.$type)->with(['period' => $year.'/'.$month,'year' => $year, 'month' => $month, 'model' => 'rental', 'type' => $type, 'results' => $results]);
            } 
            else {
                return 'No api type was provided, give either view or api as value';
            }
        }

    }

    public function orderValue($api)
    {
        $results = \App\Models\Rent::where('status', 'Active')->whereNull('deleted_at')->orderBy('customer', 'asc')->get();
        
        if ($api == 'api') {
            //return $counters;
        }
        else if ($api == 'view') {
            
            return view('reports.rental.orderValue')->with(['results' => $results]);
        } 
        else {
            return 'No api type was provided, give either view or api as value';
        }
    }

    public function counter($api, $type, $year, $month)
    {
        $from = strtotime($year.'-'.$month.'-01');
        $to = strtotime($year.'-'.$month.'-31');
        $counters = \App\Models\Activities::whereDate('created_at', '>=', $from)->whereNull('deleted_at')->whereDate('created_at', '<=', $to)->get();


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

    public function gantt($api, $type)
    {
        $rents = \App\Models\Rent::where('status', '!=', 'Done')->whereNull('deleted_at')->orderBy('unit', 'asc')->get();

        $array = [];
        $count = 0;
        foreach ($rents as $rent) {
            $count++;
            $test = \App\Models\Rent::where('id', $rent->id)->whereNull('deleted_at')->orderBy('unit', 'asc')->first();
            $array[$rent->unit][] = $test;
        }

        if ($api == 'api') {
            //return $counters;
        }
        else if ($api == 'view') {
            return view('reports.gantt.'.$type)->with(['model' => 'rental', 'type' => $type, 'rents' => $array]);
        } 
        else {
            return 'No api type was provided, give either view or api as value';
        }

        //return view('services.edit')->with('services', $services);
    }
}
