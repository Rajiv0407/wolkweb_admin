<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\model\vehicles;
use App\model\vehicle_images;
use DB;
use Image ;
use Illuminate\Support\Str;
use App\model\vehicle_features ;
use App\model\fuel_types ;
use App\model\body_types ;
use App\model\transmission_types ;
use App\model\vehicle_reviews ;
use App\model\favourite_vehicles ;
use App\model\bookings ;
use App\user ;
use DateTime;

class bookingController extends Controller
{
    
  public function bookingAvailability(Request $request){

      $rules = [
        "vehicleId"=>'required',
        "userId"=> 'required',
        "bookingDate"=>'required',
        "returnDate" => 'required'
       ] ;

      $checkRequest = $this->apiRequestValidate($rules,$request);

      if($checkRequest!=''){
          return $checkRequest ; exit ;
      }

            $vehicleId = $request->vehicleId ;
            $bookingDate = $request->bookingDate ;
            $returnDate = $request->returnDate ;

          try{

            $checkBooking=$this->checkBooking($vehicleId,$bookingDate,$returnDate) ;

            if(isset($checkBooking['isBooking']) && $checkBooking['isBooking']=='true'){
              $msg="Booking is available" ;
            }else{
              $msg="Booking is not available" ;
            }
            return $this->successResponse($checkBooking,$msg,200);

        } catch(\Exception $e){
            return $this->errorResponse('Error occurred.'.$e, 422);
        }

     }

     public function apiRequestValidate($rules,$request){
   $usrData=authguard();
      
 
      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);exit;
      }
       $userId=$usrData->id ;
      $request->request->add(['userId' => $userId]);

     $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401); exit;
      }
 }

