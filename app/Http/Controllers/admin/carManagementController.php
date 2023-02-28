<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use App\model\vehicles;
use Illuminate\Pagination\Paginator ;
use App\user;
use App\model\vehicle_images;
use DB ;
use Cookie;
use Image ;

class carManagementController extends Controller
{

  
    public function index(Request $request){
        
        $data['title']='lesgo' ;


    	  echo view('admin/carManagement/index',$data);


    }

    public function carData(Request $request)
    {
    	 
    	$carQry = "select vh.id as id,vh.manufacturer,vh.model,vh.price,concat(u.mobile_Code,u.mobile_Number) as number, u.email,concat('House Number : ',u.House_Number,' ,',u.Landmark,' ,',u.City,' ,',u.State,' ,',u.Country,' ,',u.Zipcode) as Address, case when vh.status=1 then 'Active' else 'Inactive' end as status,vh.status as vehicleStatus from vehicle as vh inner join users as u on u.id=vh.userId where vh.isTrash=0" ; 
    	$carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    	
       
    }

    public function changeStatus(Request $request)
    {

    	$id=$request->id ;

    	$qry="update vehicle set status=(case when status=1 then 0 else 1 end) where id=".$id;

    	try{

           DB::select($qry);	
            echo successResponse([],'changed status successfully'); 
         
    	}
    	 catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

   public function deleteRecord(Request $request)
    {
        $id=$request->id ;
        $updateData=array(
            "isTrash"=>1,
            "updated_at"=>date("Y-m-d H:i:s")
        );


        try{

             $qry=DB::table('vehicle')->where('id',$id)->update($updateData);
            echo successResponse([],'deleted successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function detail(Request $request){

        $carId=isset($request->id)?$request->id:0 ;
        
        $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';
         $carQry = "select vh.id as id,vh.manufacturer,vh.model,vh.price,concat(u.mobile_Code,u.mobile_Number) as number,u.name , u.email,concat('House Number : ',u.House_Number,' ,',u.Landmark,' ,',u.City,' ,',u.State,' ,',u.Country,' ,',u.Zipcode) as Address, case when vh.status=1 then 'Active' else 'Inactive' end as status,vh.status as vehicleStatus,case when (select bigImage from vehicle_image where vehicleId=".$carId." and isFeatured=1 limit 1 ) is null then '' else concat('".$file_path."',(select bigImage from vehicle_image where vehicleId=".$carId." and isFeatured=1 limit 1 )) end as featuredImg  from vehicle as vh left join users as u on u.id=vh.userId where vh.isTrash=0 and vh.id=".$carId ; 
        $carInfo = DB::select($carQry); 
        $data['carInfo']=isset($carInfo[0])?$carInfo[0]:array() ;     
        $data['vehicleId']=$carId ;

        echo view('admin/carManagement/carDetail',$data);
    }
    
    public function addCar(Request $request){

        $data['title']="LesGo" ;
        $fuelType = allFuleType() ;
        $transType = allTransType() ;
        $bodyType = allBodyType() ;

        $data['fuelType']=$fuelType ;
        $data['transType']=$transType ;
        $data['bodyType']=$bodyType ;

        echo view('admin/carManagement/addCar',$data);
    }
  
    public function saveCar(Request $request){
       
        $manufacturer = isset($request->car_manufacture)?$request->car_manufacture:'' ;
        $carModel = isset($request->car_model)?$request->car_model:'' ;
        $carSeats = isset($request->car_seats)?$request->car_seats:'' ;
        $carDoors = isset($request->car_doors)?$request->car_doors:'' ;
        $carFuleType = isset($request->car_fuleType)?$request->car_fuleType:'' ;
        $carTransType = isset($request->car_transmissionType)?$request->car_transmissionType:'' ;
        $carBodyType = isset($request->car_bodyType)?$request->car_bodyType:'' ;
        $carPrice = isset($request->car_price)?$request->car_price:'' ;
                                   
        $insertData=array(
            "userId"=>1 ,
            "manufacturer"=>$manufacturer ,
            "model"=>$carModel ,
            "nSeat"=>$carSeats ,
            "nDoor"=>$carDoors ,
            "fuelType"=>$carFuleType ,
            "transmissionType"=>$carTransType ,
            "bodyType"=>$carBodyType ,
            "status"=>1 ,
            "priceType"=>1 ,
            "price"=> $carPrice
        );


        try{
         
            vehicles::insert($insertData);
            echo successResponse([],'save car successfully.');  
              
        }
        catch(\Exception $e)
        {
          echo errorResponse('error occurred'.$e); 
         
        }
    }

    public function editVehicle(Request $request){
       
        $vehicleId = $request->vehicleId ;
        $type = isset($request->type)?$request->type:0 ;

        $vehicleInfo = vehicles::where('id',$vehicleId)->first() ;

         // DB::('vehicle')->where('id',$vehicleId)->get() ;

        $data['title']="LesGo" ;
        $fuelType = allFuleType() ;
        $transType = allTransType() ;
        $bodyType = allBodyType() ;

        $data['vehicleInfo']=$vehicleInfo ;
        $data['fuelType']=$fuelType ;
        $data['transType']=$transType ;
        $data['bodyType']=$bodyType ;

      
       $data['vehicleId'] = $vehicleId ;

       if($type==1){
        echo view('admin/carManagement/carDetailEdit',$data); 
       
       }else{
         echo view('admin/carManagement/editCar',$data);
       }
       
      

    }

     public function updateVehicle(Request $request){

        $manufacturer = isset($request->car_manufacture)?$request->car_manufacture:'' ;
        $carModel = isset($request->car_model)?$request->car_model:'' ;
        $carSeats = isset($request->car_seats)?$request->car_seats:'' ;
        $carDoors = isset($request->car_doors)?$request->car_doors:'' ;
        $carFuleType = isset($request->car_fuleType)?$request->car_fuleType:'' ;
        $carTransType = isset($request->car_transmissionType)?$request->car_transmissionType:'' ;
        $carBodyType = isset($request->car_bodyType)?$request->car_bodyType:'' ;
        $carPrice = isset($request->car_price)?$request->car_price:'' ;
        $updatedId = isset($request->updatedId)?$request->updatedId:'' ;
        $isPopular = isset($request->isPopular)?$request->isPopular:'' ;            
        $insertData=array(
            "userId"=>1 ,
            "manufacturer"=>$manufacturer ,
            "model"=>$carModel ,
            "nSeat"=>$carSeats ,
            "nDoor"=>$carDoors ,
            "fuelType"=>$carFuleType ,
            "transmissionType"=>$carTransType ,
            "bodyType"=>$carBodyType ,
            "status"=>1 ,
            "priceType"=>1 ,
            "price"=> $carPrice,
            "updated_at" => date("Y-m-d H:i:s"),
            "isPopular" => $isPopular 
        );


        try{
         
            vehicles::where('id',$updatedId)->update($insertData);
            echo successResponse([],'updated successfully.');  
              
        }
        catch(\Exception $e)
        {
          echo errorResponse('error occurred'.$e); 
         
        }


    }

    public function basicDetail(Request $request){

        $vehicleId = $request->vehicleId ;
        $data['vehicleId'] = $vehicleId ;

        $carInfo = vehicles::find($vehicleId);
        $fuelType= vehicles::find($vehicleId)->fuel_type;
        $bodyType = vehicles::find($vehicleId)->body_type;
        $transType = vehicles::find($vehicleId)->transmission_type;
               $carInfo['fuleType_']=isset($fuelType->title)?$fuelType->title:'' ;
         $carInfo['bodyType_']=isset($bodyType->title)?$bodyType->title:'' ;
         $carInfo['transType_']=isset($transType->title)?$transType->title:'' ;
         $data['carInfo']=$carInfo ;
   

//         $carInfo = DB::table('vehicle')->select('id','userId','manufacturer',  'model', 'nSeat', 'nDoor', 'fuelType',  'transmissionType',  'bodyType' , 'status',  'priceType', 'price', 'isPopular' ,'isTrash', 'description' ,'created_at' , 'updated_at'
// )->where('id',$vehicleId)->first();

        $vehicleFeature = "select vf.id as featureId,vf.title,case when (select isSelected from vehicle_featuremap where vehicleId=".$vehicleId." and featureId=vf.id) is null then 0 else (select isSelected from vehicle_featuremap where vehicleId=? and featureId=vf.id) end as isSelected from vehicle_feature as vf where vf.status=1 and vf.title!=''" ;
        $featureInfo = DB::select($vehicleFeature,[$vehicleId]);

        $data['featureInfo'] =$featureInfo ;
        $data['carInfo']=$carInfo ;
        echo view('admin/carManagement/carBasicDetail',$data);  

    }

    public function carImage(Request $request){
        $vehicleId = $request->vehicleId ;

        $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';
        $vehicleImg="select id,vehicleId,case when bigImage is null then '' else concat('".$file_path."',bigImage) end as image,isFeatured from vehicle_image where vehicleId=".$vehicleId." and status=1" ;

        $vImgData = DB::Select($vehicleImg) ;
        $data['vehicleImg']=$vImgData ;
        $data['vehicleId'] = $vehicleId ;
       echo view('admin/carManagement/carImage',$data);
    }

    public function carReviews(Request $request){
        
        $vehicleId = isset($request->vehicleId)?$request->vehicleId:0 ;
        $type = isset($request->type)?$request->type:0 ;
        
        /* Review Data */
        
        $profileImgPath=url('/').Config('constants.options.profile_thumb_imgPath');
 
        $ratingReview = DB::table("vehicle_review")->select('id','userId','status' ,'review','rating',DB::raw("case when status=0 then 'Pending' when status=1 then 'Approve' when status=2 then 'Rejected' else '' end as reviewStatus"),DB::raw("(select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=vehicleId) as vehicleName"),DB::raw("(select name from users where id=userId) as userName "),DB::raw("case when (select concat('".$profileImgPath."',App_Image) from users where id=userId) is null then '' else (select concat('".$profileImgPath."',App_Image) from users where id=userId) end as userImg"),DB::raw("date_format(createdOn,'%b %d,%Y') as reviewDate"))->where('vehicleId','=',$vehicleId)->paginate(2);

        
        /* End Review data */
        $data['type']= $type ;
        $data['vehicleId'] = $vehicleId ;
        $data['ratingReview'] = $ratingReview ;

       echo view('admin/carManagement/ratingReview',$data);

    }

    public function carRentBooking(Request $request){

        $vehicleId = isset($request->vehicleId)?$request->vehicleId:'' ;
       $type = isset($request->type)?$request->type:'' ;
       $data['type']= $type ;
        $data['vehicleId'] = $vehicleId ;
       echo view('admin/carManagement/rentBooking',$data);
      
    }

    public function updateDescription(Request $request){
        
        $description = $request->vehicleDescr ;
        $updateId = $request->updateId ;

        $updateData=array(
            'description'=>$description
        );
            
        try{
            DB::table('vehicle')->where('id',$updateId)->update($updateData) ;
              echo successResponse([],'updated successfully.');  
        }
        catch(Exception $e){
             echo errorResponse('error occurred'); 
        }

    }

    public function addFeature(Request $request){
        $vehicleId = $request->vehicleId ;
        $vehicleFeature = "select vf.id as featureId,vf.title,case when (select isSelected from vehicle_featuremap where vehicleId=? and featureId=vf.id) is null then 0 else (select isSelected from vehicle_featuremap where vehicleId=? and featureId=vf.id) end as isSelected from vehicle_feature as vf where vf.status=1" ;
        $featureInfo = DB::select($vehicleFeature,[$vehicleId,$vehicleId]);
        $data['total_feature']=count($featureInfo) ;
         $data['featureInfo']=$featureInfo ;
         $data['vehicleId']=$vehicleId ;
        echo view('admin/carManagement/addFeature',$data);  

    }

    public function updateVFeature(Request $request){

        $vehicleId = $request->vehicleId ;
        $totalFeature = $request->total_feature ;
            $insertData=array() ;

          for ($i=0; $i < $totalFeature; $i++) { 
               
                $field_1='featureId'.$i ;
                $field_2='feature_title'.$i ;

                $insertData[]=array(
                    "vehicleId"=>$vehicleId ,
                    "featureId"=> $request->{$field_1},
                    "isSelected"=> $request->{$field_2} 
                );
            }  


         try{
              $qry="delete from vehicle_featuremap where vehicleId=".$vehicleId ;
              DB::select($qry);
              DB::table('vehicle_featuremap')->insert($insertData) ;

              echo successResponse([],'updated successfully.');  
        }
        catch(Exception $e){
             echo errorResponse('error occurred'); 
        }
    }

    public function deleteCarImg(Request $request){
       // image unlink pending 
        $imgId = $request->imgId ;
        $vehicleId = $request->vehicleId ;
        $isFeatured = isset($request->isFeatured)?$request->isFeatured:0 ;

        if($isFeatured!=1){
   
          $qryExe=DB::select("select id,isFeatured from vehicle_image where id=".$imgId." and status=1 limit 1") ;
        
           $isFeatured = isset($qryExe[0]->isFeatured)?$qryExe[0]->isFeatured:0 ;
  
        }
        

        $vehicleData=vehicle_images::find($imgId) ;
      
       $imgPath='app/public/vehicleImage/' ;
       $prevImage=storage_path($imgPath.$vehicleData->image) ;
       $prevAppImage=storage_path($imgPath.'thumbnail/'.$vehicleData->bigImage) ;
       $prevAppImage_=storage_path($imgPath.'thumbnail/'.$vehicleData->appImage) ;
       $unlinkFiles = array($prevImage, $prevAppImage,$prevAppImage_);

          try{

             if(!empty($unlinkFiles)){
            do_upload_unlink($unlinkFiles);
          }


         DB::delete('delete from vehicle_image where id = ? and vehicleId= ?',[$imgId,$vehicleId]);

        $imageId = 0 ;
        $img =  '' ;


        if($isFeatured==1){
          // update vehicle_image set  where vehicleId=7 limit 1
          $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';

          $qryExe=DB::select("select id,case when appImage is null then '' else concat('".$file_path."',appImage) end as appImage from vehicle_image where vehicleId=".$vehicleId." and status=1 limit 1") ;
       
           $imageId = isset($qryExe[0]->id)?$qryExe[0]->id:0 ;
           $img =  isset($qryExe[0]->appImage)?$qryExe[0]->appImage:0 ;

            $updateData= array(
              'isFeatured'=>1 
            ) ;
           
          
            $updateId=DB::table("vehicle_image")->where('id','=',$imageId)->update($updateData) ;
        
        }

        $response = array('imageId'=>$imageId,'imageUrl'=>$img,'isFeatured'=>$isFeatured) ;

         echo successResponse($response,'deleted successfully.');  
       }
        catch(Exception $e){
             echo errorResponse('error occurred'); 
        }
    }

     public function uploadVImg(Request $request){

       $vehicleId = $request->vehicleId ;
           $rules = [
         'vehicleId' => 'required',
         'vehicleImg' => 'required|mimes:jpeg,png,jpg,gif,svg',
       ] ;

     

    //  $validatedData = Validator::make($request->all(),$rules);

    // if($validatedData->fails()){  
    //     echo errorResponse($validatedData->errors()->first());       
    //     exit ;
    // }

      try{

      if($request->hasFile('vehicleImg')) {
        
        //get filename with extension
        $filenamewithextension = $request->file('vehicleImg')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('vehicleImg')->getClientOriginalExtension();
  
       
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
        $mediumthumbnail = $filename.'_500_500_'.time().'.'.$extension;

        //Upload File
        $request->file('vehicleImg')->storeAs('public/vehicleImage', $filenametostore);
        $request->file('vehicleImg')->storeAs('public/vehicleImage/thumbnail', $smallthumbnail);
        $request->file('vehicleImg')->storeAs('public/vehicleImage/thumbnail', $mediumthumbnail);
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/vehicleImage/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
 
        //create medium thumbnail
        $mediumthumbnailpath = public_path('storage/vehicleImage/thumbnail/'.$mediumthumbnail);
        $this->createThumbnail($mediumthumbnailpath, 500, 500);

        $checkImg=vehicle_images::where("vehicleId",$request->vehicleId)->get()->toArray();

     

       
         
        if(empty($checkImg)){
          $isFeatured=1 ;
        }else{
          $isFeatured=0 ;
        }
           $insertData = array(

              "vehicleId"=>$request->vehicleId ,
              "image"=>$filenametostore,
              "bigImage"=>$mediumthumbnail ,
              "appImage"=>$smallthumbnail ,
              "isFeatured"=>$isFeatured
            );

           $file_path = url('/').'/public/storage/vehicleImage/thumbnail/'.$smallthumbnail;
            DB::table('vehicle_image')->insert($insertData);
            $response=array("carImg"=>$file_path,'isFeatured'=>$isFeatured) ;
          echo successResponse($response,'Image save successfully.');  
        }else{
            
             echo errorResponse('Invalid request.');     
        }

      }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }

     }
   
    public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function addFeaturedImg(Request $request){

        $vehicleId = $request->vehicleId ;
        $imgId = $request->imgId ;

       $rmImgFeature="update vehicle_image set isFeatured=0 where vehicleId=".$vehicleId ;

       $addFeature="update vehicle_image set isFeatured=1 where vehicleId=".$vehicleId." and id=".$imgId ;
       try{
              DB::Select($rmImgFeature) ;
              DB::Select($addFeature) ;
            echo successResponse([],'changed feature image successfully.');  
        }catch(\Exception $e)
        {
             echo errorResponse('Error occurred.');     
          
        }
    }

     public function carBookingData(Request $request){
      
       $vehicleId = isset($request->vehicleId)?$request->vehicleId:'' ; 
       $type = isset($request->type)?$request->type:'' ;
      
       if($type==2){
        $cond = "where userId=".$vehicleId ;
       }else if($type==1){
        $cond = "where vehicleId=".$vehicleId ;
       }else{
        $cond = '' ;
       }

      $carBooking = "select id,id as id0,user_name,user_email,case when (select mobile_Number from users where id=userId) is null then '' else (select mobile_Number from users where id=userId) end  as mobile_Number ,pickupTo,returnTo, Date_format(bookingDate,'%d %M %Y & %h : %i %p') as bookingDate, Date_format(returnDate,'%d %M %Y & %h : %i %p') as returnDate,concat(amount,'AED') as amount, case when paymentType=1 then 'Credit Card' when paymentType=2 then 'Debit Card' when paymentType=3 then 'Net Banking' when paymentType=4 then 'Cash' else '' end as paymentType,case when paymentStatus='CAPTURED' then 'Success' else 'Failed' end as paymentStatus,vehicleId from booking  ".$cond ; 

        $carBookingData = DB::select($carBooking); 
        $tableData = Datatables::of($carBookingData)->make(true);  
        return $tableData; 

     }

     public function bookingDetail(Request $request){

        $data['title']='LetsGo' ;
        $bookingId = $request->bookingId ;
        $type=isset($request->type)?$request->type:1 ;

        $file_path = url('/').'/public/storage/vehicleImage/thumbnail/';
     $carBooking = "select b.id,b.id as id0,b.user_name,b.userId,b.user_email,case when (select mobile_Number from users where id=b.userId) is null then '' else (select concat('+',mobile_Code,mobile_Number) as mobile_Number from users where id=b.userId) end  as mobile_Number,(select concat(House_Number,',',LandMark,',',City,'-',Zipcode,',',State,',',Country) from users where id=b.userId) as address ,b.pickupTo,b.returnTo, Date_format(b.bookingDate,'%d %M %Y & %h:%i %p') as bookingDate, Date_format(b.returnDate,'%d %M %Y & %h:%i %p') as returnDate,concat(b.amount,' ','AED') as amount, case when b.paymentType=1 then 'Credit Card' when b.paymentType=2 then 'Debit Card' when b.paymentType=3 then 'Net Banking' when b.paymentType=4 then 'Cash'   else '' end as paymentType,case when b.paymentStatus='CAPTURED' then 'Paid' else 'Failed' end as paymentStatus,b.vehicleId,concat(v.manufacturer,' , ',v.model) as vehicleName ,case when (select appImage from vehicle_image where vehicleId=b.vehicleId and isFeatured=1) is null then '' else (select concat('".$file_path."',appImage) from vehicle_image where vehicleId=b.vehicleId and isFeatured=1) end as vImg from booking as b inner join vehicle as v on v.id=b.vehicleId where b.id=".$bookingId ; 

       $carBookingData = DB::select($carBooking); 
       $carBInfo = isset($carBookingData[0])?$carBookingData[0]:array() ;
       $vehicleId = isset($carBInfo->vehicleId)?$carBInfo->vehicleId:0 ;
       $vehicleOwner = vehicles::find($vehicleId);
       $vehicleUserId = isset($vehicleOwner->userId)?$vehicleOwner->userId:0 ;

       $ownerQry = "select name , email,concat('+',mobile_Code,mobile_Number) as mobile_Number,concat(House_Number,',',LandMark,',' ,City,'-',Zipcode, ',',State, ',',Country) as address   from users where id=".$vehicleUserId ;

       $vehicleOwnerInfo = DB::select($ownerQry);
       $vOwnerInfo = isset($vehicleOwnerInfo[0])?$vehicleOwnerInfo[0]:array() ;

       $data['vehicleId']=$vehicleId ;
       $data['bookingId']=$bookingId ;
       $data['carBookingInfo'] = $carBInfo ;
       $data['carOwnerInfo'] = $vOwnerInfo ;
       $data['type'] = $type ;
       
        echo view('admin/carManagement/bookingDetail',$data);  
     }

     public function viewVehicleImage(Request $request){

        $bookingId = $request->input('bookingId') ;
         ;

         $file_path = url('/').'/public/storage/bookingImg/';
         $bookingImg="select bookingId , case when image is null then '' else concat('".$file_path."',image) end as image  from bookingimg where bookingId=".$bookingId ;

       // $vehicleImg="select id,vehicleId,case when bigImage is null then '' else concat('".$file_path."',bigImage) end as image,isFeatured from vehicle_image where vehicleId=".$vehicleId." and status=1" ;

        $vImgData = DB::Select($bookingImg) ;
       $data['vehicleImg']=$vImgData ;
        // $data['vehicleId'] = $vehicleId ;
       echo view('admin/carManagement/vehicleBookingImg',$data);

     }

    public function carManagement_ajaxReview(Request $request){

        $vehicleId = isset($request->vehicleId)?$request->vehicleId:0 ;
        
        $profileImgPath=url('/').Config('constants.options.profile_thumb_imgPath');
 
        $ratingReview = DB::table("vehicle_review")->select('id','userId','status' ,'review','rating',DB::raw("case when status=0 then 'Pending' when status=1 then 'Approve' when status=2 then 'Rejected' else '' end as reviewStatus"),DB::raw("(select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=vehicleId) as vehicleName"),DB::raw("(select name from users where id=userId) as userName "),DB::raw("case when (select concat('".$profileImgPath."',App_Image) from users where id=userId) is null then '' else (select concat('".$profileImgPath."',App_Image) from users where id=userId) end as userImg"),DB::raw("date_format(createdOn,'%b %d,%Y') as reviewDate"))->where('vehicleId','=',$vehicleId)->paginate(2);

         echo view('admin/rating/ajax_rating', compact('ratingReview'));

    }
}
