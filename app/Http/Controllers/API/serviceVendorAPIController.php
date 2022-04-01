<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateserviceVendorAPIRequest;
use App\Http\Requests\API\UpdateserviceVendorAPIRequest;
use App\Models\serviceVendor;
use App\Repositories\serviceVendorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class serviceVendorController
 * @package App\Http\Controllers\API
 */

class serviceVendorAPIController extends AppBaseController
{
    /** @var  serviceVendorRepository */
    private $serviceVendorRepository;

    public function __construct(serviceVendorRepository $serviceVendorRepo)
    {
        $this->serviceVendorRepository = $serviceVendorRepo;
    }

    /**
     * Display a listing of the serviceVendor.
     * GET|HEAD /serviceVendors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceVendors = $this->serviceVendorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($serviceVendors->toArray(), 'Service Vendors retrieved successfully');
    }

    /**
     * Store a newly created serviceVendor in storage.
     * POST /serviceVendors
     *
     * @param CreateserviceVendorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceVendorAPIRequest $request)
    {
        $input = $request->all();

        $serviceVendor = $this->serviceVendorRepository->create($input);

        return $this->sendResponse($serviceVendor->toArray(), 'Service Vendor saved successfully');
    }

    /**
     * Display the specified serviceVendor.
     * GET|HEAD /serviceVendors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var serviceVendor $serviceVendor */
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            return $this->sendError('Service Vendor not found');
        }

        return $this->sendResponse($serviceVendor->toArray(), 'Service Vendor retrieved successfully');
    }

    /**
     * Update the specified serviceVendor in storage.
     * PUT/PATCH /serviceVendors/{id}
     *
     * @param int $id
     * @param UpdateserviceVendorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceVendorAPIRequest $request)
    {
        $input = $request->all();

        /** @var serviceVendor $serviceVendor */
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            return $this->sendError('Service Vendor not found');
        }

        $serviceVendor = $this->serviceVendorRepository->update($input, $id);

        return $this->sendResponse($serviceVendor->toArray(), 'serviceVendor updated successfully');
    }

    /**
     * Remove the specified serviceVendor from storage.
     * DELETE /serviceVendors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var serviceVendor $serviceVendor */
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            return $this->sendError('Service Vendor not found');
        }

        $serviceVendor->delete();

        return $this->sendSuccess('Service Vendor deleted successfully');
    }
}
