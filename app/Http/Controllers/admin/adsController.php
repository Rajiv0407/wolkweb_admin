<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB ; 
use App\models\countries ;
use Image ;
use Illuminate\Support\Facades\Validator;

class adsController extends Controller
{


    public function adsList(Request $request){

        $data['title']=siteTitle();
        $data['sponser']=DB::table('sponser')->where('status',1)->get();
        echo view('admin/adsManagement/index',$data);

    }    

    public function ads_datatable(Request $request){

        $data['title']=siteTitle();
        $sponserImg = config('constants.sponser_image'); 
        $adsImg = config('constants.advertisement_image'); 
        $carQry="select ads.id,s.name,case when s.image is null then '' else concat('".$sponserImg."',s.image) end as sponserIcon,ads.title,
        case when ads.ad_type=1 then 'image' when ads.ad_type=2 then 'video' else '' end as adType,
        case when ads.image is null then '' else concat('".$adsImg."',ads.image) end as ads,ads.start_date,ads.end_date,case when ads.status=1 then 'Active' else 'Inactive' end as status_,ads.status 
                from advertisements as ads left join sponser as s on s.id=ads.sponser_id where ads.start_date is not null and ads.end_date is not null" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function adsStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update advertisements set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function editAds(Request $request){

        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
         $advertisement = DB::table('advertisements')->where('id',$updatedId)->first() ;
         $data['sponser']=DB::table('sponser')->where('status',1)->get();
         $data['advertisement'] = $advertisement ;
         $data['updatedId']=$updatedId ;

        echo view('admin/adsManagement/editAds',$data);
  }

  public function updateAds(Request $request){
        $data['title']=siteTitle();
        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $sponser_=isset($request->edit_sponser_)?$request->edit_sponser_:'' ;
        $adsTitle = isset($request->edit_ads_title)?$request->edit_ads_title:'' ;
        $adsType = isset($request->edit_ads_type)?$request->edit_ads_type:'' ;
        $startDate = isset($request->edit_startDate)?$request->edit_startDate:'' ;
        $endDate = isset($request->edit_endDate)?$request->edit_endDate:'' ;
        $filenametostore='';
        

        $introduction = isset($request->introduction)?$request->introduction:'' ;
        $objectives = isset($request->objectives)?$request->objectives:'' ;
        $media_mix = isset($request->media_mix)?$request->media_mix:'' ;
        $measurement = isset($request->measurement)?$request->measurement:'' ;
        $conclusion = isset($request->conclusion)?$request->conclusion:'' ;
        $target_audience = isset($request->target_audience)?$request->target_audience:'' ;
        $media_sample = isset($request->media_sample)?$request->media_sample:'' ;
        $is_accept = isset($request->is_accept)?$request->is_accept:'' ;
        
        $type = isset($request->type)?$request->type:0 ;

        
    
        $updateData=array(
            'sponser_id'=>$sponser_ ,
            'title'=>$adsTitle,
            'ad_type'=>$adsType ,  
            'start_date'=>$startDate ,  
            'end_date'=>$endDate         
        );
        
        if($type==1){
            $updateData['introduction']=$introduction ;
            $updateData['objectives']=$objectives ;
            $updateData['media_mix']=$media_mix ;
            $updateData['measurement']=$measurement ;
            $updateData['conclusion']=$conclusion ;
            $updateData['target_audience']=$target_audience ;
            $updateData['media_sample']=$media_sample ;
            $updateData['isAccept']=$is_accept ;
        }

        
        try{
            
            if($request->hasFile('edit_adsFile')) {
        
       
                $imgPath='app/public/sponser_image/' ;
                
              
                 $filenamewithextension = $request->file('edit_adsFile')->getClientOriginalName();
           
                 //get filename without extension
                 $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
           
                 //get file extension
                 $extension = $request->file('edit_adsFile')->getClientOriginalExtension();
           
                 $filename=str_replace(' ', '_', $filename);
                 $filenametostore = $filename.'_'.time().'.'.$extension;       
                 $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
                
                 //Upload File
                 $request->file('edit_adsFile')->storeAs('public/sponser_image', $filenametostore);
                // $request->file('sImage')->storeAs('public/star_type_img/thumb', $smallthumbnail);
                
                  
                 //create small thumbnail
                // $smallthumbnailpath = public_path('storage/star_type_img/thumb/'.$smallthumbnail);
                // $this->createThumbnail($smallthumbnailpath, 100, 100);                 
                $checkPV = DB::table('advertisements')->select(DB::raw('case when image is null then "" else image end as image'))->where('id',$updatedId)->first();
                if(isset($checkPV->image) && $checkPV->image!=''){
                    $unlinkPath = storage_path($imgPath.$checkPV->image) ;
                    do_upload_unlink(array($unlinkPath));
                }

                $updateData['image']=$filenametostore;
                }

              
                			
            DB::table('advertisements')->where('id',$updatedId)->update($updateData);
           echo successResponse([],'Updated successfully'); 

        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
  }

  public function SaveAdvertisement(Request $request){

    $data['title']=siteTitle();
    
    $sponser_=isset($request->sponser_)?$request->sponser_:'' ;
    $adsTitle = isset($request->ads_title)?$request->ads_title:'' ;
    $adsType = isset($request->ads_type)?$request->ads_type:'' ;
    $startDate = isset($request->startDate)?$request->startDate:'' ;
    $endDate = isset($request->endDate)?$request->endDate:'' ;
    $filenametostore='';



    $insertData=array(
        'sponser_id'=>$sponser_ ,
        'title'=>$adsTitle,
        'ad_type'=>$adsType ,  
        'start_date'=>$startDate ,  
        'end_date'=>$endDate         
    );
    		
    try{
        
        if($request->hasFile('adsFile')) {
    
   
            $imgPath='app/public/sponser_image/' ;
            
          
             $filenamewithextension = $request->file('adsFile')->getClientOriginalName();
       
             //get filename without extension
             $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
       
             //get file extension
             $extension = $request->file('adsFile')->getClientOriginalExtension();
       
             $filename=str_replace(' ', '_', $filename);
             $filenametostore = $filename.'_'.time().'.'.$extension;       
             $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
            
             //Upload File
             $request->file('adsFile')->storeAs('public/sponser_image', $filenametostore);
           
            $insertData['image']=$filenametostore;
            }

           
                        
        DB::table('advertisements')->insert($insertData);
       echo successResponse([],'Save successfully'); 

    }
     catch(\Exception $e)
    {
      echo errorResponse('error occurred'); 
     
    }

  }

  public function adsDelete(Request $request){

    $deleteId=isset($request->id)?$request->id:'' ;
    try{
            DB::table('advertisements')->where('id', $deleteId)->delete();

          echo successResponse([],'successfully deleted'); 
    }
     catch(\Exception $e){
         echo errorResponse('error occurred'); 
     }

}



public function advertisementDetail(Request $request){

    $data['title']=siteTitle();
   
    $updatedId = isset($request->id)?$request->id:0 ;
    $advertisement = DB::table('advertisements')->where('id',$updatedId)->first() ;
    $data['sponser']=DB::table('sponser')->where('status',1)->get();
    $data['advertisement'] = $advertisement ;
    $data['updatedId']=$updatedId ;

    echo view('admin/adsManagement/advertisementDetail',$data);

}

}

?>