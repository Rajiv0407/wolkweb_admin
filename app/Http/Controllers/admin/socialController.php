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
  $carQry="select usp.id,u.name as name,usp.total_point,usp.avg_point,usp.status,case when usp.status=1 then 'Active' else 'Inactive' end as status_,u.id as userId from user_social_point as usp inner join users as u on usp.user_id=u.id";   
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


    public function userPoint_detail(Request $request){
      $data['title']=siteTitle();
   
      $userId = isset($request->id)?$request->id:0 ;
      $user_point=DB::table('user_social_point as us')->select('u.name','us.fb_friends_count','us.fb_page_followers_count','us.fb_page_likes_count',
      'us.fb_post_comment','us.fb_post_likes','us.fb_post_count','us.insta_followers_count','us.insta_follows_count',
      'us.insta_total_post_count','us.insta_post_comment_count','us.insta_post_likes_count','us.tiktok_followers_count','us.tiktok_follows_count','us.tiktok_likes_count',
      'us.tiktok_video_likes_count','us.tiktok_video_shares_count','us.tiktok_video_comments_count','us.tiktok_video_view_count','us.total_point','us.avg_point')
      ->join('users as u', 'u.id', '=', 'us.user_id')
      ->where('us.user_id',$userId)
      ->first();
     $data['user_point']=$user_point ;
     $user=(array)$user_point ;    
      //facebook data
      $data['user_fb']=(array)DB::table('fb_user_info')->where('userId',$userId)->first();
      //insta data
      $data['user_insta']=(array)DB::table('insta_user_info')->where('userId',$userId)->first();
      //tiktok data
      $data['user_titktok']=(array)DB::table('tiktok_user_info')->where('userId',$userId)->first();          
      $data['social_weightage']=DB::table('social_media_weightage')->where('status',1)->get();
      $userPointW=array();
      if(!empty($data['social_weightage'])){
        foreach($data['social_weightage'] as $val){
          if($val->slug=='fb_post_comments'){
            $point=isset($user['fb_post_comment'])?$user['fb_post_comment']:0;
          }else if($val->slug=='insta_total_post_counts'){
            $point=isset($user['insta_total_post_count'])?$user['insta_total_post_count']:0;
          }else if($val->slug=='insta_total_post_comment_counts'){
            $point=isset($user['insta_post_comment_count'])?$user['insta_post_comment_count']:0;
          }else if($val->slug=='insta_total_post_likes_count'){
            $point=isset($user['insta_post_likes_count'])?$user['insta_post_likes_count']:0;
          }else if($val->slug=='tiktok_video_views_count'){
            $point=isset($user['tiktok_video_view_count'])?$user['tiktok_video_view_count']:0;
          }else{
            $point=isset($user[$val->slug])?$user[$val->slug]:0;
          }
          $val->point = $point ;
          $userPointW[]=$val ;
          }          
      }

      $data['userPointW']=$userPointW ;      
      echo view('admin/userSocialManagement/userPointDetail',$data);
    }

    public function subscriptionList(Request $request){
        
      $data['title']=siteTitle();
      //$data['user_social_point']=DB::table('user_subscriber')->where('status',1)->get();
      echo view('admin/subscriptions/index',$data); 
    
    } 

    public function subscriber_datatable(Request $request){  
      $data['title']=siteTitle();
      $carQry="select id,name,email,status,case when status=1 then 'Active' else 'Inactive' end as status_ from user_subscriber";   
      $carData = DB::select($carQry); 
      $tableData = Datatables::of($carData)->make(true);
      
      return $tableData;
    }
    
    public function subscriberStatus(Request $request)
    {
        //echo $request->id;die;
        $id=$request->id ;
        $qry="update user_subscriber set status=(case when status=1 then 0 else 1 end) where id=".$id;
        try{
           DB::select($qry);    
            echo successResponse([],'changed status successfully');          
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred');          
        }

    }    

    
    public function subscriptionDelete(Request $request){
  
      $deleteId=isset($request->id)?$request->id:'' ;
      try{
              DB::table('user_subscriber')->where('id', $deleteId)->delete();
  
            echo successResponse([],'successfully deleted'); 
      }
       catch(\Exception $e){
           echo errorResponse('error occurred'); 
       }
  
  }

}

?>