// "paymentStatus"	
// 			"txnId"
 	public function checkBooking($vehicleId,$bookingDate,$returnDate){
      
 		$qry="select (case when count(*) > 0 then 'false' else 'true' end) as isBooking from booking where vehicleId=".$vehicleId." and bookingDate < '".$returnDate."' and returnDate >  '".$bookingDate."'" ;
    
          $checkBooking=DB::select($qry);
          if(isset($checkBooking[0])){
          	$resp=$checkBooking[0]->isBooking ;
          }else{
          	$resp=false ;
          }

          $response=array('isBooking'=>$resp);
          return $response ;
 	}

   public function getDifferentTime($bookingDate,$returnDate){

        $bookingDate = new DateTime($bookingDate);
        $returnDate = new DateTime($returnDate);
        $interval = $bookingDate->diff($returnDate);
        // $elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
        //  $elapsed = $interval->format('%i minutes');
        //echo $elapsed;

       $year=$interval->y ;
       $months=$interval->m ;
       $day=$interval->d ;
       $h=$interval->h ;
       $i=$interval->i ;
       $s=$interval->s ;

       return $totalMinute=($year*365*24*60)+($months*30*24*60)+($day*24*60)+($h*60)+$i ;
       
   }


    public function bookingVehicle(Request $request){

      $rules = [
        "vehicleId"=>'required',
        "userId"=> 'required',
        "bookingDate"=>'required',
        "returnDate" => 'required',
        "pickupTo"=>'required' ,
    		"returnTo"=>'required' ,
    		"amount"=>'required' ,	
    		"paymentType"=>'required',
        "latitude"=>'required',
        "longitude"=>'required',
        "totalAmount"=>'required',
        "chargeType"=>'required',
        "destination_latitude"=>'required',
        "destination_longitude"=>'required'

       ] ;

      $checkRequest = $this->apiRequestValidate($rules,$request);
       if($checkRequest!=''){
          return $checkRequest ; exit ;
      }

       $userId = $request->userId ;

       
        $userInfo = User::findOrFail($userId);
      
      

      		$userName=isset($userInfo->name)?$userInfo->name:'' ;
      		$userEmail =isset($userInfo->email)?$userInfo->email:'' ;
            $vehicleId = $request->vehicleId ;
            $bookingDate = $request->bookingDate ;
            $returnDate = $request->returnDate ;
            $pickupTo = $request->pickupTo ;
            $returnTo = $request->returnTo ;
            $amount = $request->totalAmount ;
            $rateAmount = $request->amount ;
            
              /*get total ride time */
          $rideTime=$this->getDifferentTime($bookingDate,$returnDate);
          
          $rideAmount=round((($rateAmount/60) * $rideTime),2) ; 
          
              /* end*/
            $paymentType = $request->paymentType ;

           
            $chargeType = $request->chargeType ;
           
            $checkBooking=$this->checkBooking($vehicleId,$bookingDate,$returnDate) ;
            

       $lat=isset($request->latitude)?$request->latitude:'' ;
       $long=isset($request->longitude)?$request->longitude:'' ;             	

       $d_lat=isset($request->destination_latitude)?$request->destination_latitude:'' ;
       $d_long=isset($request->destination_longitude)?$request->destination_longitude:'' ;
           

       if(isset($checkBooking['isBooking']) && $checkBooking['isBooking']=='false'){

       	$response=array('isBooking'=>$checkBooking['isBooking']);

       	  return $this->successResponse($response,'Booking is not available. ',200); exit ;
       }

       $paymentStatus="UNCAPTURED";

       if($paymentType==4){
        $paymentStatus="CAPTURED";
       }

    	$insertData=array(
    		"userId"=>$userId,
			"user_name"=>$userName ,
			"user_email"=>$userEmail ,
			"vehicleId"=>$vehicleId ,
			"pickupTo"=>$pickupTo ,
			"returnTo"=>$returnTo ,
			"bookingDate"=>$bookingDate ,	
			"returnDate"=>$returnDate ,	
			"amount"=>$amount ,
      "paymentStatus"=>$paymentStatus,	
			"paymentType"=>$paymentType,	
			"createdOn"=>date("Y-m-d H:i:s"),
      "latitude"=>$lat ,
      "longitude"=>$long	,
      "rateAmount"=>$rateAmount ,
      "chargeType"=>$chargeType,
      "destination_latitude"=>$d_lat ,
      "destination_longitude"=>$d_long
    	);
     


    // echo "<pre>";
    //  print_r($insertData);
    //  exit ;

    	try{

    	//$booking = DB::table('booking')->insert($insertData);
    	//print_r($booking);
    	//$lastId = $booking->id ;
    	 $id = bookings::create($insertData)->id;
    	$response=array('bookingId'=>$id,'isBooking'=>$checkBooking['isBooking']);
    	  return $this->successResponse($response,'Successfully save booking ',200);

        } catch(\Exception $e){
            return $this->errorResponse('Error occurred.'.$e, 422);
        }

     }

     public function updatePaymentStatus(Request $request){
     		$rules=[
     			'userId'=>'required',
     			'paymentStatus'=>'required',
     			'txnId'=>'required',
     			'bookingId' => 'required'

     		];
 
     	$checkRequest=$this->apiRequestValidate($rules,$request);
      if($checkRequest!=''){
          return $checkRequest ; exit ;
      }

        $userId = $request->userId ;
        $paymentStatus = $request->paymentStatus ;
        $txnId = $request->txnId ;
        $bookingId = $request->bookingId ;
        
        if($paymentStatus==1){
        	$pStatus='CAPTURED' ;
        }else{
        	$pStatus='UNCAPTURED' ;
        }

        try{
        	
        	$updateData=array(
        		'paymentStatus'=>$pStatus ,
        		'txnId'=>$txnId,
        		'updatedOn'=>date("Y-m-d H:i:s")
        	);

        	DB::table('booking')->where('id',$bookingId)->update($updateData);
        	
        	return $this->successResponse([],'Successfully updated payment status ',200);
        } catch(\Exception $e){
        	return $this->errorResponse('Error occurred.'.$e, 422);	
        }
     		
     }

     public function updateCurrentLocation(Request $request){
        $rules=[
          'userId'=>'required',
          'latitude'=>'required',
          'longitude'=>'required',
         ];
 
      $checkRequest=$this->apiRequestValidate($rules,$request);
      if($checkRequest!=''){
          return $checkRequest ; exit ;
      }

        $userId = $request->userId ;
        $latitude = $request->latitude ;
        $longitude = $request->longitude ;
        try{
      $qry="select count(*) as totalRec from user_location where UserId=".$userId ;
      $qryExe = DB::select($qry) ;
      $totalRec = isset($qryExe[0]->totalRec)?$qryExe[0]->totalRec:0 ;
      if($totalRec > 0){

        $updateData = array(
          "Latitude"=>$latitude ,
          "Longitude"=>$longitude ,
          "UpdatedOn"=>date("Y-m-d H:i:s")
        );

          DB::table("user_location")->where('UserId',$userId)->update($updateData);

        } else {

          $insertData = array(
          "UserId"=>$userId ,
          "Latitude"=>$latitude ,
          "Longitude"=>$longitude ,
          "Status"=>1,
          "CreatedOn"=>date("Y-m-d H:i:s")          
         );
          DB::table("user_location")->insert($insertData);  

        }
        
          return $this->successResponse([],'Successfully updated current location',200);
        } catch(\Exception $e){
          return $this->errorResponse('Error occurred.'.$e, 422); 
        }

        
     }

     public function bookingImg(Request $request){


          $rules=[
            'bookingId' => 'required'
           ] ;

           $validatedData = Validator::make($request->all(),$rules);

        if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        $bookingId=isset($request->bookingId)?$request->bookingId:0 ;

        $usrData=authguard();

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

       $userId=$usrData->id ;

       try{
  
        if($request->hasFile('bookingImage')) {
        //get filename with extension
        $filenamewithextension = $request->file('bookingImage')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('bookingImage')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
 
        //Upload File
        $request->file('bookingImage')->storeAs('public/bookingImg', $filenametostore);
        $request->file('bookingImage')->storeAs('public/bookingImg/thumbnail', $smallthumbnail);
       
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/bookingImg/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
 
          
           $insertData = array(
              "bookingId"=>$bookingId ,
              "image"=>$filenametostore,
              "appImage"=>$smallthumbnail             
            );

            DB::table('bookingimg')->insert($insertData);


        return $this->successResponse([],'Image save successfully',200);

        }else{
            return $this->errorResponse('Invalid request.', 422);
        }

       }catch(\Exception $e){

          return $this->errorResponse('Error occurred.'.$e, 422); 

        }

     }

       public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function  userProfile(Request $request){

                $usrData=authguard();

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

       $userId=$usrData->id ;

       try{
     
         $file_path = url('/').'/public/storage/profileImage/thumb';
            $userInfo = user::select('id','name','email',DB::raw('concat("'.$file_path.'","/",App_Image) as profileImg'))->find($userId);
             $listCarQry=DB::select("select id as vehicleId,concat(manufacturer,' ',model) as carName from vehicle where status=1 and UserId=".$userId) ;
             $bookingCar = DB::select("select id as vehicleId,concat(manufacturer,' ',model) as carName from vehicle where status=1 and find_in_set(id, (select group_concat(distinct vehicleId) as vehcileId from booking where userId=".$userId." and paymentStatus='CAPTURED'))") ;
            
            $userInfo->listCar = $listCarQry ;
            $userInfo->rentCar = $bookingCar ;
            return $this->successResponse($userInfo,'User profile information',200);
          }catch(\Exception $e){

          return $this->errorResponse('Error occurred.'.$e, 422); 

        }

    }

    public function unLockVehcile(Request $request){
      $rules=[
          'vehicleId'=>'required',
          'isLock'=>'required'
        ];
 
      $checkRequest=$this->apiRequestValidate($rules,$request);

      if($checkRequest!=''){
       
        return $checkRequest ; exit ;

      }
     
      $userId = $request->userId ;
      $vehicleId=isset($request->vehicleId)?$request->vehicleId:'' ;
      $isLock=isset($request->isLock)?$request->isLock:0;

      $updateData=array(
        "isLocked"=>$isLock
      );

      try{
          if($isLock==1){
            $msg='Locked'   ;
          }else{
            $msg='UnLocked';
          }
         
        DB::table('vehicle')->where('id',$vehicleId)->update($updateData);
        $response=vehicles::select(DB::raw('id as vehicleId'),DB::raw('case when isLocked=1 then "Yes" else "No" end as isLocked'))->find($vehicleId);
        return $this->successResponse($response,$msg.' vehicle successfully',200);
      }catch(\Exception $e){
          return $this->errorResponse('Error occurred.', 422);
      }
      
    }

    public function vehicleAwaykm(Request $request){
        $bookingUsrId=$request->input('bookingUsrId');
        $vehicleUsrId=$request->input('vehicleUsrId');

       
         $data = getAwayKm($bookingUsrId,$vehicleUsrId);
        return $this->successResponse($data,' Current Location Info',200);
    }
}
