<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecustomersAPIRequest;
use App\Http\Requests\API\UpdatecustomersAPIRequest;
use App\Models\Customers;
use App\Repositories\customersRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class customersController
 * @package App\Http\Controllers\API
 */

class customersAPIController extends AppBaseController
{
    /** @var  customersRepository */
    private $customersRepository;

    public function __construct(customersRepository $customersRepo)
    {
        $this->customersRepository = $customersRepo;
    }

    /**
     * Display a listing of the customers.
     * GET|HEAD /customers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $customers = $this->customersRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Store a newly created customers in storage.
     * POST /customers
     *
     * @param CreatecustomersAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatecustomersAPIRequest $request)
    {
        $input = $request->all();

        $customers = $this->customersRepository->create($input);

        return $this->sendResponse($customers->toArray(), 'Customers saved successfully');
    }

    /**
     * Display the specified customers.
     * GET|HEAD /customers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var customers $customers */
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        return $this->sendResponse($customers->toArray(), 'Customers retrieved successfully');
    }

    /**
     * Update the specified customers in storage.
     * PUT/PATCH /customers/{id}
     *
     * @param int $id
     * @param UpdatecustomersAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecustomersAPIRequest $request)
    {
        $input = $request->all();

        /** @var customers $customers */
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        $customers = $this->customersRepository->update($input, $id);

        return $this->sendResponse($customers->toArray(), 'customers updated successfully');
    }

    /**
     * Remove the specified customers from storage.
     * DELETE /customers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var customers $customers */
        $customers = $this->customersRepository->find($id);

        if (empty($customers)) {
            return $this->sendError('Customers not found');
        }

        $customers->delete();

        return $this->sendSuccess('Customers deleted successfully');
    }
}
