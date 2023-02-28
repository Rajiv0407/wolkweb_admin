<?php 

function authguard(){

 $token=Auth::guard('api')->user();
 // if(empty($token)){
 // 	$token=array();
 // }
 return $token;

}

function printLastQuery(){

	return DB::connection()->enableQueryLog(); 
}

 function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
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

 
 function getUserConversationId($senderId,$receiverId,$lastMsg=''){

  $qry_support="select id from users where user_type=1 and Status=1 and isTrash=0 limit 1" ;
  $qrySExe = DB::select($qry_support);
  $receiverId = isset($qrySExe[0])?$qrySExe[0]->id:0 ;

 	$qry="select id,conversationId from message_conversationid where (senderId=".$senderId." and receiverId=".$receiverId.") or (receiverId=".$senderId." and senderId=".$receiverId.")" ;


		$qryExe=DB::select($qry);
		
		if(empty($qryExe)){
			
			$uuid = Uuid::generate(1);
			$uuid = mb_convert_encoding($uuid, 'UTF-8', 'UTF-8');
       		$insertData=array(
       			"senderId"=>$senderId  ,
       			"receiverId"=>$receiverId  ,
       			"conversationId"=>$uuid,
       			"updatedOn"=>date("Y-m-d H:i")
       		);

       		$lastId=DB::table('message_conversationid')->insertGetId($insertData);
       		 $resp=array("id"=>$lastId,"conversationId"=>$uuid);

		}else{
			
			$uuid=isset($qryExe[0]->conversationId)?$qryExe[0]->conversationId:0;
      $id=isset($qryExe[0]->id)?$qryExe[0]->id:0;
       $resp=array("id"=>$id,"conversationId"=>$uuid);
			
		}

		return $resp ;
 
 }


 function time_elapsed_string($datetime, $full = false) {
   $now = new DateTime;
   $ago = new DateTime($datetime);
   $diff = $now->diff($ago);

   $diff->w = floor($diff->d / 7);
   $diff->d -= $diff->w * 7;

   $string = array(
       'y' => 'year',
       'm' => 'month',
       'w' => 'week',
       'd' => 'day',
       'h' => 'hour',
       'i' => 'minute',
       's' => 'second',
   );
   foreach ($string as $k => &$v) {
       if ($diff->$k) {
           $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
       } else {
           unset($string[$k]);
       }
   }

   if (!$full) $string = array_slice($string, 0, 1);
   return $string ? implode(', ', $string) . ' ago' : 'just now';
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

function allFuleType(){

     $fuleType = DB::table('fuel_type')->where('status',1)->get()->toArray();
    return $fuleType ;

 }

function allTransType(){

    $transType = DB::table('transmission_type')->where('status',1)->get()->toArray();
    return $transType ;
 }

function allBodyType(){
  
    $allBodyType = DB::table('body_type')->where('status',1)->get()->toArray();
    return $allBodyType ;
 }

function vehicleReview($vehicleId=0){

  $cond='' ;

  if($vehicleId > 0){
    $cond="where vehicleId=".$vehicleId ;    
  }
  
  $profileImgPath=Config('constants.options.profile_thumb_imgPath');
  $qry="select r.id as reviewId,r.vehicleId , (select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=r.vehicleId) as vehicleName, (select name from users where id=r.userId) as userName , case when (select concat('".$profileImgPath."',App_Image) from users where id=r.userId) is null then '' else (select concat('".$profileImgPath."',App_Image) from users where id=r.userId) end as userImg, r.userId, case when r.status=0 then 'Pending' when r.status=1 then 'Approve' when r.status=3 then 'Reject' else '' end as reviewStatus, r.rating,r.review,date_format(r.createdOn,'%b %d,%Y') as reviewDate from vehicle_review as r ".$cond ;

  $qryExe = DB::select($qry);
  return $qryExe ;
}

function userAddress($landMark,$houseNumber,$city,$state,$country,$zipcode){

  $address= '' ;
  
  if($landMark!=''){
      $address = $landMark.',' ;
  }

  if($houseNumber!=''){
   $address = $address.$houseNumber.',' ;   
  }

  if($city!=''){
    $address = $address.$city.',' ;   
  }

  if($state!=''){
     $address = $address.$state.' - ' ;   
  }

  if($zipcode!=''){
     $address = $address.$zipcode.',' ;   
  }

  if($country!=''){
    $address = $address.$country ;   
  }

 
   return $address ;
 }

 function avgVehicleRating($vehicleId,$userId){

 DB::select("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
 $qry="select case when  sum(totalRating) is null then '0' else sum(totalRating) end as totalRating ,case when totalTrips is null then '0' else totalTrips end as totalTrips, case when sum(averageRating) is null then '0' else sum(averageRating) end as totalAvgRating, case when round((sum(averageRating)/sum(totalRating)),2) is null then '0' else round((sum(averageRating)/sum(totalRating)),2) end as avgRating from (select rating , count(*) as totalRating , (rating * count(*)) as averageRating,case when (select count(*) as totalTrips from booking where userId=".$userId." and vehicleId=".$vehicleId." ) is null then '0' else (select count(*) as totalTrips from booking where userId=".$userId." and vehicleId=".$vehicleId." and paymentStatus='CAPTURED' ) end as totalTrips from vehicle_review where vehicleId=".$vehicleId." and status=1 group by rating ) as rating";

  $qryExe = DB::select($qry);
  $totalTrips= isset($qryExe[0]->totalTrips)?$qryExe[0]->totalTrips:0 ;
  $avgRating = isset($qryExe[0]->avgRating)?$qryExe[0]->avgRating:0 ;

  $response = ($avgRating==0)?'0':$avgRating ;

  if($totalTrips > 0){
    $response= $avgRating.'('.$totalTrips.' Trips)' ;
  }

  return $response ;

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

   function getUnreadMessage(){
     $totalUnReadMsg=DB::select("select count(*) as totalMsg from (select conv.id from message_conversationid as conv inner join mailbox as m on m.MailConversationId=conv.id where conv.ReadByAdmin=0 and conv.isTrashByAdmin=0  group by conv.id) as msg") ;

     $totalUnreadMsg = isset($totalUnReadMsg[0])?$totalUnReadMsg[0]->totalMsg:0 ;
     // $inboxList=DB::table("message_conversationid")->where("ReadByAdmin","0")->where("isTrashByAdmin","0")->get();
     //  $totalUnreadMsg=$inboxList->count() ;
      return  $totalUnreadMsg ;
   }

   function getAwayKm($bookingUserId,$vehicleUserId){
    //  return '0.05 km away ' ;  exit ;
     $bUsrInfo=DB::table('user_location')->select('Latitude','Longitude')->where("UserId",$bookingUserId)->get()->first();
     $bUsrLat = isset($bUsrInfo->Latitude)?$bUsrInfo->Latitude:'' ;
     $bUsrLong = isset($bUsrInfo->Longitude)?$bUsrInfo->Longitude:'' ;

     $vUsrInfo=DB::table('user_location')->select('Latitude','Longitude')->where("UserId",$vehicleUserId)->get()->first();
     $vUsrLat = isset($vUsrInfo->Latitude)?$vUsrInfo->Latitude:'' ;
     $vUsrLong = isset($vUsrInfo->Longitude)?$vUsrInfo->Longitude:'' ;
     // $t='bUsrLat'.$bUsrLat.'bUsrLong'.$bUsrLong.'vUsrLat'.$vUsrLat.'vUsrLong'.$vUsrLong ;
    try {

        if($bUsrLat!='' && $bUsrLong!='' && $vUsrLat!='' && $vUsrLong!=''){
          $distance = distance($bUsrLat,$bUsrLong,$vUsrLat,$vUsrLong,"K");
        }else{
          $distance = 0 ;
        }

          if($distance > 0){

           return round($distance,2).' km away ' ;
          }else{
             return '' ;
          }
    } catch (Exception $e) {
         return ' ' ;
    }
  
   }

   function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}


 function sendCarConfirmationMail($data){
  
            Mail::send('emails.list_car_confirmation', $data, function($message) use ($data) {
          $to= $data['email'] ;
          $recieverName = "" ;
          $subject = "Confrimation of car listing " ;
          
           $message->to($to,$recieverName)->subject($subject);
                    
        });
 
        if (Mail::failures()) {
         return false ;
         }else{
          return true ;
         }
 }


?>