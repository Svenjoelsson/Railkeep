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
        return $contactsDataTable->render('contacts.index');
    }

    /**
     * Show the form for creating a new contacts.
     *
     * @return Response
     */
    public function create()
    {
        return view('contacts.create');
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

        /*
        $data = array('name' => $input['name'], 'messege' => 'Your email and data has been stored in our database to be able to contact you easier. If you no longer wish to be contact by us, please reply to this email.');
        Mail::send('email/contact', $data, function($message) use ($input) {
           $message->to($input['email'], $input['name'])->subject
              ('Nordic Re finance');
           $message->from('joel@gjerdeinvest.se','Lara message');
        });
        */

        Flash::success('Contacts saved successfully.');

        return redirect(route('contacts.index'));
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
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            Flash::error('Contacts not found');

            return redirect(route('contacts.index'));
        }

        return view('contacts.show')->with('contacts', $contacts);
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
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            Flash::error('Contacts not found');

            return redirect(route('contacts.index'));
        }

        return view('contacts.edit')->with('contacts', $contacts);
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
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            Flash::error('Contacts not found');

            return redirect(route('contacts.index'));
        }

        $contacts = $this->contactsRepository->update($request->all(), $id);

        Flash::success('Contacts updated successfully.');

        return redirect(route('contacts.index'));
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
        $contacts = $this->contactsRepository->find($id);

        if (empty($contacts)) {
            Flash::error('Contacts not found');

            return redirect(route('contacts.index'));
        }

        $this->contactsRepository->delete($id);

        Flash::success('Contacts deleted successfully.');

        return redirect(route('contacts.index'));
    }
}
