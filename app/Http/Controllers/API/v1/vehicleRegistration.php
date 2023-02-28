<?php

namespace App\Http\Controllers\API\v1;

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
use Config ;

class vehicleRegistration extends Controller
{
    public function saveVehicle(Request $request){
    		
    	 try
        {
        	 $usrData=authguard();
        	  $userId=$usrData->id ;
          if(empty($usrData)){
          	 return $this->errorResponse('invalid request.', 422);
          }

          $request->request->add(['userId' => $userId]);

           $rules=[
            'manufacturer' => 'required',
            'model' => 'required',
            'nSeat' => 'required',
            'nDoor' => 'required',
            'fuelType' =>  'required',
            'transmissionType' => 'required',
            'bodyType'=>'required',
            'priceType'=>'required',
            'price'=>'required',
            'userId'=>'required'
           ] ;

           $validatedData = Validator::make($request->all(),$rules);

        if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }


            $validatedData_ = $request->validate($rules);

            $vehicle = vehicles::create($validatedData_);
            $lastInsertId= $vehicle->id;
            $featureData=array() ;
            $vFeature=isset($request->feature)?$request->feature:array() ;
            if(!empty($vFeature)){
            	foreach($vFeature as $key => $value) {
            		$featureData[]=array(
            			'vehicleId'=>$lastInsertId ,
            			'featureId'=>$value['featureId'],
            			'isSelected'=>$value['isSelected']
            		) ;
            	}

            	if(!empty($featureData)){
            		DB::table('vehicle_featuremap')->insert($featureData);	
            	}
            	
            }

            
            $message = "vehicle save successfully" ;
        	$data['vehicleId']=$lastInsertId ;

            return $this->successResponse($data,$message,200); 

        }
        catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
    }


    public function addVehicleImage__(Request $request){

    	$rules = [
    	 'vehicleId' => 'required',
         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			 ] ;


		 $validatedData = Validator::make($request->all(),$rules);

		if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        try{
         
          /*image Upload */
          $image = $request->file('image');
          $uuid = (string) Str::uuid();
          $image_name = time().$uuid.'.'.$image->getClientOriginalExtension();
         
          $destinationPath = public_path('/vehicleImage');
          $resize_image = Image::make($image->getRealPath());

          // $resize_image->resize(150, 150, function($constraint){
          // $constraint->aspectRatio();
          // })->save($destinationPath . '/' . $image_name);

          // $destinationPath = public_path('/images');

          $image->move($destinationPath, $image_name);
            $insertData = array(
              "vehicleId"=>$request->vehicleId ,
              "image"=>$image_name
            );

            DB::table('vehicle_image')->insert($insertData);

          /* end image upload*/
        
           return $this->successResponse([],'Image save successfully',200); 
        }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
         

	
    }

    public function addVehicleImage(Request $request){
        //|max:2048
          $data=json_encode($_FILES);
          $insertData=array(
            "vehicleId"=>$request->vehicleId ,
            "data"=>$data
          );
          DB::table('log')->insert($insertData);
       //  $rules = [
       // 'vehicleId' => 'required',
       //   'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
       // ] ;


    // $validatedData = Validator::make($request->all(),$rules);

    //if($validatedData->fails()){       
        // return $this->errorResponse($validatedData->errors()->first(), 401);
       // }


      try{

      if($request->hasFile('image')) {
        //get filename with extension
        $filenamewithextension = $request->file('image')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('image')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
        $mediumthumbnail = $filename.'_650_650_'.time().'.'.$extension;
 
        //Upload File
        $request->file('image')->storeAs('public/vehicleImage', $filenametostore);
        $request->file('image')->storeAs('public/vehicleImage/thumbnail', $smallthumbnail);
        $request->file('image')->storeAs('public/vehicleImage/thumbnail', $mediumthumbnail);
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/vehicleImage/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
 
        //create medium thumbnail
        $mediumthumbnailpath = public_path('storage/vehicleImage/thumbnail/'.$mediumthumbnail);
        $this->createThumbnail($mediumthumbnailpath, 500, 500);

        $isFeatured=0;
        $vId=$request->vehicleId ;
        $checkExistImg=vehicle_images::select('id')->where('vehicleId','=',$vId)->where('isFeatured','=','1')->get()->first();
        
        // if($checkExistImg==null){
        //   $this->listCarMailConfirmation($vId) ;
        //   $isFeatured=1;
        // }
        
           $insertData = array(
              "vehicleId"=>$request->vehicleId ,
              "image"=>$filenametostore,
              "bigImage"=>$mediumthumbnail ,
              "appImage"=>$smallthumbnail ,
              "isFeatured"=>$isFeatured
            );

            DB::table('vehicle_image')->insert($insertData);


        return $this->successResponse([],'Image save successfully',200);

        }else{
            return $this->errorResponse('Invalid request.', 422);
        }

      }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }

    }


    public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function addVehicle(Request $request){

        try{
        
        $fuelType= fuel_types::select('id','title')->where('status','=',1)->get()->toArray() ;
        $transType = transmission_types::select('id','title')->where('status','=',1)->get()->toArray() ;
        $bodyType = body_types::select('id','title')->where('status','=',1)->get()->toArray() ;
        $vehicelFeature=vehicle_features::select('id','title')->where('status','=',1)->get()->toArray() ;

        $data['fuelTypes']=$fuelType ;
        $data['transTypes']=$transType ;
        $data['bodyTypes']=$bodyType ;
        $data['vehicelFeatures']=$vehicelFeature ;
      
         return $this->successResponse($data,'add vehicle',200);

        }
        catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.', 422);
          }

    }


    public function vehicleList(Request $request){
          
      $bodyType = isset($request->body_type)?$request->body_type:0;
      $fuleType = isset($request->fuel_type)?$request->fuel_type:0;
      $transType = isset($request->trans_type)?$request->trans_type:0;
      $minPrice = isset($request->min_price)?$request->min_price:0;
      $maxPrice = isset($request->max_price)?$request->max_price:0;
      $feature = isset($request->feature)?$request->feature:'';
      $isPopular = isset($request->isPopular)?$request->isPopular:'';

      $cond='' ;

      if($isPopular==1){
         $cond.=" and isPopular=1" ;
      }

     if($bodyType > 0){
        $cond.=" and bodyType=".$bodyType ;
      }

      if($fuleType > 0){
        $cond.=" and fuelType=".$fuleType ;
      }

      if($transType > 0){
        $cond.=" and transmissionType=".$transType ;
      }

      if($minPrice > 0 && $maxPrice > 0){
        $cond.=" and price BETWEEN ".$minPrice." AND ".$maxPrice ;
      }

      if($minPrice > 0 && ($maxPrice==0 || $maxPrice < 0)){
        $cond.=" and price <= ".$minPrice ;
      }

      if($maxPrice > 0 && ($minPrice==0 || $minPrice < 0)){
        $cond.=" and price >= ".$maxPrice ;
      }



      if(!empty($feature)){
        $fId=array() ;
        foreach ($feature as $key => $value) {
            $fId[]=$value['fId'] ;
        }
      
        $fId_ = implode(",",$fId) ;
     
        $fe=DB::select("select group_concat(vehicleId) as vehicIeId from vehicle_featuremap where featureId in($fId_)"); ;
        
        $featureId_ = isset($fe[0]->vehicIeId)?$fe[0]->vehicIeId:'' ;
        if($featureId_!=''){
          $cond.=" and ve.id in ($featureId_)" ;
        }

      
      }

       $usrData=authguard();

       

      if(empty($usrData) || $usrData=='' ){
         return $this->errorResponse('invalid request.', 422);
      }
        $userId=$usrData->id ;
      
      try{

      $favourite="(select count(*) as totalCount from favourite_vehicle where userId=".$userId." and vehicleId=ve.id and status=1)" ;
        //thumbnail/
      $file_path = url('/').'/public/storage/vehicleImage/';
      $query="select id as vehicleId,userId,concat(manufacturer,' ',model) as vehicleName , case when priceType=1 then 'Hour' when priceType=2 then 'Day' else ''end priceType,price, case when (select image from vehicle_image where status=1 and vehicleId=ve.id limit 1) is null then ''else concat('".$file_path."',(select image from vehicle_image where status=1 and vehicleId=ve.id limit 1)) end as featureImage,case when ".$favourite."  is null then '0' when ".$favourite." > 0 then '1' else '0' end as isFeatured from vehicle as ve  where ve.status=1 and ve.isLocked=0 ".$cond;
   
    $vehicleData=DB::select($query) ;
   
     if(!empty($vehicleData)){
      foreach ($vehicleData as $key => $value) {
        $vehicleRating=avgVehicleRating($value->vehicleId,$userId);
        $vehicleData[$key]->vehicle_rating = $vehicleRating ;
          $awayKm = getAwayKm($userId,$value->userId);
        $vehicleData[$key]->vehicle_awayKm = $awayKm ; //'0.5 km away' ;
      }
    }

    $data['vehicle_data']=$vehicleData ;
        return $this->successResponse($data,'Vehicle List',200);

      }
      catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.', 422);
          }


    }

    public function vehicleFilter(Request $request){

       try{

          $file_path = url('/').'/public/storage/fuelTypesIcon/';
        $fuelType= fuel_types::select('id',DB::raw("case when icon is null then '' else concat('".$file_path."',icon) end as icon"),'title')->where('status','=',1)->get()->toArray() ;
        $transType = transmission_types::select('id','title')->where('status','=',1)->get()->toArray() ;

        $file_path = url('/').'/public/storage/bodyTypesIcon/';
        $bodyType = body_types::select('id',DB::raw("case when icon is null then '' else concat('".$file_path."',icon) end as icon"),'title')->where('status','=',1)->get()->toArray() ;

        $file_path = url('/').'/public/storage/featuresIcon/';
        $vehicelFeature=vehicle_features::select('id','title',DB::raw("case when ((icon is null) || icon='') then '' else concat('".$file_path."',icon) end as icon"))->where('status','=',1)->get()->toArray() ;
      
        $priceRange=DB::table('vehicle')->Select(DB::raw('min(price) as minimumPrice'),DB::raw('max(price) as maxmumPrice'))->first();
        $response=array(
          array(
            "Title"=>"price",
            "Type" => "price",
            "list"=>$priceRange 
            ),
          array(
            "Title"=>"Fuel Type",
             "Type" => "fuelTypes",
            "list"=>$fuelType 
          ),
          array(
            "Title"=>"Trans Type",
             "Type" => "transTypes",
            "list"=>$transType 
          ),
          array(
             "Title"=>"Body Type",
              "Type" => "bodyTypes",
            "list"=>$bodyType 
          ),
          array(
             "Title"=>"Vehicle Feature",
              "Type" => "vehicelFeatures",
            "list"=>$vehicelFeature 
          )) ;

        // $data['price']=$priceRange ;
        // $data['fuelTypes']=$fuelType ;
        // $data['transTypes']=$transType ;
        // $data['bodyTypes']=$bodyType ;
        // $data['vehicelFeatures']=$vehicelFeature ;
       
         return $this->successResponse($response,'vehicle filter',200);

        }
        catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.', 422);
          }

    }

    public function vehicleDetail(Request $request){

      $rules = [
       'vehicleId' => 'required',        
       ] ;

       $usrData=authguard();

       

      if(empty($usrData) || $usrData=='' ){
         return $this->errorResponse('invalid request.', 422);
      }

      $userId=$usrData->id ;

     $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
        }

     try{   
      
//DB::enableQueryLog();
        $vId = $request->vehicleId ;
        //thumbnail/
        $file_path = url('/').'/public/storage/vehicleImage/';
        $favourite="(select count(*) as totalCount from favourite_vehicle where userId=".$userId." and vehicleId=vehicle.id and status=1)" ;
        $vData = vehicles::select("id",'manufacturer','userId','description', 'model','price','nSeat','nDoor',DB::raw('case when (select image from vehicle_image where status=1 and vehicleId=vehicle.id limit 1) is null then "" else concat("'.$file_path.'",(select image from vehicle_image where status=1 and vehicleId=vehicle.id limit 1)) end as featureImage'),DB::raw("case when ".$favourite."  is null then '0' when ".$favourite." > 0 then '1' else '0' end as isFeatured"),DB::raw('(CASE WHEN priceType =1 THEN "Hour" ELSE "Day" END) AS priceType'))->where("id","=",$vId)->first();
  //      print_r(DB::getQueryLog()); exit ;
        $fIconPath=url('/').'/public/storage/featuresIcon/' ;
        $vehicleF="select group_concat(featureId) as feature from vehicle_featuremap where vehicleId=".$vId." and isSelected=1" ;
        $vehicleFExe=DB::select($vehicleF) ;
        $vFeatureId = isset($vehicleFExe[0])?$vehicleFExe[0]->feature:'' ;
        if($vFeatureId!=''){
           $vFeature = vehicle_features::select('id','title',DB::raw(' case when (icon is null or icon="") then "" else concat("'.$fIconPath.'",icon) end as icon'))->whereRaw(DB::raw(' id in ('.$vFeatureId.')'))->where('status','=',1)->get()->toArray() ;
        }else{
           $vFeature = array() ;
        }
       
       $file_path = url('/').'/public/storage/vehicleImage/';
        $vImg=vehicle_images::select('vehicleId',DB::raw('concat("'.$file_path.'",image) as image'),'isFeatured')->where("vehicleId",'=',$vId)->get() ;
        
         $vData->vehicle_image=$vImg ;
        /*rating*/

        $usrData=authguard();
        
        if(empty($usrData) || $usrData=='' ){
           return $this->errorResponse('invalid request.', 422);
        }


        $userId=$usrData->id ;
        $vehicleUserId= isset($vData->userId)?$vData->userId:0;

        $vehicleRating=avgVehicleRating($vId,$userId);
        $vData->vehicle_rating = $vehicleRating ;
          $awayKm = getAwayKm($userId,$vehicleUserId);        
        $vData->vehicle_awayKm = $awayKm ;
        //'0.5 km away' ;

        /*end rating*/
         $vData->feature=$vFeature ;
        
     
        $recentBooking=DB::table('booking')->select('userId','pickupTo','returnTo','amount',DB::raw('date_format(createdOn,"%d %b,%H:%i") as paymentDate'),DB::raw('case when paymentType=1 then "Credit Card" when paymentType=2 then "Debit Card" when paymentType=3 then "Net Banking" when paymentType=4 then "Cash" else "" end  as paymentType'),DB::raw('date_format(bookingDate,"%d %b,%H:%i") as bookingDate'),DB::raw('date_format(returnDate,"%d %b,%H:%i") as returnDate'))->where('vehicleId','=',$vId)->orderBy('id', 'DESC')->get()->first() ;
        $vData->recentBooking = ($recentBooking!=null)?$recentBooking:[] ;

        //$vData->q = $vFeatureId ;
        return $this->successResponse($vData,'vehicle detail',200);

      }
      catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.'.$e, 422);
          }
  }

  public function vehicleReview(Request $request){

     $rules = [
   'vehicleId' => 'required',        
   ] ;

     $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
      }

        try{
          
           $vId = $request->vehicleId ;
          
          
         $file_path = url('/').Config::get('constants.options.vehicle_thumb_imgPath');
           $vData = vehicles::select("id",'manufacturer',DB::raw('case when (select appImage from vehicle_image where status=1 and vehicleId='.$vId.' limit 1) is null then "" else concat("'.$file_path.'",(select appImage from vehicle_image where status=1 and vehicleId='.$vId.' limit 1)) end as featureImage'), 'model')->where("id","=",$vId)->first();       
       
           return $this->successResponse($vData,'vehicle detail',200);

        }
         catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.'.$e, 422);
          }
       
  }

  public function vehicleReviewSave(Request $request){

      $rules = [
        "vehicleId"=>'required',
        "rating"=>'required',
        "review"=>'required',
        "userId"=>'required'
      ] ;

       $usrData=authguard();
       $userId=$usrData->id ;

      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

      $request->request->add(['userId' => $userId]);

     $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
      }
      
      try{

       $validatedData_ = $request->validate($rules);
       $vehicle = vehicle_reviews::create($validatedData_);
     
         return $this->successResponse([],'submit review successfully',200);

        }
         catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.'.$e, 422);
          }

  }

  public function addFavouriteVehicle(Request $request){

     $rules = [
        "vehicleId"=>'required',
        "userId"=> 'required'
       ] ;

       $usrData=authguard();
       $userId=$usrData->id ;
 
      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }

      $request->request->add(['userId' => $userId]);

     $validatedData = Validator::make($request->all(),$rules);

    if($validatedData->fails()){       
         return $this->errorResponse($validatedData->errors()->first(), 401);
      }

      try{

        $isFavourite=0 ;
        $vehicleId=isset($request->vehicleId)?$request->vehicleId:0 ;
        $checkExistRec = favourite_vehicles::where(array("vehicleId"=>$vehicleId,"userId"=>$userId))->first();
        if ($checkExistRec === null) {
           $validatedData_ = $request->validate($rules);
           $vehicle = favourite_vehicles::create($validatedData_); 
           $msg='add' ;
           $isFavourite=1 ;
        }else{
          $favouriteVehicles = favourite_vehicles::where(["vehicleId"=>$vehicleId,"userId"=>$userId])->first();
          $favouriteVehicles->delete();
          $msg="remove" ;
          $isFavourite=0 ;
        }
        
        $response=array("isFavourite"=>$isFavourite);
       
       return $this->successResponse($response,$msg.' favourite vehicle successfully',200);
     } 
     catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.'.$e, 422);
          }

  }
  
    public function favouriteVehicleList(Request $request){
 

      $bodyType = isset($request->body_type)?$request->body_type:0;
      $fuleType = isset($request->fuel_type)?$request->fuel_type:0;
      $transType = isset($request->trans_type)?$request->trans_type:0;
      $minPrice = isset($request->min_price)?$request->min_price:0;
      $maxPrice = isset($request->max_price)?$request->max_price:0;
      $feature = isset($request->feature)?$request->feature:'';

      $cond='' ;
     if($bodyType > 0){
        $cond.=" and bodyType=".$bodyType ;
      }

      if($fuleType > 0){
        $cond.=" and fuelType=".$fuleType ;
      }

      if($transType > 0){
        $cond.=" and transmissionType=".$transType ;
      }

      if($minPrice > 0 && $maxPrice > 0){
        $cond.=" and price BETWEEN ".$minPrice." AND ".$maxPrice ;
      }

      if($minPrice > 0 && ($maxPrice==0 || $maxPrice < 0)){
        $cond.=" and price <= ".$minPrice ;
      }

      if($maxPrice > 0 && ($minPrice==0 || $minPrice < 0)){
        $cond.=" and price >= ".$maxPrice ;
      }



      if(!empty($feature)){
        $fId=array() ;
        foreach ($feature as $key => $value) {
            $fId[]=$value['fId'] ;
        }
      
        $fId_ = implode(",",$fId) ;
     
        $fe=DB::select("select group_concat(vehicleId) as vehicIeId from vehicle_featuremap where id in($fId_)"); ;
        
        $featureId_ = isset($fe[0]->vehicIeId)?$fe[0]->vehicIeId:'' ;
        if($featureId_!=''){
          $cond.=" and ve.id in ($featureId_)" ;
        }

      
      }

       $usrData=authguard();
       $userId=$usrData->id ;
 
      if(empty($usrData)){
         return $this->errorResponse('invalid request.', 422);
      }


  try{
    //thumbnail/
        
       $file_path = url('/').'/public/storage/vehicleImage/';
     $query="select id as vehicleId,userId,concat(manufacturer,' ',model) as vehicleName ,
case when priceType=1 then 'Hour' when priceType=2 then 'Day' else ''end priceType,price, case when (select image from vehicle_image where status=1 and vehicleId=ve.id limit 1) is null then ''else concat('".$file_path."',(select image from vehicle_image where status=1 and vehicleId=ve.id limit 1)) end as featureImage from vehicle as ve  where find_in_set(ve.id,(select group_concat(vehicleId) from favourite_vehicle where status=1 and userId=".$userId.")) and ve.status=1 ".$cond;

    $vehicleData=DB::select($query) ;
      if(!empty($vehicleData)){
      foreach ($vehicleData as $key => $value) {
        $vehicleRating=avgVehicleRating($value->vehicleId,$userId);
        $vehicleData[$key]->vehicle_rating = $vehicleRating ;
         $awayKm = getAwayKm($userId,$value->userId);
        $vehicleData[$key]->vehicle_awayKm = $awayKm ;
        //$vehicleData[$key]->vehicle_awayKm = '0.5 km away' ;
      }
    }
    $data['vehicle_data']=$vehicleData ;
        return $this->successResponse($data,'Favourite Vehicle List',200);

      }
      catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.', 422);
          }


    }

   public function myTrips(){

      $usrData=authguard();
      $userId=$usrData->id ;

     try{
  

       $vehicleData= bookings::query()->select(DB::raw('id as bookingId'),'userId','user_name','user_email','vehicleId',
              DB::raw('date_format(bookingDate,"%d %M,%H:%i") as bookingDate'),DB::raw('case when (select id from favourite_vehicle where vehicleId=booking.vehicleId and userId="'.$userId.'" and status=1) is null then "0" else "1" end as isFavourite'),DB::raw('date_format(returnDate,"%d %M,%H:%i") as returnDate'),'amount','paymentStatus',DB::raw('case when paymentType=1 then "Credit Card" when paymentType=2 then "Debit Card" when paymentType=3 then "Net Banking" else "" end as paymentType'),'txnId','createdOn')
          ->with(array( 'vehicle' => function($query) {
              $query->select('id','manufacturer','model');
          },'vehicle_image' => function ($query1) {
             $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';
        $query1->select('vehicleId',DB::raw('concat("'.$file_path.'",bigImage) as image'),'isFeatured')->where('isFeatured',1);
    }

  ))->get()->where("userId",$userId)->toArray();

     if(!empty($vehicleData)){
          foreach ($vehicleData as $key => $value) {
            $vehicleRating=avgVehicleRating($value['vehicleId'],$userId);
            $vehicleData[$key]['vehicle_rating'] = $vehicleRating ;
             $awayKm = getAwayKm($userId,$value['userId']);
           
            $vehicleData[$key]['vehicle_awayKm'] =$awayKm  ;
          }
    }

       return $this->successResponse($vehicleData,'MyTrips List',200);

     } catch(\Exception $e)
          {
             return $this->errorResponse('Error occurred.'.$e, 422);
          }
   }
  
   public function listCarMailConfirmation($vehicleId){

      //$vehicleId=$request->vehicleId ;   

      $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';

         $vData = vehicles::select("id",DB::raw('case when (select email from users where id=vehicle.userId) is null then "" else (select email from users where id=vehicle.userId) end as usrEmail'),DB::raw('concat(manufacturer," ",model) as vehicleName') ,DB::raw('case when (select appImage from vehicle_image where status=1 and vehicleId=vehicle.id limit 1) is null then "" else concat("'.$file_path.'",(select appImage from vehicle_image where status=1 and vehicleId=vehicle.id limit 1)) end as featureImage'))->where("id","=",$vehicleId)->first();
        $email=isset($vData->usrEmail)?$vData->usrEmail:'' ;
        $vName = isset($vData->vehicleName)?$vData->vehicleName:'' ;
        $vImg =  isset($vData->featureImage)?$vData->featureImage:'' ;
  
       $data = array(
            'email' => $email,
            'vehicleName'=>$vName ,
            'vehicleImg'=>$vImg
           
            );

       
// echo view('emails/list_car_confirmation',$data);

 $mail=sendCarConfirmationMail($data)       ;

 if($mail){
    return $this->successResponse([],'successfully has been send email for car listed ',200);
 }else{
    return $this->errorResponse('Error occurred.', 422); 
 }

 
}

   public function truncteData(){
    $qry[]="truncate table body_type" ;
    $qry[]="truncate table booking" ;
    $qry[]="truncate table bookingImg" ;
    $qry[]="truncate table favourite_vehicle" ;
    $qry[]="truncate table fuel_type" ;
    $qry[]="truncate table mailbox" ;
    $qry[]="truncate table message_conversationid" ;
    $qry[]="truncate table transmission_type" ;
    $qry[]="truncate table user_messages" ;
    $qry[]="truncate table vehicle" ;
    $qry[]="truncate table vehicle_featuremap" ;
    $qry[]="truncate table vehicle_image" ;
   }
 
}
