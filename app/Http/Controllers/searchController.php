<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search(Request $request)
    {  
        $search = $request["search"];
        $result = [];
        $searchVal[] = ["title" => $search, "type" => "Search", "link" => ""];

        $unitSearch = \App\Models\Units::
            where('unit', 'LIKE','%'.$search.'%')
            ->orWhere('make', 'LIKE','%'.$search.'%')
            ->orWhere('customer', 'LIKE','%'.$search.'%')
            ->get();
        
        $customerSearch = \App\Models\Customers::
            where('name', 'LIKE','%'.$search.'%')
            ->orWhere('country', 'LIKE','%'.$search.'%')
            ->get();

        $contactSearch = \App\Models\contacts::
            where('customer', 'LIKE','%'.$search.'%')
            ->orWhere('name', 'LIKE','%'.$search.'%')
            ->orWhere('phone', 'LIKE','%'.$search.'%')
            ->orWhere('email', 'LIKE','%'.$search.'%')
            ->get();

        $serviceSearch = \App\Models\Services::
            where('unit', 'LIKE','%'.$search.'%')
            ->orWhere('customer', 'LIKE','%'.$search.'%')
            ->orWhere('service_type', 'LIKE','%'.$search.'%')
            ->orWhere('remarks', 'LIKE','%'.$search.'%')
            ->orWhere('notPerformedActions', 'LIKE','%'.$search.'%')
            ->orWhere('service_desc', 'LIKE','%'.$search.'%')
            ->get();


        if ($unitSearch) {
            
            foreach ($unitSearch as $val) {
                $result[] = ["title" => $val["unit"], "type" => "Unit", "link" => "units/".$val["id"]];
            } 

        } 
        if ($customerSearch) {
            foreach ($customerSearch as $val1) {
                $result[] = ["title" => $val1["name"], "type" => "Customer", "link" => "customers/".$val1["id"]."/edit"];
            }
        } 
        if ($contactSearch) {
            foreach ($contactSearch as $val2) {
                $result[] = ["title" => $val2["name"], "type" => "Contact", "link" => "contacts/".$val2["id"]."/edit"];
            }
        } 

        if ($serviceSearch) {
            foreach ($serviceSearch as $val) {
                $result[] = ["title" => "[".$val["unit"]."], [".$val["customer"]."], [".$val["service_type"]."], [".$val["service_desc"]."]", "type" => "Service", "link" => "services/".$val["id"]."/edit"];
            }
        } 


        if ($search == "create" || $search == "Create" || $search == "CREATE") {
                $result[] = ["title" => "Create unit", "type" => "Unit", "link" => "units/create"];
                $result[] = ["title" => "Create event", "type" => "Service", "link" => "services/create"];
                $result[] = ["title" => "Create contact", "type" => "Contacts", "link" => "contacts/create"];
                $result[] = ["title" => "Create vendor", "type" => "Vendor", "link" => "vendors/create"];
                $result[] = ["title" => "Create agreement", "type" => "Agreement", "link" => "rents/create"];
                $result[] = ["title" => "Create inventory", "type" => "Inventory", "link" => "inventories/create"];

        }
        if ($search == "settings" || $search == "Settings" || $search == "SETTINGS") {
            $result[] = ["title" => "Soon overdue threshold: ", "type" => env('THRESHOLD_SOON_OVERDUE')."%", "link" => ""];
            $result[] = ["title" => "Overdue threshold: ", "type" => env('THRESHOLD_OVERDUE')."%", "link" => ""];


        }
        if ($search == "Cron" || $search == "cron" || $search == "CRON") {
            $result[] = ["title" => "Run unit counter status update", "type" => "Cron job", "link" => "unitStatus/counter"];
            $result[] = ["title" => "Run unit dates status update", "type" => "Cron job", "link" => "unitStatus/dates"];
            $result[] = ["title" => "Run parts counter update", "type" => "Cron job", "link" => "unitStatus/parts"];
            $result[] = ["title" => "Run unit status update", "type" => "Cron job", "link" => "unitstatusupdate"];

        }

        if ($search == "report" || $search == "Report" || $search == "Reports" || $search == "reports") {

            $result[] = ["title" => "Rental returns", "type" => "Report", "link" => "reports/view/rental/returns/".now()->format('Y')."/".now()->format('m')];
            $result[] = ["title" => "Rental invoice total", "type" => "Report", "link" => "reports/view/rental/invoice/".now()->format('Y')."/".now()->format('m')];
            $result[] = ["title" => "Rental invoice counter", "type" => "Report", "link" => "reports/view/rental/invoice_counter/".now()->format('Y')."/".now()->format('m')];
            $result[] = ["title" => "Rental invoice monthly", "type" => "Report", "link" => "reports/view/rental/invoice_monthly/".now()->format('Y')."/".now()->format('m')];
            $result[] = ["title" => "Rental total order value", "type" => "Report", "link" => "reports/view/orderValue/"];
            $result[] = ["title" => "Rental gantt schedule", "type" => "Report", "link" => "reports/view/rental/gantt/rents"];
            $result[] = ["title" => "Rental stops", "type" => "Report", "link" => "reports/view/rental/stops/".now()->format('Y')."/".now()->format('m')];

        }

        return view('search')
        ->with(['result' => $result, 'searchValue' => $searchVal]);

        
    }
}
