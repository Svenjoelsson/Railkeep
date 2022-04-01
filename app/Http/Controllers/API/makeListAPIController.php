<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatemakeListAPIRequest;
use App\Http\Requests\API\UpdatemakeListAPIRequest;
use App\Models\makeList;
use App\Repositories\makeListRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class makeListController
 * @package App\Http\Controllers\API
 */

class makeListAPIController extends AppBaseController
{
    /** @var  makeListRepository */
    private $makeListRepository;

    public function __construct(makeListRepository $makeListRepo)
    {
        $this->makeListRepository = $makeListRepo;
    }

    /**
     * Display a listing of the makeList.
     * GET|HEAD /makeLists
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sort = $request->get('makeList', null);

        $makeLists = makeList::when($sort, function ($query) use ($sort) {
            // can use the $sort var here if you wish to pass the column or asc/desc
            $query->orderBy('level', 'desc');
        })->get();
        

        //return $this->sendResponse($sort->toArray(), 'Make Lists retrieved successfully');
        return $this->sendResponse($makeLists->toArray(), 'Make Lists retrieved successfully');
    }

    /**
     * Store a newly created makeList in storage.
     * POST /makeLists
     *
     * @param CreatemakeListAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatemakeListAPIRequest $request)
    {
        $input = $request->all();

        $makeList = $this->makeListRepository->create($input);

        return $this->sendResponse($makeList->toArray(), 'Make List saved successfully');
    }

    /**
     * Display the specified makeList.
     * GET|HEAD /makeLists/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var makeList $makeList */
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            return $this->sendError('Make List not found');
        }

        return $this->sendResponse($makeList->toArray(), 'Make List retrieved successfully');
    }

    /**
     * Update the specified makeList in storage.
     * PUT/PATCH /makeLists/{id}
     *
     * @param int $id
     * @param UpdatemakeListAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemakeListAPIRequest $request)
    {
        $input = $request->all();

        /** @var makeList $makeList */
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            return $this->sendError('Make List not found');
        }

        $makeList = $this->makeListRepository->update($input, $id);

        return $this->sendResponse($makeList->toArray(), 'makeList updated successfully');
    }

    /**
     * Remove the specified makeList from storage.
     * DELETE /makeLists/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var makeList $makeList */
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            return $this->sendError('Make List not found');
        }

        $makeList->delete();

        return $this->sendSuccess('Make List deleted successfully');
    }
}
