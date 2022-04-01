<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateActivitiesAPIRequest;
use App\Http\Requests\API\UpdateActivitiesAPIRequest;
use App\Models\Activities;
use App\Repositories\ActivitiesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ActivitiesController
 * @package App\Http\Controllers\API
 */

class ActivitiesAPIController extends AppBaseController
{
    /** @var  ActivitiesRepository */
    private $activitiesRepository;

    public function __construct(ActivitiesRepository $activitiesRepo)
    {
        $this->activitiesRepository = $activitiesRepo;
    }

    /**
     * Display a listing of the Activities.
     * GET|HEAD /activities
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $activities = $this->activitiesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($activities->toArray(), 'Activities retrieved successfully');
    }

    /**
     * Store a newly created Activities in storage.
     * POST /activities
     *
     * @param CreateActivitiesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateActivitiesAPIRequest $request)
    {
        $input = $request->all();

        $activities = $this->activitiesRepository->create($input);

        return $this->sendResponse($activities->toArray(), 'Activities saved successfully');
    }

    /**
     * Display the specified Activities.
     * GET|HEAD /activities/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Activities $activities */
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            return $this->sendError('Activities not found');
        }

        return $this->sendResponse($activities->toArray(), 'Activities retrieved successfully');
    }

    /**
     * Update the specified Activities in storage.
     * PUT/PATCH /activities/{id}
     *
     * @param int $id
     * @param UpdateActivitiesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateActivitiesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Activities $activities */
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            return $this->sendError('Activities not found');
        }

        $activities = $this->activitiesRepository->update($input, $id);

        return $this->sendResponse($activities->toArray(), 'Activities updated successfully');
    }

    /**
     * Remove the specified Activities from storage.
     * DELETE /activities/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Activities $activities */
        $activities = $this->activitiesRepository->find($id);

        if (empty($activities)) {
            return $this->sendError('Activities not found');
        }

        $activities->delete();

        return $this->sendSuccess('Activities deleted successfully');
    }
}
