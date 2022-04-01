<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller {
   public function basic_email() {


      $data = array('name'=>"Virat Gandhi");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('joel@gjerdeinvest.se', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('joel@gjerdeinvest.se','Joel Gandhi');
      });
      echo "Basic Email Sent. Check your inbox.";
   }



   public function html_email() {
      $data = array('name' => 'Joel Gjerde', 'messege' => 'Your email and data has been stored in our database to be able to contact you easier. \n If you no longer wish to be contact by us, please reply to this email.');
      Mail::send('mail', $data, function($message) {
         $message->to('joel@gjerdeinvest.se', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('joel@gjerdeinvest.se','Joel Gandhi');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"Virat Gandhi");
      Mail::send('mail', $data, function($message) {
         $message->to('joel@gjerdeinvest.se', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         //$message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         //$message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('joel@gjerdeinvest.se','Virat Gandhi');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}