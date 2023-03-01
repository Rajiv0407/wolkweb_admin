<?php 




function test(){
	echo "hello";
}

function authguard(){

 $token=Auth::guard('api')->user();
 return $token ;
 // if(empty($token)){
 // 	$token=array();
 // }
 

}


   function sendPasswordToEmail(Array $data){

       $data = array(
        'email' => $data['email'],
        'subject' =>  $data['subject'],
        'messages' => $data['message']
        );

       
    
         Mail::send('emails.password', $data, function($message) use ($data) {
          $to= $data['email'] ;
          $recieverName = "" ;
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



function userfollowers($userId){
      return $followers = DB::table('social_info')->select(DB::raw('sum(followers_count) as totalFollowers'))->where('status',1)->where('user_id',$userId)->get();
}


function createdAt($created_at)
    {
        
        $created_at = str_replace([' seconds', ' second'], ' sec', $created_at);
        $created_at = str_replace([' minutes', ' minute'], ' min', $created_at);
        $created_at = str_replace([' hours', ' hour'], ' h', $created_at);
        $created_at = str_replace([' months', ' month'], ' m', $created_at);
        $created_at = str_replace([' before'], ' ago', $created_at);
        if(preg_match('(years|year)', $created_at)){
            $created_at = $this->created_at->toFormattedDateString();
        }

        return $created_at;
    }


function countryList(){
   $countries = DB::table('pe_countries')->select('i_id','v_title',DB::raw('api_code as countryCode'))->where('i_status',1)->get();
   return $countries ;
}

function do_upload_unlink($unlink_data=array()){

  if(!empty($unlink_data)){

    foreach($unlink_data as $val){

      if(File::exists($val)) { 
      
      unlink($val);
      }
  }

  }
 }

 function printQuery($query){
  DB::enableQueryLog();
   $query ;
   
   print_r(\DB::getQueryLog());
 }


function auth_check(){

    $get_SessionData = Session::get('admin_session');
    
    if(empty($get_SessionData)){
      
        return redirect()->to('/administrator')->send();
    }

}


 ?>