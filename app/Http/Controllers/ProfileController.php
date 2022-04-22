<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Flash;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;
use Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


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

        if (auth()->user()->hasPermissionTo('view profile')) {
            return view('profile');
        } else {
            return view('denied');
        }
        
    }


    public function photo(Request $request)
    {
        if (auth()->user()->hasPermissionTo('edit profile')) {
            $file = $request->file('photo');
            $userid = Auth::user()->id;
            $pathBuild = "uploads/profile/".$userid;
            $filename = $file->getClientOriginalName();
    

            $file->move(public_path($pathBuild), $filename);

            $user = \App\Models\User::where('id', $userid)->update(['photo' => $pathBuild."/".$filename]);

            Flash::success('Profile photo updated successfully.');
            return back(); 
        } else {
            return view('denied');
        }
    }
}
