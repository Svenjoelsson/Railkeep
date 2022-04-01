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

class ActivitiesController extends AppBaseController
{
    /** @var  ActivitiesRepository */
    private $activitiesRepository;

    public function __construct(ActivitiesRepository $activitiesRepo)
    {
        $this->activitiesRepository = $activitiesRepo;
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
        return view('activities.create');
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
}
