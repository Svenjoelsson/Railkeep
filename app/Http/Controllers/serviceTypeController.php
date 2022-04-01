<?php

namespace App\Http\Controllers;

use App\DataTables\serviceTypeDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateserviceTypeRequest;
use App\Http\Requests\UpdateserviceTypeRequest;
use App\Repositories\serviceTypeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class serviceTypeController extends AppBaseController
{
    /** @var  serviceTypeRepository */
    private $serviceTypeRepository;

    public function __construct(serviceTypeRepository $serviceTypeRepo)
    {
        $this->serviceTypeRepository = $serviceTypeRepo;
    }

    /**
     * Display a listing of the serviceType.
     *
     * @param serviceTypeDataTable $serviceTypeDataTable
     * @return Response
     */
    public function index(serviceTypeDataTable $serviceTypeDataTable)
    {
        return $serviceTypeDataTable->render('service_types.index');
    }

    /**
     * Show the form for creating a new serviceType.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_types.create');
    }

    /**
     * Store a newly created serviceType in storage.
     *
     * @param CreateserviceTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceTypeRequest $request)
    {
        $input = $request->all();

        $serviceType = $this->serviceTypeRepository->create($input);

        Flash::success('Service Type saved successfully.');

        return redirect(route('serviceTypes.index'));
    }

    /**
     * Display the specified serviceType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            Flash::error('Service Type not found');

            return redirect(route('serviceTypes.index'));
        }

        return view('service_types.show')->with('serviceType', $serviceType);
    }

    /**
     * Show the form for editing the specified serviceType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            Flash::error('Service Type not found');

            return redirect(route('serviceTypes.index'));
        }

        return view('service_types.edit')->with('serviceType', $serviceType);
    }

    /**
     * Update the specified serviceType in storage.
     *
     * @param  int              $id
     * @param UpdateserviceTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceTypeRequest $request)
    {
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            Flash::error('Service Type not found');

            return redirect(route('serviceTypes.index'));
        }

        $serviceType = $this->serviceTypeRepository->update($request->all(), $id);

        Flash::success('Service Type updated successfully.');

        return redirect(route('serviceTypes.index'));
    }

    /**
     * Remove the specified serviceType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceType = $this->serviceTypeRepository->find($id);

        if (empty($serviceType)) {
            Flash::error('Service Type not found');

            return redirect(route('serviceTypes.index'));
        }

        $this->serviceTypeRepository->delete($id);

        Flash::success('Service Type deleted successfully.');

        return redirect(route('serviceTypes.index'));
    }
}
