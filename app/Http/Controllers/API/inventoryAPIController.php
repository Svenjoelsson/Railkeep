<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateinventoryAPIRequest;
use App\Http\Requests\API\UpdateinventoryAPIRequest;
use App\Models\inventory;
use App\Repositories\inventoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class inventoryController
 * @package App\Http\Controllers\API
 */

class inventoryAPIController extends AppBaseController
{
    /** @var  inventoryRepository */
    private $inventoryRepository;

    public function __construct(inventoryRepository $inventoryRepo)
    {
        $this->inventoryRepository = $inventoryRepo;
    }

    /**
     * Display a listing of the inventory.
     * GET|HEAD /inventories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $inventories = $this->inventoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($inventories->toArray(), 'Inventories retrieved successfully');
    }

    /**
     * Store a newly created inventory in storage.
     * POST /inventories
     *
     * @param CreateinventoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateinventoryAPIRequest $request)
    {
        $input = $request->all();

        $inventory = $this->inventoryRepository->create($input);

        return $this->sendResponse($inventory->toArray(), 'Inventory saved successfully');
    }

    /**
     * Display the specified inventory.
     * GET|HEAD /inventories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        return $this->sendResponse($inventory->toArray(), 'Inventory retrieved successfully');
    }

    /**
     * Update the specified inventory in storage.
     * PUT/PATCH /inventories/{id}
     *
     * @param int $id
     * @param UpdateinventoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateinventoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory = $this->inventoryRepository->update($input, $id);

        return $this->sendResponse($inventory->toArray(), 'inventory updated successfully');
    }

    /**
     * Remove the specified inventory from storage.
     * DELETE /inventories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory->delete();

        return $this->sendSuccess('Inventory deleted successfully');
    }
}
