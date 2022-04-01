<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRentAPIRequest;
use App\Http\Requests\API\UpdateRentAPIRequest;
use App\Models\Rent;
use App\Repositories\RentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RentController
 * @package App\Http\Controllers\API
 */

class RentAPIController extends AppBaseController
{
    /** @var  RentRepository */
    private $rentRepository;

    public function __construct(RentRepository $rentRepo)
    {
        $this->rentRepository = $rentRepo;
    }

    /**
     * Display a listing of the Rent.
     * GET|HEAD /rents
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $rents = $this->rentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($rents->toArray(), 'Rents retrieved successfully');
    }

    /**
     * Store a newly created Rent in storage.
     * POST /rents
     *
     * @param CreateRentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRentAPIRequest $request)
    {
        $input = $request->all();

        $rent = $this->rentRepository->create($input);

        return $this->sendResponse($rent->toArray(), 'Rent saved successfully');
    }

    /**
     * Display the specified Rent.
     * GET|HEAD /rents/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Rent $rent */
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            return $this->sendError('Rent not found');
        }

        return $this->sendResponse($rent->toArray(), 'Rent retrieved successfully');
    }

    /**
     * Update the specified Rent in storage.
     * PUT/PATCH /rents/{id}
     *
     * @param int $id
     * @param UpdateRentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Rent $rent */
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            return $this->sendError('Rent not found');
        }

        $rent = $this->rentRepository->update($input, $id);

        return $this->sendResponse($rent->toArray(), 'Rent updated successfully');
    }

    /**
     * Remove the specified Rent from storage.
     * DELETE /rents/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Rent $rent */
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            return $this->sendError('Rent not found');
        }

        $rent->delete();

        return $this->sendSuccess('Rent deleted successfully');
    }
}
