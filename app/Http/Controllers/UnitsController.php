<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DataTables\UnitsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use App\Repositories\UnitsRepository;
use Flash;
use App\Models\makeList;
use App\Http\Controllers\AppBaseController;
use Response;

class UnitsController extends AppBaseController
{
    /** @var  UnitsRepository */
    private $unitsRepository;

    public function __construct(UnitsRepository $unitsRepo)
    {
        $this->unitsRepository = $unitsRepo;
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
        $makelist = DB::table('makeList')->where('make', $units->make)->whereNull('deleted_at')->orderBy('level')->get();
        $services = DB::table('services')->where('unit', $units->unit)->where('service_status', 'Done')->whereNull('deleted_at')->get();
        $activities = DB::table('activities')->where('activity_id', $id)->where('activity_type', 'UnitCounter')->whereNull('deleted_at')->orderBy('created_at', 'desc')->first();
        $plannedService = \App\Models\services::where('unit', $units->unit)->whereNull('deleted_at')->where('service_status', 'In progress')->orderBy('service_date', 'desc')->get();

        //serviceName
        $i = 0;
        $array = []; 
        $makeArray = []; 
        $serviceArray = []; 
        

        foreach ($makelist as $make) {
            $makeArray[$make->serviceName] = $make; 
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

        return view('units.show')->with(['units' => $units, 'make' => $array, 'activities' => $activities, 'plannedService' => $plannedService]);
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

        if (empty($units)) {
            Flash::error('Units not found');

            return redirect(route('units.index'));
        }

        $this->unitsRepository->delete($id);

        Flash::success('Units deleted successfully.');

        return redirect(route('units.index'));
    }
}
