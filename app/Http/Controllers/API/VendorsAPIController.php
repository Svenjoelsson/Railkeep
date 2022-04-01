<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVendorsAPIRequest;
use App\Http\Requests\API\UpdateVendorsAPIRequest;
use App\Models\Vendors;
use App\Repositories\VendorsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VendorsController
 * @package App\Http\Controllers\API
 */

class VendorsAPIController extends AppBaseController
{
    /** @var  VendorsRepository */
    private $vendorsRepository;

    public function __construct(VendorsRepository $vendorsRepo)
    {
        $this->vendorsRepository = $vendorsRepo;
    }

    /**
     * Display a listing of the Vendors.
     * GET|HEAD /vendors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $vendors = $this->vendorsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($vendors->toArray(), 'Vendors retrieved successfully');
    }

    /**
     * Store a newly created Vendors in storage.
     * POST /vendors
     *
     * @param CreateVendorsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVendorsAPIRequest $request)
    {
        $input = $request->all();

        $vendors = $this->vendorsRepository->create($input);

        return $this->sendResponse($vendors->toArray(), 'Vendors saved successfully');
    }

    /**
     * Display the specified Vendors.
     * GET|HEAD /vendors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Vendors $vendors */
        $vendors = $this->vendorsRepository->find($id);

        if (empty($vendors)) {
            return $this->sendError('Vendors not found');
        }

        return $this->sendResponse($vendors->toArray(), 'Vendors retrieved successfully');
    }

    /**
     * Update the specified Vendors in storage.
     * PUT/PATCH /vendors/{id}
     *
     * @param int $id
     * @param UpdateVendorsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVendorsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Vendors $vendors */
        $vendors = $this->vendorsRepository->find($id);

        if (empty($vendors)) {
            return $this->sendError('Vendors not found');
        }

        $vendors = $this->vendorsRepository->update($input, $id);

        return $this->sendResponse($vendors->toArray(), 'Vendors updated successfully');
    }

    /**
     * Remove the specified Vendors from storage.
     * DELETE /vendors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Vendors $vendors */
        $vendors = $this->vendorsRepository->find($id);

        if (empty($vendors)) {
            return $this->sendError('Vendors not found');
        }

        $vendors->delete();

        return $this->sendSuccess('Vendors deleted successfully');
    }
}
