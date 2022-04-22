<?php

namespace App\Http\Controllers;

use App\DataTables\makeListDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatemakeListRequest;
use App\Http\Requests\UpdatemakeListRequest;
use App\Repositories\makeListRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class makeListController extends AppBaseController
{
    /** @var  makeListRepository */
    private $makeListRepository;

    public function __construct(makeListRepository $makeListRepo)
    {
        $this->makeListRepository = $makeListRepo;

        // Spatie permissions
        $this->middleware('permission:view serviceplan')->only('index');
        $this->middleware('permission:create serviceplan')->only('create');
        $this->middleware('permission:create serviceplan')->only('store');
        $this->middleware('permission:view serviceplan')->only('show');
        $this->middleware('permission:edit serviceplan')->only('edit');
        $this->middleware('permission:edit serviceplan')->only('update');
        $this->middleware('permission:delete serviceplan')->only('destroy');
    }

    /**
     * Display a listing of the makeList.
     *
     * @param makeListDataTable $makeListDataTable
     * @return Response
     */
    public function index(makeListDataTable $makeListDataTable)
    {
        return $makeListDataTable->render('make_lists.index');
    }

    /**
     * Show the form for creating a new makeList.
     *
     * @return Response
     */
    public function create()
    {
        return view('make_lists.create');
    }

    /**
     * Store a newly created makeList in storage.
     *
     * @param CreatemakeListRequest $request
     *
     * @return Response
     */
    public function store(CreatemakeListRequest $request)
    {
        $input = $request->all();

        $makeList = $this->makeListRepository->create($input);

        Flash::success('Make List saved successfully.');

        return redirect(route('makeLists.index'));
    }

    /**
     * Display the specified makeList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            Flash::error('Make List not found');

            return redirect(route('makeLists.index'));
        }

        return view('make_lists.show')->with('makeList', $makeList);
    }

    /**
     * Show the form for editing the specified makeList.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            Flash::error('Make List not found');

            return redirect(route('makeLists.index'));
        }

        return view('make_lists.edit')->with('makeList', $makeList);
    }

    /**
     * Update the specified makeList in storage.
     *
     * @param  int              $id
     * @param UpdatemakeListRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemakeListRequest $request)
    {
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            Flash::error('Make List not found');

            return redirect(route('makeLists.index'));
        }

        $makeList = $this->makeListRepository->update($request->all(), $id);

        Flash::success('Make List updated successfully.');

        return redirect(route('makeLists.index'));
    }

    /**
     * Remove the specified makeList from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $makeList = $this->makeListRepository->find($id);

        if (empty($makeList)) {
            Flash::error('Make List not found');

            return redirect(route('makeLists.index'));
        }

        $this->makeListRepository->delete($id);

        Flash::success('Make List deleted successfully.');

        return redirect(route('makeLists.index'));
    }
}
