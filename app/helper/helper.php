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
       $type=isset($data['type'])?$data['type']:'' ;

       $data = array(
        'email' => $data['email'],
        'subject' =>  $data['subject'],
        'messages' => $data['message']
        );

        if($type=='user_subscribers'){
          Mail::send('emails.subscribers', $data, function($message) use ($data) {
            $to= $data['email'] ;
            $recieverName = "" ;
            $subject = $data['subject'] ;         
              $message->to($to,$recieverName)->subject($subject);                    
          });
        }else{
          Mail::send('emails.password', $data, function($message) use ($data) {
            $to= $data['email'] ;
            $recieverName = "" ;
            $subject = $data['subject'] ;         
              $message->to($to,$recieverName)->subject($subject);                    
          });
        }
       
    
     
 
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
      $countries = DB::table('pe_countries')->select('id','title',DB::raw('api_code as countryCode'))->where('i_status',1)->get();
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

function successResponse($data,$msg=''){
    $response = array(
      "status"=>1,
      "data"=>$data,
      "message"=>$msg
    );

    echo json_encode($response);
}


function errorResponse($data,$msg=''){
    $response = array(
      "status"=>0,
      "message"=>$msg
    );

    echo json_encode($response);
}

function siteTitle(){
  return 'Walkofweb';
}

function updateUserFollowers($userId){
    $qry="select sum(totat_followers) as totat_followers from (
      Select case when sum(fb_page_followers_count) is null then 0 else sum(fb_page_followers_count) end as totat_followers from fb_user_info where userId=".$userId."
      union
      Select case when sum(followers_count) is null then 0 else sum(followers_count) end as total_followers from insta_user_info where userId=".$userId."
      union
      select case when sum(followers_count) is null then 0 else sum(followers_count) end as total_followers from tiktok_user_info where userId=".$userId."
      union
      select case when count(id) is null then 0 else count(id) end as total_followers from user_follows where follower_user_id=".$userId.") as userFollowers" ;
   $userFollowers=DB::select($qry);
   $totalUserFollower = isset($userFollowers[0]->totat_followers)?$userFollowers[0]->totat_followers:0 ;
   DB::table('users')->where('id',$userId)->update(['followers'=>$totalUserFollower]);
   
}

function uploadImage($image_key,$path,$request){
  //print_r($request->$image_key); exit ;
   if($request->hasfile($image_key)){
    $imgPath='app/public/'.$path.'/' ;  
    $allowedfileExtension=['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','flv','mp4','m3u8','ts','3gp','mov','avi','wmv','mp3'];

    $files = $request->file($image_key); 
    $fileType=0 ;    
    $mimeType=$files->getMimeType() ; 
    $filenamewithextension = $files->getClientOriginalName(); 
    $extension = $files->getClientOriginalExtension();  
       
         $check = in_array($extension,$allowedfileExtension);
         $fileType = $this->checkFileType($filenamewithextension);
         
           if($check){
         
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename=str_replace(' ', '_', $filename);
            $filenametostore = $filename.'_'.time().'.'.$extension;       
            $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
             
              
              $files->storeAs('public/'.$path.'/', $filenametostore);
              $file_path= url('/').'/public/storage/'.$path.'/'.$filenametostore;              
             return $response=array('fileType'=>$fileType,"fileName"=>$filenametostore);
           }else{
             return array(); 
           }
         }else{
           return array(); 
         }
  }

  function getMultiResultProc($proc){
    $conn = DB::connection()->getPdo();   
    //$sql = 'CALL sp_getUserDetail(@total)';
    $sql=$proc ;
    $stmt = $conn->query($sql);
    $response = array();
    do {
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ($rows) {
      $response[]=$rows ;
    }
   
    } while ($stmt->nextRowset());
   
    return $response ;
  }
  
 ?>