<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class profileController extends AppBaseController
{

    /**
     * Display the specified customers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function index()
    {
        return view('profile');
    }
}
