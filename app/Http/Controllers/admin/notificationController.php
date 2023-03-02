<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Notification_types;
use App\models\announcement_lists ;
use DB ;

class notificationController extends Controller
{
   public function index(Request $request){

    	$data['title']=siteTitle();
       	$nType = notification_types::all() ;
     	//$nFor = notification_fors::all() ;

     	$data['nType'] = $nType ;
     	//$data['nFor'] = $nFor ;

    	echo view('admin/notification/index',$data);

    }

     public function addNotify(Request $request){

    	$data['title']=siteTitle();
    	$nType = notification_types::all() ;
     	//$nFor = notification_fors::all() ;

     	$data['nType'] = $nType ;
     	//$data['nFor'] = $nFor ;

    	echo view('admin/notification/addNotification',$data);

    }
    
    public function saveNotify(Request $request){
    	
    	$title = isset($request->notify_title)?$request->notify_title:'' ;		 	
        $content = isset($request->nDescription)?$request->nDescription:'' ;
        $deviceType = isset($request->deviceType)?$request->deviceType:'' ; 
        $nType = isset($request->nType)?$request->nType:'' ; 
        //$nFor = isset($request->nFor)?$request->nFor:'' ;        		 	
        $deviceFor = isset($request->nFor)?$request->nFor:'' ;        		 	

    	$insertData = array(
    		"title"=>$title ,
    		"content"=>$content ,
    		"deviceType"=>$deviceType ,
    		"type"=>$nType 
    
    	);
        // ,
        // "nFor"=> $nFor
    	try{
    		announcement_lists::insert($insertData) ;
    		echo successResponse([],'save notification successfully'); 
    	}
    	catch(Exception $e){
    		echo errorResponse('error occurred'); 
    	}

    }

    public function detail(Request $request){

    	$data['title']=siteTitle();

    	echo view('admin/notification/notificationDetail',$data);

    }

    public function notify_datatable(){

    	$data['title']=siteTitle();


        $carQry="select al.id as id ,al.title,content , deviceType,case when al.type is null then '' else (select title from notification_type where id=al.type) end as nType , case when al.status=1 then 'Active' else 'Inactive' end as status_ , al.status from pe_announcement_list as al" ;

        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function editNotify(Request $request){

        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $announcementList = announcement_lists::find($updatedId) ;
        $data['announceInfo'] = $announcementList ;

       	$nType = notification_types::all() ;
     	//$nFor = notification_fors::all() ;

     	$data['nType'] = $nType ;
     	//$data['nFor'] = $nFor ;
     	$data['updatedId']=$updatedId ;
        echo view('admin/notification/editNotification',$data);

    }

    public function updateNotify(Request $request){

    	$updatedId = isset($request->updatedId)?$request->updatedId:'' ;	 	
    	$title = isset($request->notify_title)?$request->notify_title:'' ;		 	
        $content = isset($request->nDescription)?$request->nDescription:'' ;
        $deviceType = isset($request->deviceType)?$request->deviceType:'' ; 
        $nType = isset($request->nType)?$request->nType:'' ; 
        $nFor = isset($request->nFor)?$request->nFor:'' ;        		 	
        $deviceFor = isset($request->nFor)?$request->nFor:'' ;        		 	

    	$updateData = array(
    		"title"=>$title ,
    		"content"=>$content ,
    		"deviceType"=>$deviceType ,
    		"type"=>$nType 
    		
    	);
        // ,
    	// 	"nFor"=> $nFor
    	try{

    		announcement_lists::where('id',$updatedId)->update($updateData) ;
    		echo successResponse([],'updated notification successfully'); 
    	}
    	catch(Exception $e){
    		echo errorResponse('error occurred'); 
    	}


    }

    public function delete_aNList(Request $request){

    	  $id=isset($request->id)?$request->id:'' ;
        try{
                announcement_lists::where('id', $id)->firstorfail()->delete();
              echo successResponse([],'delete notification type successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }
    }


     public function announce_Status(Request $request)
    {

        $id=$request->id ;

        $qry="update pe_announcement_list  set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

 public function announce_detail(Request $request){
 	
 	    $nId = isset($request->id)?$request->id:0 ;
	    $announcementList = announcement_lists::find($nId) ;
        $data['announceInfo'] = $announcementList ;

       	$nType = notification_types::all() ;
     	//$nFor = notification_fors::all() ;

     	$data['nType'] = $nType ;
     	//$data['nForList'] = $nFor ;
     	$data['updatedId']=$nId ; 	

     	echo view('admin/notification/notificationDetail',$data);
 }

    public function notifyFor(Request $request){

        $data['title']=siteTitle();
        
        echo view('admin/master/notificationTitle/index',$data);

    }  

    public function saveNotifyFor(Request $request){
        $data['title']=siteTitle();
        $title=isset($request->sTitle)?$request->sTitle:'' ;

        $insertData=array(
            'title'=>$title ,
            'status'=>1
        );

         try{

           DB::table('pe_announcement_for')->insert($insertData);
            echo successResponse([],'saved successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function editNFor(Request $request){
        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $nFor = notification_fors::find($updatedId) ;

        $data['nFor'] = $nFor ;
        $data['updatedId']=$updatedId ;
        echo view('admin/master/notificationTitle/editNFor',$data);

    }

    public function updateNFor(Request $request){
        $title = isset($request->editSTitle)?$request->editSTitle:'' ;
        $updateId = isset($request->updatedId)?$request->updatedId:0;

        $updateData=array(
            "title"=>$title
        );

        try{

            DB::table('pe_announcement_for')->where('id',$updateId)->update($updateData);
            echo successResponse([],'saved successfully'); 
        } catch(\Exception $e) {
          echo errorResponse('error occurred'); 
         
        }

    }
    
    public function deleteNFor(Request $request){
         
         $id=isset($request->id)?$request->id:'' ;

        try{
                notification_fors::where('id', $id)->firstorfail()->delete();
              echo successResponse([],'delete notification for successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }        
    }

    public function nforStatus(Request $request){

        $id=isset($request->id)?$request->id:'' ;

        $qry="update pe_announcement_for  set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }
}
