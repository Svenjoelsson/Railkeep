<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class searchController extends Controller
{
    public function search(Request $request)
    {  
        $search = $request["search"];
        $result = [];

        $unitSearch = \App\Models\Units::
            where('unit', $search)
            ->orWhere('make', $search)
            ->orWhere('customer', $search)
            ->get();
        
        $customerSearch = \App\Models\Customers::
            where('name', $search)
            ->orWhere('country', $search)
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


        if ($search == "create" || $search == "Create" || $search == "CREATE") {
                $result[] = ["title" => "Create unit", "type" => "Unit", "link" => "units/create"];
                $result[] = ["title" => "Create service", "type" => "Service", "link" => "services/create"];
                $result[] = ["title" => "Create contact", "type" => "Contacts", "link" => "contacts/create"];
                $result[] = ["title" => "Create vendor", "type" => "Vendor", "link" => "vendors/create"];
                $result[] = ["title" => "Create agreement", "type" => "Agreement", "link" => "rents/create"];
                $result[] = ["title" => "Create inventory", "type" => "Inventory", "link" => "inventories/create"];

        }

        if ($search == "report" || $search == "Report" || $search == "Reports" || $search == "reports") {

            $result[] = ["title" => "Rental returns", "type" => "Report", "link" => "reports/view/rental/returns/".now()->format('Y')."/".now()->format('m')];
            $result[] = ["title" => "Rental invoice", "type" => "Report", "link" => "reports/view/rental/invoice/".now()->format('Y')."/".now()->format('m')];

        }

        return view('search')
        ->with('result', $result);

        
    }
}
