<?php

namespace App\Http\Controllers;

use App\DataTables\serviceVendorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateserviceVendorRequest;
use App\Http\Requests\UpdateserviceVendorRequest;
use App\Repositories\serviceVendorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class serviceVendorController extends AppBaseController
{
    /** @var  serviceVendorRepository */
    private $serviceVendorRepository;

    public function __construct(serviceVendorRepository $serviceVendorRepo)
    {
        $this->serviceVendorRepository = $serviceVendorRepo;
    }

    /**
     * Display a listing of the serviceVendor.
     *
     * @param serviceVendorDataTable $serviceVendorDataTable
     * @return Response
     */
    public function index(serviceVendorDataTable $serviceVendorDataTable)
    {
        return $serviceVendorDataTable->render('service_vendors.index');
    }

    /**
     * Show the form for creating a new serviceVendor.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_vendors.create');
    }

    /**
     * Store a newly created serviceVendor in storage.
     *
     * @param CreateserviceVendorRequest $request
     *
     * @return Response
     */
    public function store(CreateserviceVendorRequest $request)
    {
        $input = $request->all();

        $serviceVendor = $this->serviceVendorRepository->create($input);

        Flash::success('Service Vendor saved successfully.');

        return redirect(route('serviceVendors.index'));
    }

    /**
     * Display the specified serviceVendor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            Flash::error('Service Vendor not found');

            return redirect(route('serviceVendors.index'));
        }

        return view('service_vendors.show')->with('serviceVendor', $serviceVendor);
    }

    /**
     * Show the form for editing the specified serviceVendor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            Flash::error('Service Vendor not found');

            return redirect(route('serviceVendors.index'));
        }

        return view('service_vendors.edit')->with('serviceVendor', $serviceVendor);
    }

    /**
     * Update the specified serviceVendor in storage.
     *
     * @param  int              $id
     * @param UpdateserviceVendorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateserviceVendorRequest $request)
    {
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            Flash::error('Service Vendor not found');

            return redirect(route('serviceVendors.index'));
        }

        $serviceVendor = $this->serviceVendorRepository->update($request->all(), $id);

        Flash::success('Service Vendor updated successfully.');

        return redirect(route('serviceVendors.index'));
    }

    /**
     * Remove the specified serviceVendor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceVendor = $this->serviceVendorRepository->find($id);

        if (empty($serviceVendor)) {
            Flash::error('Service Vendor not found');

            return redirect(route('serviceVendors.index'));
        }

        $this->serviceVendorRepository->delete($id);

        Flash::success('Service Vendor deleted successfully.');

        return redirect(route('serviceVendors.index'));
    }
}
