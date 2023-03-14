<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Notification_types;
use App\models\announcement_lists ;
use DB ;
use Image ;
use File ;

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

           DB::table('notification_type')->insert($insertData);
            echo successResponse([],'saved successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function editNFor(Request $request){
        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $nFor = notification_types::find($updatedId) ;

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

            DB::table('notification_type')->where('id',$updateId)->update($updateData);
            echo successResponse([],'saved successfully'); 
        } catch(\Exception $e) {
          echo errorResponse('error occurred'); 
         
        }

    }
    
    public function deleteNFor(Request $request){
         
         $id=isset($request->id)?$request->id:'' ;

        try{
            notification_types::where('id', $id)->firstorfail()->delete();
              echo successResponse([],'delete notification for successfully'); 
        }
         catch(\Exception $e){
             echo errorResponse('error occurred'); 
         }        
    }

    public function nforStatus(Request $request){

        $id=isset($request->id)?$request->id:'' ;

        $qry="update notification_type  set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function rankType(Request $request){

        $data['title']=siteTitle();
        
        echo view('admin/master/rankType/index',$data);

    }
    
    public function save_rankType(Request $request){
        $data['title']=siteTitle();
        $title=isset($request->sTitle)?$request->sTitle:'' ;
        $rangeFrom = isset($request->range_from)?$request->range_from:'' ;
        $rangeTo = isset($request->rangeTo)?$request->rangeTo:'' ;
        $filenametostore='';
        try{
            
            if($request->hasFile('sImage')) {
        
       
                $imgPath='app/public/star_type_img/' ;
                
              
                 $filenamewithextension = $request->file('sImage')->getClientOriginalName();
           
                 //get filename without extension
                 $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           
                 //get file extension
                 $extension = $request->file('sImage')->getClientOriginalExtension();
           
                 $filename=str_replace(' ', '_', $filename);
                 $filenametostore = $filename.'_'.time().'.'.$extension;       
                 $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
                
                 //Upload File
                 $request->file('sImage')->storeAs('public/star_type_img', $filenametostore);
                // $request->file('sImage')->storeAs('public/star_type_img/thumb', $smallthumbnail);
                
                  
                 //create small thumbnail
                // $smallthumbnailpath = public_path('storage/star_type_img/thumb/'.$smallthumbnail);
                // $this->createThumbnail($smallthumbnailpath, 100, 100);                 
                   
          
                }

                $insertData=array(
                    'rank_title'=>$title ,
                    'range_from'=>$rangeFrom,
                    'range_to'=>$rangeTo,  
                    'star_img'=>$filenametostore,
                    'status'=>1
                );
             
            DB::table('rank_types')->insert($insertData);
           echo successResponse([],'saved successfully'); 

        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
    }

    public function createThumbnail($path, $width, $height)
    {
        
      $img = Image::make($path)->resize($width, $height)->save($path);
    }

    public function rankStatus(Request $request){

        $id=isset($request->id)?$request->id:'' ;

        $qry="update rank_types set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

        
    public function delete_rank(Request $request){
         
        $id=isset($request->id)?$request->id:'' ;

       try{
           DB::table('rank_types')->where('id', $id)->delete();
             echo successResponse([],'delete notification for successfully'); 
       }
        catch(\Exception $e){
            echo errorResponse('error occurred'); 
        }        
   }

   public function edit_rankType(Request $request){
    $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
    $nFor = DB::table('rank_types')->where('id',$updatedId)->first() ;

    $data['nFor'] = $nFor ;
    $data['updatedId']=$updatedId ;
    echo view('admin/master/rankType/editNFor',$data);

   }
   

   public function updateRank(Request $request){
    $data['title']=siteTitle();
    $title=isset($request->editSTitle)?$request->editSTitle:'' ;
    $rangeFrom = isset($request->edit_rangFrom)?$request->edit_rangFrom:'' ;
    $rangeTo = isset($request->editRangeTo)?$request->editRangeTo:'' ;
    $updatedId = isset($request->updatedId)?$request->updatedId:'' ;
    $filenametostore='';
    try{
          
        $insertData=array(
            'rank_title'=>$title ,
            'range_from'=>$rangeFrom,
            'range_to'=>$rangeTo
        );
       
       
        if($request->hasFile('editSImage')) {
    
   
            $imgPath='app/public/star_type_img/' ;
            
          
             $filenamewithextension = $request->file('editSImage')->getClientOriginalName();
       
             //get filename without extension
             $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
       
             //get file extension
             $extension = $request->file('editSImage')->getClientOriginalExtension();
       
             $filename=str_replace(' ', '_', $filename);
             $filenametostore = $filename.'_'.time().'.'.$extension;       
             $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
            
             //Upload File
             $request->file('editSImage')->storeAs('public/star_type_img', $filenametostore);
            // $request->file('sImage')->storeAs('public/star_type_img/thumb', $smallthumbnail);
            
              
             //create small thumbnail
            // $smallthumbnailpath = public_path('storage/star_type_img/thumb/'.$smallthumbnail);
            // $this->createThumbnail($smallthumbnailpath, 100, 100);                 
               
            $insertData['star_img']=$filenametostore ;
            }

           
         
        DB::table('rank_types')->where('id',$updatedId)->update($insertData);
       echo successResponse([],'saved successfully'); 

    }
     catch(\Exception $e)
    {
      echo errorResponse('error occurred'); 
     
    }
}


}
