<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB ; 
use App\models\social ;   
use Image ;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller  
{
    public function socialList(Request $request){
        
        $data['title']=siteTitle();
        $data['social_media_weightage']=DB::table('social_media_weightage')->where('status',1)->get();
        echo view('admin/socialManagement/index',$data); 

    }    

    public function socialDatatable(Request $request){
        $data['title']=siteTitle();
        $carQry="select id,title,weightage,status,case when status=1 then 'Active' else 'Inactive' end as status_ from social_media_weightage" ;   
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);
        return $tableData;     
    } 

    public function socialStatus(Request $request)
    {
        //echo $request->id;die;
        $id=$request->id ;

        $qry="update social_media_weightage set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function editsocial(Request $request){

        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
       // echo $updatedId;die;
         $socialmediaweightage = DB::table('social_media_weightage')->where('id',$updatedId)->first() ;
         $data['socialmediaweightage'] = $socialmediaweightage ;
         $data['updatedId']=$updatedId ;

        echo view('admin/socialManagement/editsocial',$data);
  }

  public function updatesocial(Request $request){
        $data['title']=siteTitle();
        $updatedId = isset($request->updatedId)?$request->updatedId:0 ;
        $edit_social_title=isset($request->edit_social_title)?$request->edit_social_title:'' ;
        $edit_social_weightage = isset($request->edit_social_weightage)?$request->edit_social_weightage:'' ;
        $updateData=array(
            'title'=>$edit_social_title ,
            'weightage'=>$edit_social_weightage
        );
        try{   			
            DB::table('social_media_weightage')->where('id',$updatedId)->update($updateData);
           echo successResponse([],'Updated successfully'); 

        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
  }

  public function SaveSocial(Request $request){
    $data['title']=siteTitle();
    $social_title=isset($request->social_title)?$request->social_title:'' ;
    $weightage_ = isset($request->weightage)?$request->weightage:'' ;
    $insertData=array(
        'title'=>$social_title ,
        'weightage'=>$weightage_,          
    );		
    try{
                     
        DB::table('social_media_weightage')->insert($insertData);
       echo successResponse([],'Save successfully'); 

    }
     catch(\Exception $e)
    {
      echo errorResponse('error occurred'); 
     
    }

  }

  public function socialDelete(Request $request){
  
    $deleteId=isset($request->id)?$request->id:'' ;
    try{
            DB::table('social_media_weightage')->where('id', $deleteId)->delete();

          echo successResponse([],'successfully deleted'); 
    }
     catch(\Exception $e){
         echo errorResponse('error occurred'); 
     }

}


public function userPointList(Request $request){
        
  $data['title']=siteTitle();
  $data['user_social_point']=DB::table('user_social_point')->where('status',1)->get();
  echo view('admin/userSocialManagement/index',$data); 

} 

public function userPointDatatable(Request $request){  
  $data['title']=siteTitle();
  $carQry="select usp.id,u.name as name,usp.total_point,usp.avg_point,usp.status,case when usp.status=1 then 'Active' else 'Inactive' end as status_ from user_social_point as usp inner join users as u on usp.user_id=u.id";   
  //echo "<pre>";print_r($carQry);die; 
  $carData = DB::select($carQry); 
  $tableData = Datatables::of($carData)->make(true);
  
  return $tableData;
}

public function userPointStatus(Request $request)
    {
        //echo $request->id;die;
        $id=$request->id ;

        $qry="update user_social_point set status=(case when status=1 then 0 else 1 end) where id=".$id;

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

?>