<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUnitsAPIRequest;
use App\Http\Requests\API\UpdateUnitsAPIRequest;
use App\Models\Units;
use App\Repositories\UnitsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UnitsController
 * @package App\Http\Controllers\API
 */

class UnitsAPIController extends AppBaseController
{
    /** @var  UnitsRepository */
    private $unitsRepository;

    public function __construct(UnitsRepository $unitsRepo)
    {
        $this->unitsRepository = $unitsRepo;
    }

    /**
     * Display a listing of the Units.
     * GET|HEAD /units
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $units = $this->unitsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($units->toArray(), 'Units retrieved successfully');
    }

    /**
     * Store a newly created Units in storage.
     * POST /units
     *
     * @param CreateUnitsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUnitsAPIRequest $request)
    {
        $input = $request->all();

        $units = $this->unitsRepository->create($input);

        return $this->sendResponse($units->toArray(), 'Units saved successfully');
    }

    /**
     * Display the specified Units.
     * GET|HEAD /units/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Units $units */
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            return $this->sendError('Units not found');
        }

        return $this->sendResponse($units->toArray(), 'Units retrieved successfully');
    }

    /**
     * Update the specified Units in storage.
     * PUT/PATCH /units/{id}
     *
     * @param int $id
     * @param UpdateUnitsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnitsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Units $units */
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            return $this->sendError('Units not found');
        }

        $units = $this->unitsRepository->update($input, $id);

        return $this->sendResponse($units->toArray(), 'Units updated successfully');
    }

    /**
     * Remove the specified Units from storage.
     * DELETE /units/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Units $units */
        $units = $this->unitsRepository->find($id);

        if (empty($units)) {
            return $this->sendError('Units not found');
        }

        $units->delete();

        return $this->sendSuccess('Units deleted successfully');
    }
}
