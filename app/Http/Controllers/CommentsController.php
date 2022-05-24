<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;


class CommentsController extends Controller
{
    public function newComment(Request $request)
    {
        $input = $request->all();
        $created_by = Auth::user()->name;
        
        \App\Models\Comments::insert([
            'model_type' => $input["model_type"], 
            'model_id' => $input["model_id"], 
            'comment' =>  $input["comment"], 
            'created_by' =>  $created_by, 
            'created_at' => now()
        ]);

        DB::table('activities')->insert([
            'activity_type' => 'Unit',
            'activity_id' => $input["model_id"],
            'activity_message' => 'A new comment has been created',
            'created_at' => now()
        ]);


        return back();
    }
}
