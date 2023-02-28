<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Redirect,Response,DB,Config;
use Mail;
class EmailController extends Controller
{ 
    public function sendEmail()
    {
        $data['title'] = "LesGo Start Project from Today";
 		
		//echo view('emails/email',$data);
		// exit ;

        Mail::send('emails.email', $data, function($message) {
         	$to1="amitshukla291988@gmail.com" ;
         	$recieverName = "Amit Shukla" ;
 		$subject = "User Registration" ;

            $message->to($to1,$recieverName)->subject($subject);
 
                    
        });
 
        if (Mail::failures()) {
          // return response()->Fail('Sorry! Please try again latter');
        	echo "Something Error Occured" ;
         }else{
         	echo "Mail send successfully" ;
          // return response()->success('Great! Successfully send in your mail');
         }
    }
}
