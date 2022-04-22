<?php

namespace App\Http\Controllers;

use App\DataTables\ActivitiesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateActivitiesRequest;
use App\Http\Requests\UpdateActivitiesRequest;
use App\Repositories\ActivitiesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ActivitiesController extends AppBaseController
{
    /** @var  ActivitiesRepository */
    private $activitiesRepository;

    public function __construct(ActivitiesRepository $activitiesRepo)
    {
        $this->activitiesRepository = $activitiesRepo;

        // Spatie permissions
        $this->middleware('permission:view activities')->only('index');
        $this->middleware('permission:create activities')->only('create');
        $this->middleware('permission:create activities')->only('store');
        $this->middleware('permission:view activities')->only('show');
        $this->middleware('permission:edit activities')->only('edit');
        $this->middleware('permission:edit activities')->only('update');
        $this->middleware('permission:delete activities')->only('destroy');
    }

    /**
     * Display a listing of the Activities.
     *
     * @param ActivitiesDataTable $activitiesDataTable
     * @return Response
     */
    public function index(ActivitiesDataTable $activitiesDataTable)
    {
        return $activitiesDataTable->render('activities.index');
    }

    /**
     * Show the form for creating a new Activities.
     *
     * @return Response
     */
    public function create()
    {
        return view('denied');
    }

    /**
     * Store a newly created Activities in storage.
     *
     * @param CreateActivitiesRequest $request
     *
     * @return Response
     */
    public function store(CreateActivitiesRequest $request)
    {

        $input = $request->all();

        $activities = $this->activitiesRepository->create($input);

        Flash::success('Activities saved successfully.');

        return redirect(route('activities.index'));
    }

    /**
     * Display the specified Activities.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            Flash::error('Activities not found');

            return redirect(route('activities.index'));
        }

        return view('activities.show')->with('activities', $activities);
    }

    /**
     * Show the form for editing the specified Activities.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            Flash::error('Activities not found');

            return redirect(route('activities.index'));
        }

        return view('activities.edit')->with('activities', $activities);
    }

    /**
     * Update the specified Activities in storage.
     *
     * @param  int              $id
     * @param UpdateActivitiesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActivitiesRequest $request)
    {
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            Flash::error('Activities not found');

            return redirect(route('activities.index'));
        }

        $activities = $this->activitiesRepository->update($request->all(), $id);

        Flash::success('Activities updated successfully.');

        return redirect(route('activities.index'));
    }

    /**
     * Remove the specified Activities from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            Flash::error('Activities not found');

            return redirect(route('activities.index'));
        }

        $this->activitiesRepository->delete($id);

        Flash::success('Activities deleted successfully.');

        return redirect(route('activities.index'));
    }

    # returns the latest unitcounter per unit
    # access each with: $arr["V5-155"]
    public function unitCounter()
    {
        $units = \App\Models\Units::whereNull('deleted_at')->orderBy('unit', 'asc')->get();
        $arr = [];
        foreach ($units as $unit) {
            $activities = \App\Models\Activities::where('activity_type', 'UnitCounter')->whereNull('deleted_at')->where('activity_id', $unit->id)->orderBy('created_at', 'desc')->first();
            $arr[$unit->unit] = $activities;
        }
        return $arr;

    }
}
