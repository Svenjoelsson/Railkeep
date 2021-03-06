<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DataTables\UnitsDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Repositories\UnitsRepository;
use Flash;
use App\Models\makeList;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Traits\ServiceplanTrait;
use App\Traits\UnitStatusTrait;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class UnitsController extends AppBaseController
{
    use ServicePlanTrait;
    use UnitStatusTrait;


    /** @var  UnitsRepository */
    private $unitsRepository;

    public function __construct(UnitsRepository $unitsRepo)
    {
        $this->unitsRepository = $unitsRepo;

        // Spatie permissions
        $this->middleware('permission:view units')->only('index');
        $this->middleware('permission:create units')->only('create');
        $this->middleware('permission:create units')->only('store');
        $this->middleware('permission:view units')->only('show');
        $this->middleware('permission:edit units')->only('edit');
        $this->middleware('permission:edit units')->only('update');
        $this->middleware('permission:delete units')->only('destroy');
    }

    /**
     * Display a listing of the Units.
     *
     * @param UnitsDataTable $unitsDataTable
     * @return Response
     */
    public function index(UnitsDataTable $unitsDataTable)
    {
        return $unitsDataTable->render('units.index');
    }

    /**
     * Show the form for creating a new Units.
     *
     * @return Response
     */
    public function create()
    {
        $maka = makeList::distinct('make')->pluck('make');
    
        $array = []; 
        foreach ($maka as $value) {
            $array[$value] = $value;
        }
        return view('units.create', ['maka' => $array]);
    }

    /**
     * Store a newly created Units in storage.
     *
     * @param CreateUnitsRequest $request
     *
     * @return Response
     */
    public function store(CreateUnitsRequest $request)
    {
        $input = $request->all();

        $input["unit"] = $input["make"]."-".$input["unit"];

        $units = $this->unitsRepository->create($input);


        $test = DB::table('units')->latest()->first();
        $id = $test->id;

        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => $id,
            'activity_message' => 'Unit has been created',
            'created_at' => now()
        ]);

        if ($input["currentCounter"] == '') {
            $counter = 0;
        } else {
            $counter = $input["currentCounter"];
        }
        //dd($counter);
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => $id,
            'activity_message' => $counter,
            'created_at' => now()
        ]);

        Flash::success('Units saved successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Display the specified Units.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }
        $makelist = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->where('level', '!=', '')->orderBy('level', 'asc')->get();
        $emptyLevel = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->whereNull('level')->orderBy('level', 'asc')->get();

        $services = DB::table('services')->where('unit', $units->unit)->where('service_status', 'Done')->whereNull('deleted_at')->get();
        $activities = DB::table('activities')->where('activity_id', $id)->where('activity_type', 'UnitCounter')->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        $plannedService = \App\Models\Services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->orderBy('service_date', 'desc')->get();

        $yesterdate = date('Y-m-d',strtotime("-7 days"))." 00:%";
        $yesterday = \App\Models\Activities::where('activity_id', $id)->where('activity_type', 'UnitCounter')->where('created_at', 'like', $yesterdate)->whereNull('deleted_at')->orderBy('id','asc')->first();    

        if ($yesterday) {
            $counterLast30days = $activities->activity_message - $yesterday->activity_message;
            $prediction = $counterLast30days / 7;
        } else {
            $prediction = 0;
        }
            

        //serviceName
        $i = 0;
        $array = []; 
        $makeArray = []; 
        $serviceArray = []; 
        
        if ($activities->created_at >= Carbon::now()->subHours(24)->toDateTimeString()) {
            $noCounterUpdate = "0";
        } else {
            $noCounterUpdate = "1";
        }
        //dd($emptyLevel);
        foreach ($makelist as $make) {
            $makeArray[$make->serviceName] = $make; 

        }
        if ($emptyLevel) {
            foreach ($emptyLevel as $make1) {
                $makeArray[$make1->serviceName] = $make1; 
            }
        }
        foreach ($services as $service) { 
            $serviceArray[$service->service_type] = $service;
        }

        if ($plannedService) {
            $plannedArray = []; 

            foreach ($plannedService as $planned) { 
                $plannedArray[$planned->service_type] = $planned;
            }
        }

        

        
        //$makeArray['make'] = $makelist;
        $array['make'] = $makeArray;
        $array['services'] = $serviceArray;
        $array['planned'] = $plannedArray;

        return view('units.show')->with(['units' => $units, 'make' => $array, 'activities' => $activities, 'plannedService' => $plannedService, 'noCounterUpdate' => $noCounterUpdate, 'prediction' => $prediction]);
    }

    /**
     * Show the form for editing the specified Units.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $units = $this->unitsRepository->find($id);

        if (str_contains($units["unit"], $units["make"])) { 
            $units["unit"] = str_replace($units["make"]."-", "", $units["unit"]);
        }
        
        $maka = makeList::distinct('make')->pluck('make');
    
        $array = []; 
        foreach ($maka as $value) {
            $array[$value] = $value;
        }
       //return view('units.create', ['maka' => $array]);

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        return view('units.edit')->with(['units' => $units, 'maka' => $array]);
    }

    /**
     * Update the specified Units in storage.
     *
     * @param  int              $id
     * @param UpdateUnitsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnitsRequest $request)
    {
        $units = $this->unitsRepository->find($id);
        
        $request["unit"] = $request["make"]."-".$request["unit"];
        

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        $input = $request->all();

        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => $id,
            'activity_message' => 'Unit has been update',
            'created_at' => now()
        ]);

        if ($input["currentCounter"] == '') {
            $counter = 0;
        } else {
            $counter = $input["currentCounter"];
        }
        DB::table('activities')->insert([
            'activity_type' => 'UnitCounter',
            'activity_id' => $id,
            'activity_message' => $counter,
            'created_at' => now()
        ]);

        $units = $this->unitsRepository->update($request->all(), $id);

        Flash::success('Units updated successfully.');

        return redirect(route('units.index'));
    }

    /**
     * Remove the specified Units from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $units = $this->unitsRepository->find($id);

        $activeAgreement = \App\Models\Rent::where('status', 'Active')->where('unit', $units->unit)->first();
        $InProgrssService = \App\Models\Services::where('service_status', 'In progress')->whereNull('deleted_at')->where('unit', $units->unit)->first();
        $mountedParts = \App\Models\InventoryLog::whereNull('deleted_at')->where('unit', $id)->first();

        if ($activeAgreement) {
            Flash::error('Unit deletion failed, there is an active agreement on this unit.');
            return redirect(route('units.index'));
        }
        if ($InProgrssService) {
            Flash::error('Unit deletion failed, a service with status In progress exists.');
            return redirect(route('units.index'));
        }
        if ($mountedParts) {
            Flash::error('Unit deletion failed, mounted parts exists on this unit.');
            return redirect(route('units.index'));
        }

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        $this->unitsRepository->delete($id);

        Flash::success('Unit deleted successfully.');

        return redirect(route('units.index'));
    }


    public function generateServicePlan($id, $type)
    {

        // Traits
        $pdf = $this->generate($id, $type);
        return $pdf;

    }

    public function updateUnitStatus()
    {
        // Traits
        $this->updateAll();
        return "Success";

    }
    public function updateOneUnitStatus($id)
    {
        // Traits
        $this->updateOne($id);
        return "Success";

    }

    public function inService($id, $value)
    {
        
        \App\Models\Units::where('id', $id)->update(['inService' => $value]);
        if ($value == '1') {
            $message = 'Unit has been set to [In Service] manually';
        } else {
            $message = 'Unit has been set to [Out of Service] manually';

        }
        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => $id,
            'activity_message' => $message,
            'created_at' => now()
        ]);
        $this->updateOne($id);
        return back();

    }
}
