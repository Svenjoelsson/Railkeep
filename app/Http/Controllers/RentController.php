<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DataTables\RentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Repositories\RentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Redirect;

class RentController extends AppBaseController
{
    /** @var  RentRepository */
    private $rentRepository;

    public function __construct(RentRepository $rentRepo)
    {
        $this->rentRepository = $rentRepo;
    }

    /**
     * Display a listing of the Rent.
     *
     * @param RentDataTable $rentDataTable
     * @return Response
     */
    public function index(RentDataTable $rentDataTable)
    {
        return $rentDataTable->render('rents.index');
    }

    /**
     * Show the form for creating a new Rent.
     *
     * @return Response
     */
    public function create()
    {
        return view('rents.create');
    }

    /**
     * Store a newly created Rent in storage.
     *
     * @param CreateRentRequest $request
     *
     * @return Response
     */
    public function store(CreateRentRequest $request)
    {
        $input = $request->all();
        $unit = \App\Models\Rent::where('status', 'Active')->where('unit', $input["unit"])->first();

        if ($unit && $input["status"] == 'Active') {
            Flash::error('Unit '.$input["unit"].' with status Active already exists.');
            return Redirect::back()->withErrors(['msg' => 'Unit '.$input["unit"].' already exist with status Active. You can only have one with Active status at the same time.']);
        }
        

        if ($input["status"] === 'Done') {

            if ($request->rentEnd == null) {
                Flash::error('End date must be filled in.');
                return redirect(route('rents.index'));
            }
        }


        if ($input["unit"]) {

        }

        // Change customer on unit
        DB::table('units')
        ->where('unit', $input["unit"])
        ->update(['customer' => $input["customer"]]);

        // Creates activity
        DB::table('activities')->insert([
            'activity_type' => 'Rent',
            'activity_id' => '',
            'activity_message' => 'Rent on unit '.$input["unit"].' has been updated.',
            'created_at' => now()
        ]);

        $rent = $this->rentRepository->create($input);

        Flash::success('Rent saved successfully.');

        return redirect(route('rents.index'));
    }

    /**
     * Display the specified Rent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            Flash::error('Rent not found');

            return redirect(route('rents.index'));
        }

        return view('rents.show')->with('rent', $rent);
    }

    /**
     * Show the form for editing the specified Rent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            Flash::error('Rent not found');

            return redirect(route('rents.index'));
        }

        return view('rents.edit')->with('rent', $rent);
    }

    /**
     * Update the specified Rent in storage.
     *
     * @param  int              $id
     * @param UpdateRentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRentRequest $request)
    {
        $rent = $this->rentRepository->find($id);


        if ($request->status === 'Done') {

            if ($request->rentEnd == null) {
                Flash::error('End date must be filled in.');

                return redirect(route('rents.index'));
            }


            DB::table('units')
            ->where('unit', $request->unit)
            ->update(['customer' => '']);


        } else {
            DB::table('units')
            ->where('unit', $request->unit)
            ->update(['customer' => $request->customer]);
        }




        if (empty($rent)) {
            Flash::error('Rent not found');

            return redirect(route('rents.index'));
        }
        
        $rent = $this->rentRepository->update($request->all(), $id);

        Flash::success('Rent updated successfully.');

        return redirect(route('rents.index'));
    }

    /**
     * Remove the specified Rent from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $rent = $this->rentRepository->find($id);

        if (empty($rent)) {
            Flash::error('Rent not found');

            return redirect(route('rents.index'));
        }

        $this->rentRepository->delete($id);

        Flash::success('Rent deleted successfully.');

        return redirect(route('rents.index'));
    }
}
