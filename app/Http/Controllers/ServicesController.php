<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\DataTables\ServicesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use App\Repositories\ServicesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Traits\ServiceplanTrait;
use Response;
use DomPDF;
use Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ServicesController extends AppBaseController
{
    use ServicePlanTrait;

    /** @var  ServicesRepository */
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepo)
    {
        $this->servicesRepository = $servicesRepo;
    }

    /**
     * Display a listing of the Services.
     *
     * @param ServicesDataTable $servicesDataTable
     * @return Response
     */
    public function index(ServicesDataTable $servicesDataTable)
    {
        if (auth()->user()->hasPermissionTo('view services')) {
            return $servicesDataTable->render('services.index');
        } else {
            return view('denied');
        }
    }

    /**
     * Show the form for creating a new Services.
     *
     * @return Response
     */
    public function create()
    {
        if (auth()->user()->hasPermissionTo('create services')) {
            return view('services.create');
        } else {
            return view('denied');
        }
    }

    /**
     * Store a newly created Services in storage.
     *
     * @param CreateServicesRequest $request
     *
     * @return Response
     */
    public function store(CreateServicesRequest $request)
    {
        if (auth()->user()->hasPermissionTo('create services')) {
            $input = $request->all();
            $input["service_type"] = collect($input["service_type"])->implode(', ');
            $input["service_status"] = "In progress";
            if (!isset($input["oos"])) {
                $input["oos"] = 'off';
            }

            $services = DB::table('services')->where('unit', $input["unit"])->where('service_type', $input["service_type"])->where('service_status', 'In progress')->whereNull('deleted_at')->first();
            $unit = DB::table('units')->where('unit', $input["unit"])->whereNull('deleted_at')->first();




            DB::table('activities')->insert([
                'activity_type' => 'Unit',
                'activity_id' => $unit->id,
                'activity_message' => 'A '.$input["service_type"]." for unit ".$unit->unit." has been created",
                'created_at' => now()
            ]);

            if ($services) {
                Flash::error('A service with this unit and type already exists with status In progress.');
                return redirect(route('services.index'));
            }


            $services = $this->servicesRepository->create($input);

            // if Out of Service is set
            if ($input["oos"] == 'on') {

                DB::table('activities')->insert([
                    'activity_type' => 'Schedule-oos-email',
                    'activity_id' => $services->id,
                    'activity_message' => $services->service_date,
                    'created_at' => now()
                ]);

            }

            DB::table('activities')->insert([
                'activity_type' => 'Service',
                'activity_id' => $services->id,
                'activity_message' => 'Service has been created',
                'created_at' => now()
            ]);

            Flash::success('Services saved successfully.');

            return redirect(route('services.index'));
        } else {
            return view('denied');
        }
    }

    /**
     * Display the specified Services.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (auth()->user()->hasPermissionTo('view services')) {
            $services = $this->servicesRepository->find($id);

            if (empty($services)) {
                Flash::error('Services not found');

                return redirect(route('services.index'));
            }

            return view('services.show')->with('services', $services);
        } else {
            return view('denied');
        }
    }

    /**
     * Show the form for editing the specified Services.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (auth()->user()->hasPermissionTo('edit services')) {
            $services = $this->servicesRepository->find($id);

            if (empty($services)) {
                Flash::error('Services not found');

                return redirect(route('services.index'));
            }

            return view('services.edit')->with('services', $services);
        } else {
            return view('denied');
        }
    }

    /**
     * Update the specified Services in storage.
     *
     * @param  int              $id
     * @param UpdateServicesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServicesRequest $request)
    {
        if (auth()->user()->hasPermissionTo('edit services')) {
            $services = $this->servicesRepository->find($id);
            $input = $request->all();

            if ($services->service_date != $input['service_date']) {
                //dd('asd');
                \App\Models\Activities::where('activity_type', 'Schedule-oos-email')->where('activity_id', $id)->update(['activity_message' => $input['service_date']]);
            }

            if ($input["service_status"] == "Done") {
                $request["doneDate"] = now();
    

                
    



                // Update all services where level is below this level.
                $unit = \App\Models\Units::where('unit', $input["unit"])->first();
                $activities = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'UnitCounter')->orderBy('created_at', 'desc')->first();
                $make = \App\Models\makeList::where('make', $unit->make)->orderBy('level', 'desc')->where('level', '!=', '')->get();
                $level = \App\Models\makeList::where('serviceName', $services->service_type)->where('make', $unit->make)->where('level', '!=', '')->orderBy('level', 'desc')->first();
                $services = \App\Models\Services::where('id', $id)->first();


                $counter = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-counter-'.$services->service_type)->whereNull('deleted_at')->orderBy('id','desc')->first();
                $date = \App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-date-'.$services->service_type)->whereNull('deleted_at')->orderBy('id','desc')->first();    
                // Deletes where activity is found

                if ($counter) {
                    \App\Models\Activities::where('id', $counter->id)->delete();
                }
                if ($date) {
                    \App\Models\Activities::where('id', $date->id)->delete();
                }

                if ($make) { // IF MAKE IS FOUND IN MAKELIST
                    if ($level) { // IF SERVICE TYPE EXISTS IN MAKELIST
                        foreach ($make as $value) {

                            if ($value["level"] < $level->level) {

                            $counter = null;
                                if (!empty($value["counter"])) {
                                    $counter = intval($input["doneCounter"]) + intval($value["counter"]);

                                } else {
                                    $counter = null;
                                }
                                $calendarDays = null;
                                if (!empty($value["calendarDays"])) {
                                    $calendarDays = date('Y-m-d', strtotime(' +'.intval($value["calendarDays"]).' day'));                    
                                } else {
                                    $calendarDays = null;
                                }

                                // Delete overdue activities for each
                                //\App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-counter-'.$value["serviceName"])->delete();
                                //\App\Models\Activities::where('activity_id', $unit->id)->where('activity_type', 'like', '%-date-'.$value["serviceName"])->delete();    
                    
                                \App\Models\services::create([
                                    'unit' => $unit->unit, 
                                    'customer' => $unit->customer, 
                                    'service_type' => $value["serviceName"], 
                                    'customerContact' => env('APP_NAME'),
                                    'service_desc' => $value["serviceName"]." auto created",
                                    'service_date' => $input["service_date"],
                                    'nextServiceCounter' => $counter,
                                    'nextServiceDate' => $calendarDays,
                                    'service_end' => $input["service_end"],
                                    'service_status' => 'Done',
                                ]);
                            }
                        }
                    }
                }


                $data = array(
                    'serviceId' => $id,
                    'unit' => $input["unit"], 
                    'serviceDate' => $input["service_date"], 
                    'serviceEnd' => $input["service_end"], 
                    'serviceDesc' => $input["service_desc"], 
                    'serviceType' => $services->service_type,
                    'remarks' => $input["remarks"],
                    'notPerformedActions' => $input["notPerformedActions"],
                    'doneDate' => now(),
                    'critical' => $services->critical,
                );

                // Create PDF generated file
                $filePath = public_path('uploads/services/'.$id.'/');
                if (!file_exists($filePath)) {
                    mkdir($filePath, 0777, true);
                }
                $filePath1 = public_path('uploads/units/'.$unit->id.'/');
                if (!file_exists($filePath1)) {
                    mkdir($filePath1, 0777, true);
                }
                
                $fileName = 'return-to-service '.now().'.pdf';
                DomPDF::loadView('email/return-to-service-PDF', $data)
                ->save($filePath . $fileName)
                ->save($filePath1 . $fileName);

                DB::table('activities')->insert([
                    'activity_type' => 'Service',
                    'activity_id' => $id,
                    'activity_message' => 'Return to service PDF has been generated.',
                    'created_at' => now()
                ]);
                $services = $this->servicesRepository->update($request->all(), $id);
                // Send the email
                Mail::send('email/return-to-service', $data, function($message) use ($data, $filePath, $fileName, $unit) {
                $message->to('joel@gjerdeinvest.se', 'joel@gjerdeinvest.se')
                ->subject('Unit return to service - #'.$data["serviceId"]);
                
                $message->attach($filePath.$fileName);
                $message->attachData($this->generate($unit->id, 'attachment'), 'service plan.pdf', [
                    'mime' => 'application/pdf',
                ]);
                $message->from('joel@gjerdeinvest.se', env('APP_NAME'));
                });

                DB::table('activities')->insert([
                    'activity_type' => 'Service',
                    'activity_id' => $id,
                    'activity_message' => 'Unit has returned to service.',
                    'created_at' => now()
                ]);

                DB::table('activities')->insert([
                    'activity_type' => 'Unit',
                    'activity_id' => $unit->id,
                    'activity_message' => 'Unit has returned to service.',
                    'created_at' => now()
                ]);

                $request["doneCounter"] = $input["doneCounter"];

                    $message = "Service #".$id." has been set to Done";

                } else {
                    $message = "Service #".$id." has been updated";
                }
        
            $units = DB::table('units')->where('unit', $input["unit"])->first();

            // Create activity
            DB::table('activities')->insert([
                'activity_type' => 'Service',
                'activity_id' => $id,
                'activity_message' => $message,
                'created_at' => now()
            ]);
            
            if ($input["doneCounter"]) {
                DB::table('activities')->insert([
                    'activity_type' => 'UnitCounter',
                    'activity_id' => $units->id,
                    'activity_message' => $input["doneCounter"],
                    'created_at' => now()
                ]);
            }


            if (empty($services)) {
                Flash::error('Services not found');

                return redirect(route('services.index'));
            }
            $services = $this->servicesRepository->update($request->all(), $id);

            Flash::success('Services updated successfully.');

            return redirect(route('services.index'));
        } else {
            return view('denied');
        }
    }

    /**
     * Remove the specified Services from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $services = $this->servicesRepository->find($id);

        \App\Models\Activities::where('activity_type', 'Schedule-oos-email')->where('activity_id', $id)->delete();

        if (empty($services)) {
            Flash::error('Services not found');

            return redirect(route('services.index'));
        }

        $this->servicesRepository->delete($id);

        Flash::success('Services deleted successfully.');

        return redirect(route('services.index'));
    }

    public function someMethod(Request $request)
    {
        //if your want to get single element,someName in this case
        $id = $request->serviceId; 
        $vendor = $request->vendor; 
        $email = $request->email;

        $vendorData = DB::table('vendors')
            ->where('name', '=', $vendor)
            ->first();
        
        $serviceData = DB::table('services')
            ->where('id', '=', $id)
            ->first();
        
        $serviceType = DB::table('serviceType')
            ->where('service_type', '=', $serviceData->service_type)
            ->first();
        
        $unitData = DB::table('units')
            ->where('unit', '=', $serviceData->unit)
            ->first();

        // Create activity
        DB::table('activities')->insert([
            'activity_type' => 'Service',
            'activity_id' => $id,
            'activity_message' => $vendor.' has been activated on service #'.$id.' and an email was sent to '.$email,
            'created_at' => now()
        ]);
        // Send email
        $path = public_path('uploads/makeLists/'.$serviceType->id);
        $attach = []; 
        $fileNames = []; 
        if (is_dir($path)) {
            $files = scandir($path);
            
            foreach ($files as $val) {
                if ($val !== '.' && $val !== '..') { // removes strange data...
                    array_push($attach, $path."/".$val);
                    array_push($fileNames, $val);
                }    
            }
        }

        $data = array(
            'serviceId' => $serviceData->id,
            'unit' => $serviceData->unit, 
            'critical' => $serviceData->critical,
            'vendor' => $vendor,
            'unitMake' => $unitData->make." ".$unitData->model,
            'unitYear' => $unitData->year_model,
            'serviceDate' => $serviceData->service_date, 
            'serviceEnd' => $serviceData->service_end, 
            'serviceDesc' => $serviceData->service_desc, 
            'serviceType' => $serviceData->service_type, 
            'name' => $vendorData->contact_name, 
            'attach' => $attach,
            'fileNames' => $fileNames,
            'messege' => 'Please assist us with below service event and let us know when you are finished.'
        );
        //dd($data["files"]);
        

        Mail::send('email/newservice', $data, function($message) use ($serviceData, $vendorData, $attach, $unitData) {
           $message->to('joel@gjerdeinvest.se', 'joel@gjerdeinvest.se')
           ->subject('New service order - #'.$serviceData->id);
            if ($attach) {
                foreach ($attach as $file){
                    $message->attach($file);
                }
            }

            $message->from('joel@gjerdeinvest.se', env('APP_NAME'));
        });


        DB::table('serviceVendor')->insert([
            'vendorId' => $vendorData->id,
            'serviceId' => $serviceData->id,
            'created_at' => now()
        ]);

        return back()
        ->with('success','You have activated vendor.');
    }
    










}
