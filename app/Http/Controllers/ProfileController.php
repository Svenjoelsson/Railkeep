<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Flash;
use App\Models\Users;
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


    public function photo(Request $request)
    {
        $file = $request->file('photo');
        $userid = Auth::user()->id;
        $pathBuild = "uploads/profile/".$userid;
        $filename = $file->getClientOriginalName();
 

        $file->move(public_path($pathBuild), $filename);

        $user = \App\Models\User::where('id', $userid)->update(['photo' => $pathBuild."/".$filename]);

        Flash::success('Profile photo updated successfully.');
        return back();
    }
}
