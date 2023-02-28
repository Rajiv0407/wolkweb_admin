<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\model\contacts;
use Redirect,Response,DB,Config;
use Mail;

class contactUs extends Controller
{
   public function contactUs(Request $request){
       // $data=contacts::all()->toArray() ;
      
   		$validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'subject' => 'required',
        'message' => 'required'
        ]);

         if($validator->fails()){      
         	 return $this->errorResponse($validator->errors()->first(), 401);
         }else{
          /*insert data in contactus*/
           $data = $request->input();
          try{

              $contactUs = new contacts;
              $contactUs->email = $data['email'];
              $contactUs->subject = $data['subject'];
              $contactUs->message = $data['message'];
              $contactUs->save();

              $email=$this->sendEmail($data);

              if($email){
                return $this->successResponse([],"Submit successfully",200);    
              }else{
                return $this->successResponse([],"Email not send",200);  
              }
              
              return $this->successResponse([],"Submit successfully",200);   
             
            }
            catch(Exception $e){
              return $this->errorResponse('Error Occurred', 401);
            }

        
          
         }

         
   }



   public function sendEmail(Array $data){

       $data = array(
        'email' => $data['email'],
        'subject' =>  $data['subject'],
        'messages' => $data['message']
        );

        //htmlspecialchars()
    
         Mail::send('emails.contactUs', $data, function($message) use ($data) {
          $to= $data['email'] ;
          $recieverName = "LesGo ContactUs" ;
          $subject = $data['subject'] ;
         
            $message->to($to,$recieverName)->subject($subject);
                    
        });
 
        if (Mail::failures()) {
          // return response()->Fail('Sorry! Please try again latter');
          //echo "Something Error Occured" ;
          return false ;
         }else{
          return true ;
          //echo "Mail send successfully" ;
          // return response()->success('Great! Successfully send in your mail');
         }
   }
}
