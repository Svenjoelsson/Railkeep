<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateserviceTypeAPIRequest;
use App\Http\Requests\API\UpdateserviceTypeAPIRequest;
use App\Models\serviceType;
use App\Repositories\serviceTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class serviceTypeController
 * @package App\Http\Controllers\API
 */

class serviceTypeAPIController extends AppBaseController
{
    /** @var  serviceTypeRepository */
    private $serviceTypeRepository;

    public function __construct(serviceTypeRepository $serviceTypeRepo)
    {
        $this->serviceTypeRepository = $serviceTypeRepo;
    }

    /**
     * Display a listing of the serviceType.
     * GET|HEAD /serviceTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceTypes = $this->serviceTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($serviceTypes->toArray(), 'Service Types retrieved successfully');
    }

    /**
     * Store a newly created serviceType in storage.
     * POST /serviceTypes
     *
     * @param CreateserviceTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceTypeAPIRequest $request)
    {
        $input = $request->all();

        $serviceType = $this->serviceTypeRepository->create($input);

        return $this->sendResponse($serviceType->toArray(), 'Service Type saved successfully');
    }

    /**
     * Display the specified serviceType.
     * GET|HEAD /serviceTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var serviceType $serviceType */
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            return $this->sendError('Service Type not found');
        }

        return $this->sendResponse($serviceType->toArray(), 'Service Type retrieved successfully');
    }

    /**
     * Update the specified serviceType in storage.
     * PUT/PATCH /serviceTypes/{id}
     *
     * @param int $id
     * @param UpdateserviceTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var serviceType $serviceType */
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            return $this->sendError('Service Type not found');
        }

        $serviceType = $this->serviceTypeRepository->update($input, $id);

        return $this->sendResponse($serviceType->toArray(), 'serviceType updated successfully');
    }

    /**
     * Remove the specified serviceType from storage.
     * DELETE /serviceTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var serviceType $serviceType */
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            return $this->sendError('Service Type not found');
        }

        $serviceType->delete();

        return $this->sendSuccess('Service Type deleted successfully');
    }
}
