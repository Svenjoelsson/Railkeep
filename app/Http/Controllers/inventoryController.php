<?php

namespace App\Http\Controllers;

use App\DataTables\inventoryDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateinventoryRequest;
use App\Http\Requests\UpdateinventoryRequest;
use App\Repositories\inventoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class inventoryController extends AppBaseController
{
    /** @var  inventoryRepository */
    private $inventoryRepository;

    public function __construct(inventoryRepository $inventoryRepo)
    {
        $this->inventoryRepository = $inventoryRepo;

        // Spatie permissions
        $this->middleware('permission:view parts')->only('index');
        $this->middleware('permission:create parts')->only('create');
        $this->middleware('permission:create parts')->only('store');
        $this->middleware('permission:view parts')->only('show');
        $this->middleware('permission:edit parts')->only('edit');
        $this->middleware('permission:edit parts')->only('update');
        $this->middleware('permission:delete parts')->only('destroy');
    }

    /**
     * Display a listing of the inventory.
     *
     * @param inventoryDataTable $inventoryDataTable
     * @return Response
     */
    public function index(inventoryDataTable $inventoryDataTable)
    {
        return $inventoryDataTable->render('inventories.index');
    }

    /**
     * Show the form for creating a new inventory.
     *
     * @return Response
     */
    public function create()
    {
        return view('inventories.create');
    }

    /**
     * Store a newly created inventory in storage.
     *
     * @param CreateinventoryRequest $request
     *
     * @return Response
     */
    public function store(CreateinventoryRequest $request)
    {
        $input = $request->all();

        $inventory = $this->inventoryRepository->create($input);

        Flash::success('Inventory saved successfully.');

        return redirect(route('inventories.index'));
    }

    /**
     * Display the specified inventory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            Flash::error('Inventory not found');

            return redirect(route('inventories.index'));
        }

        return view('inventories.show')->with('inventory', $inventory);
    }

    /**
     * Show the form for editing the specified inventory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            Flash::error('Inventory not found');

            return redirect(route('inventories.index'));
        }

        return view('inventories.edit')->with('inventory', $inventory);
    }

    /**
     * Update the specified inventory in storage.
     *
     * @param  int              $id
     * @param UpdateinventoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateinventoryRequest $request)
    {
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            Flash::error('Inventory not found');

            return redirect(route('inventories.index'));
        }

        $inventory = $this->inventoryRepository->update($request->all(), $id);

        Flash::success('Inventory updated successfully.');

        return redirect(route('inventories.index'));
    }

    /**
     * Remove the specified inventory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            Flash::error('Inventory not found');

            return redirect(route('inventories.index'));
        }

        $this->inventoryRepository->delete($id);

        Flash::success('Inventory deleted successfully.');

        return redirect(route('inventories.index'));
    }

    public function mount(Request $request)
    {
        //dd($request);
        \App\Models\Inventory::where('id', $request->part)->update(['unit' => $request->unit]);
        $unit = \App\Models\Units::where('unit', $request->unit)->first();

        \App\Models\InventoryLog::insert(['unit' => $unit->id, 'part' => $request->part, 'comment' => $request->comment, 'dateMounted' => $request->mountDate, 'counter' => '0']);
        \App\Models\Activities::insert(['activity_type' => 'Unit', 'activity_id' => $unit->id, 'activity_message' => 'Part #'.$request->part." has been mounted", 'created_at' => now()]);


        return back();
    }
}
