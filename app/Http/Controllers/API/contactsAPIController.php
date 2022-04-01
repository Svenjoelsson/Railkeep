<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecontactsAPIRequest;
use App\Http\Requests\API\UpdatecontactsAPIRequest;
use App\Models\contacts;
use App\Repositories\contactsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class contactsController
 * @package App\Http\Controllers\API
 */

class contactsAPIController extends AppBaseController
{
    /** @var  contactsRepository */
    private $contactsRepository;

    public function __construct(contactsRepository $contactsRepo)
    {
        $this->contactsRepository = $contactsRepo;
    }

    /**
     * Display a listing of the contacts.
     * GET|HEAD /contacts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $contacts = $this->contactsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($contacts->toArray(), 'Contacts retrieved successfully');
    }

    /**
     * Store a newly created contacts in storage.
     * POST /contacts
     *
     * @param CreatecontactsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatecontactsAPIRequest $request)
    {
        $input = $request->all();

        $contacts = $this->contactsRepository->create($input);

        return $this->sendResponse($contacts->toArray(), 'Contacts saved successfully');
    }

    /**
     * Display the specified contacts.
     * GET|HEAD /contacts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var contacts $contacts */
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            return $this->sendError('Contacts not found');
        }

        return $this->sendResponse($contacts->toArray(), 'Contacts retrieved successfully');
    }

    /**
     * Update the specified contacts in storage.
     * PUT/PATCH /contacts/{id}
     *
     * @param int $id
     * @param UpdatecontactsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecontactsAPIRequest $request)
    {
        $input = $request->all();

        /** @var contacts $contacts */
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            return $this->sendError('Contacts not found');
        }

        $contacts = $this->contactsRepository->update($input, $id);

        return $this->sendResponse($contacts->toArray(), 'contacts updated successfully');
    }

    /**
     * Remove the specified contacts from storage.
     * DELETE /contacts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var contacts $contacts */
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            return $this->sendError('Contacts not found');
        }

        $contacts->delete();

        return $this->sendSuccess('Contacts deleted successfully');
    }
}
