<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Support\Facades\DB;
use App\DataTables\contactsDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatecontactsRequest;
use App\Http\Requests\UpdatecontactsRequest;
use App\Repositories\contactsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class contactsController extends AppBaseController
{
    /** @var  contactsRepository */
    private $contactsRepository;

    public function __construct(contactsRepository $contactsRepo)
    {
        $this->contactsRepository = $contactsRepo;
    }

    /**
     * Display a listing of the contacts.
     *
     * @param contactsDataTable $contactsDataTable
     * @return Response
     */
    public function index(contactsDataTable $contactsDataTable)
    {
        if (auth()->user()->hasPermissionTo('view contacts')) {
            return $contactsDataTable->render('contacts.index'); 
        } else {
            return view('denied');
        }
    }

    /**
     * Show the form for creating a new contacts.
     *
     * @return Response
     */
    public function create()
    {
        if (auth()->user()->hasPermissionTo('create contacts')) {
            return view('contacts.create');
        } else {
            return view('denied');
        }
    }

    /**
     * Store a newly created contacts in storage.
     *
     * @param CreatecontactsRequest $request
     *
     * @return Response
     */
    public function store(CreatecontactsRequest $request)
    { 
        if (auth()->user()->hasPermissionTo('create contacts')) {
            $input = $request->all();

            $contacts = $this->contactsRepository->create($input);

            $test = DB::table('contact')->latest()->first();
            $id = $test->id;
            $email = $test->email;

            DB::table('activities')->insert([
                'activity_type' => 'Contact',
                'activity_id' => $id,
                'activity_message' => 'Contact has been created',
                'created_at' => now()
            ]);

            Flash::success('Contacts saved successfully.');

            return redirect(route('contacts.index'));
        } else {
            return view('denied');
        }
    }
    /**
     * Display the specified contacts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        if (auth()->user()->hasPermissionTo('view contacts')) {
            $contacts = $this->contactsRepository->find($id);

            if (empty($contacts)) {
                Flash::error('Contacts not found');

                return redirect(route('contacts.index'));
            }

            return view('contacts.show')->with('contacts', $contacts);
        } else {
            return view('denied');
        }
    }

    /**
     * Show the form for editing the specified contacts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        if (auth()->user()->hasPermissionTo('edit contacts')) {
            $contacts = $this->contactsRepository->find($id);

            if (empty($contacts)) {
                Flash::error('Contacts not found');

                return redirect(route('contacts.index'));
            }

            return view('contacts.edit')->with('contacts', $contacts);
        } else {
            return view('denied');
        }
    }

    /**
     * Update the specified contacts in storage.
     *
     * @param  int              $id
     * @param UpdatecontactsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecontactsRequest $request)
    {
        if (auth()->user()->hasPermissionTo('edit contacts')) {

            $contacts = $this->contactsRepository->find($id);

            if (empty($contacts)) {
                Flash::error('Contacts not found');

                return redirect(route('contacts.index'));
            }

            $contacts = $this->contactsRepository->update($request->all(), $id);

            Flash::success('Contacts updated successfully.');

            return redirect(route('contacts.index'));
        } else {
            return view('denied');
        }
    }

    /**
     * Remove the specified contacts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if (auth()->user()->hasPermissionTo('delete contacts')) {
            $contacts = $this->contactsRepository->find($id);

            if (empty($contacts)) {
                Flash::error('Contacts not found');

                return redirect(route('contacts.index'));
            }

            $this->contactsRepository->delete($id);

            Flash::success('Contacts deleted successfully.');

            return redirect(route('contacts.index'));
        } else {
            return view('denied');
        }
    }
}
