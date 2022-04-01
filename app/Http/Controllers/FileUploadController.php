<?php
   
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\File; 

  
class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUpload()
    {
        return view('fileUpload');
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function fileUploadPost(Request $request)
    {
        //dd($request);
        $pathBuild = "uploads/".$request->firstUrl."/".$request->secondUrl;
        $request->validate([
            'file' => 'required|mimes:pdf,docx,doc,xlx,xlsx,csv,png,jpg,jpeg|max:2048',
        ]);
        
        $fileName = date('Y-m-d h:i:s').'-'.$request->file->getClientOriginalName();  

        DB::table('activities')->insert([
            'activity_type' => 'File',
            'activity_id' => '',
            'activity_message' => 'File '.$pathBuild.'/'.$fileName.' has been created',
            'created_at' => now()
        ]);

        $request->file->move(public_path($pathBuild), $fileName);
   
        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);
   
    }

    public function getDownload($type, $id, $file){
        
        $pathBuild = "/uploads/".$type."/".$id."/".$file;
        $filePath = public_path("/uploads/".$type."/".$id."/".$file);

        DB::table('activities')->insert([
            'activity_type' => 'File',
            'activity_id' => '',
            'activity_message' => 'File '.$pathBuild.' has been downloaded',
            'created_at' => now()
        ]);

        return Response::download($filePath);
    }

    public function getDelete($type, $id, $file){
        
        $pathBuild = "/uploads/".$type."/".$id."/".$file;
        $filePath = public_path("/uploads/".$type."/".$id."/".$file);

        DB::table('activities')->insert([
            'activity_type' => 'File',
            'activity_id' => '',
            'activity_message' => 'File '.$pathBuild.' has been deleted',
            'created_at' => now()
        ]);

        unlink($filePath); // deletes the file
        return redirect()->to($type."/".$id)->send(); // sendsback to view

    }
}