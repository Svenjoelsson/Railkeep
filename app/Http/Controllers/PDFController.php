<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use DomPDF;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y')
        ];
          
        $pdf = DomPDF::loadView('myPDF', $data);
    
        return $pdf->download('itsolutionstuff.pdf');
    }
}