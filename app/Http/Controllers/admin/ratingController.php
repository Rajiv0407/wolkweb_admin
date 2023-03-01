<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Pagination\Paginator ;
use App\Models\Contactus;
use DB ;


class ratingController extends Controller
{
      public function index(Request $request){

    	$data['title']='Walkofweb';
         $cond='' ;
         $vehicleId = isset($request->vehicleId)?$request->vehicleId:0 ;
      if($vehicleId > 0){
        $cond="where vehicleId=".$vehicleId ;    
      }

      
      $profileImgPath=url('/').Config('constants.options.profile_thumb_imgPath');
 
        $ratingReview = DB::table("vehicle_review")->select('id','userId','review','rating','status',DB::raw("case when status=0 then 'Pending' when status=1 then 'Approve' when status=2 then 'Rejected' else '' end as reviewStatus"),DB::raw("(select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=vehicleId) as vehicleName"),DB::raw("(select name from users where id=userId) as userName "),DB::raw("case when (select concat('".$profileImgPath."',App_Image) from users where id=userId) is null then '' else (select concat('".$profileImgPath."',App_Image) from users where id=userId) end as userImg"),DB::raw("date_format(createdOn,'%b %d,%Y') as reviewDate"))->where('vehicleId','<>','0')->paginate(10);

         $data['ratingReview']=$ratingReview ;
        ///paginate(2,['*'],'page',1);
        
           
        if ($request->ajax()) {
            return view('admin/rating/ajax_rating', $data);
        }
        return view('admin/rating/index',$data);

     
    }


    public function ajax_ratingReview(Request $request){
    	
        $name = isset($request->name)?$request->name:'' ;
        $carName = isset($request->carName)?$request->carName:'' ;
        $status = isset($request->status)?$request->status:'' ;
          
        
        $profileImgPath=url('/').Config('constants.options.profile_thumb_imgPath');
 
        $ratingReview = DB::table("vehicle_review")->select('id','status','userId','status' ,'review','rating',DB::raw("case when status=0 then 'Pending' when status=1 then 'Approve' when status=2 then 'Rejected' else '' end as reviewStatus"),DB::raw("(select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=vehicleId) as vehicleName"),DB::raw("(select name from users where id=userId) as userName "),DB::raw("case when (select concat('".$profileImgPath."',App_Image) from users where id=userId) is null then '' else (select concat('".$profileImgPath."',App_Image) from users where id=userId) end as userImg"),DB::raw("date_format(createdOn,'%b %d,%Y') as reviewDate"))->whereRaw("(select name from users where id=vehicle_review.userId)   like '%{$name}%' ")->whereRaw("case when status=0 then 'Pending' when status=1 then 'Approve' when status=2 then 'Rejected' else '' end like '%{$status}%'")->whereRaw("(select concat(manufacturer,' ',model) as vehicleModal from vehicle where id=vehicleId) like '%{$carName}%'")->where('vehicleId','<>','0')->paginate(10);

        echo view('admin/rating/ajax_rating', compact('ratingReview'));


    }

    public function contactSupport(Request $request){
        $data['title']='Walkofweb' ;
        echo view('admin/contactSupport/index',$data);

    }

    public function contactUs_datatable(){

        $data['title']='Walkofweb';


        $contactQry="select id,name,phone_number,email,subject,message from contactus" ;

        $contactus = DB::select($contactQry); 
        $tableData = Datatables::of($contactus)->make(true);  
        return $tableData; 
    }


   public function delete_contactus(Request $request){

          $id=isset($request->id)?$request->id:'' ;
        try{
                contactus::where('id', $id)->firstorfail()->delete();
              echo successResponse([],'deleted successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }


    public function productList(Request $request){

         $products = contactus::paginate(5);
        if ($request->ajax()) {
            return view('presult', compact('products'));
        }
        return view('productlist',compact('products'));
    }

    public function approveReview(Request $request){
      $reviewId = isset($request->reviewId)?$request->reviewId:'' ;

         $updateData = array(
          "status"=>1
         );

         try{

         DB::table("vehicle_review")->where('id',$reviewId)->update($updateData);
         echo successResponse([],'approved successfully'); 
       } catch(Exception $e){
            echo errorResponse('error occurred'); 
       }
    }

    public function rejectReview(Request $request){

       $reviewId = isset($request->reviewId)?$request->reviewId:'' ;

        $updateData = array(
          "status"=>2
         );

         try{

         DB::table("vehicle_review")->where('id',$reviewId)->update($updateData);
         echo successResponse([],'rejected successfully'); 
       } catch(Exception $e){
            echo errorResponse('error occurred'); 
       }
    }
}
