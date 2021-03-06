<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateServicesAPIRequest;
use App\Http\Requests\API\UpdateServicesAPIRequest;
use App\Models\Services;
use App\Repositories\ServicesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ServicesController
 * @package App\Http\Controllers\API
 */

class ServicesAPIController extends AppBaseController
{
    /** @var  ServicesRepository */
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepo)
    {
        $this->servicesRepository = $servicesRepo;
    }

    /**
     * Display a listing of the Services.
     * GET|HEAD /services
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $services = $this->servicesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     * Store a newly created Services in storage.
     * POST /services
     *
     * @param CreateServicesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateServicesAPIRequest $request)
    {
        $input = $request->all();

        $services = $this->servicesRepository->create($input);

        return $this->sendResponse($services->toArray(), 'Services saved successfully');
    }

    /**
     * Display the specified Services.
     * GET|HEAD /services/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     * Update the specified Services in storage.
     * PUT/PATCH /services/{id}
     *
     * @param int $id
     * @param UpdateServicesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServicesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        $services = $this->servicesRepository->update($input, $id);

        return $this->sendResponse($services->toArray(), 'Services updated successfully');
    }

    /**
     * Remove the specified Services from storage.
     * DELETE /services/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        $services->delete();

        return $this->sendSuccess('Services deleted successfully');
    }



}
