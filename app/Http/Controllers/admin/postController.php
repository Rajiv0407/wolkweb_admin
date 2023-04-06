<?php
//
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB ; 
use App\models\countries ;
use Image ;
use Illuminate\Support\Facades\Validator;

class postController extends Controller
{


    public function postList(Request $request){

        $data['title']=siteTitle();

        echo view('admin/postManagement/index',$data);

    }    

    public function post_datatable(Request $request){

        $data['title']=siteTitle();
        $usrImg = config('constants.user_image'); 
        $carQry="select p.id,u.name,case when (u.image is null || u.image='') then '' else concat('".$usrImg."',u.image) end as image,u.username,p.message,
        (select count(*) from post_likes where post_id=p.id and isLike=1 and status=1) as total_like,(select count(*) from post_comments where postId=p.id and status=1) as total_comment,
        (select count(*) from post_share where post_id=p.id and status=1) as total_share,case when p.status=1 then 'Active' else 'Inactive' end as status_,p.createdOn,p.status   from posts as p 
        inner join users as u on u.id=p.userId" ;  
    
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }

    public function postStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update posts set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    public function postDetail(Request $request){
        $data['title']=siteTitle();
        $data['postId']=$request->postId ;    
        $data['post']=DB::table('posts')
        ->select('posts.id','u.name','posts.message','posts.createdOn',DB::raw("case when posts.status=1 then 'Active' else 'Inactive' end as status"))
        ->join('users as u','u.id','=','posts.userId')
        ->where('posts.id',$request->postId)
        ->first(); 
        
        echo view('admin/postManagement/postDetail',$data);
    } 

    public function postCommentListing(Request $request){

       $postId = isset($request->postId)?$request->postId:'' ; 
       $type = isset($request->type)?$request->type:'' ;
       $data['type']= $type ;
        $data['postId'] = $postId ;
        if($type==2){
            echo view('admin/postManagement/commentListing',$data);
        }else if($type==3){
            echo view('admin/postManagement/shareListing',$data);
        }else if($type==1){
            echo view('admin/postManagement/likeListing',$data);
        } else if($type==4){
            echo view('admin/postManagement/postFileListing',$data);
        }      
      
    }
    
    
    public function postComments_datatable(Request $request){

        $data['title']=siteTitle();
        $postId=$request->postId ;
        $type=$request->type ;

        $usrImg = config('constants.user_image'); 
        
        $carQry="select pc.id,u.name,comment,case when pc.status=1 then 'Active' else 'Inactive' end as status_,pc.createdOn,pc.status from post_comments as pc
        inner join users as u on u.id=pc.userId where postId=".$postId ;  
    
        $carData = DB::select($carQry); 
        $tableData = Datatables::of($carData)->make(true);  
        return $tableData; 
    }
    

    public function commentStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update post_comments set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }

    }

    
    public function deleteComment(Request $request){

        $id=isset($request->id)?$request->id:'' ;
      try{
        DB::table('post_comments')->where('id',$id)->delete();
              
        return $this->successResponse([],'This comment has been deleted successfully'); 
      }
       catch(\Exception $e){
           return $this->errorResponse('error occurred'); 
       }
  }

  public function like_datatable(Request $request){

    $data['title']=siteTitle();
    $postId=$request->postId ;
    $type=$request->type ;
    
    $usrImg = config('constants.user_image');     
    $carQry="select pl.id,u.name,case when pl.status=1 then 'Active' else 'Inactive' end as status_,pl.createdOn,pl.status from post_likes as pl
    inner join users as u on u.id=pl.user_id where
       pl.post_id=".$postId ;   //.

    $carData = DB::select($carQry); 
    $tableData = Datatables::of($carData)->make(true);  
    return $tableData; 
}



public function likeStatus(Request $request)
    {

        $id=$request->id ;

        $qry="update post_likes set status=(case when status=1 then 0 else 1 end) where id=".$id;

        try{

           DB::select($qry);    
            echo successResponse([],'changed status successfully'); 
         
        }
         catch(\Exception $e)
        {
          echo errorResponse('error occurred'); 
         
        }
       
    }

    public function deletelike(Request $request){

        $id=isset($request->id)?$request->id:'' ;
      try{
        DB::table('post_likes')->where('id',$id)->delete();
              
            return $this->successResponse([],'This like has been deleted successfully'); 
      }
       catch(\Exception $e){
           return $this->errorResponse('error occurred'); 
       }
  }

  public function share_datatable(Request $request){

    $data['title']=siteTitle();
    $postId=$request->postId ;
    $type=$request->type ;
    
    $usrImg = config('constants.user_image');     
   $carQry="select pl.id,u.name,case when pl.status=1 then 'Active' else 'Inactive' end as status_,pl.createdOn,pl.status from post_share as pl
    inner join users as u on u.id=pl.user_id where  pl.post_id=".$postId ;   //.
      

    $carData = DB::select($carQry); 
    $tableData = Datatables::of($carData)->make(true);  
    return $tableData; 
}
public function shareStatus(Request $request)
{

    $id=$request->id ;

    $qry="update post_share set status=(case when status=1 then 0 else 1 end) where id=".$id;

    try{

       DB::select($qry);    
        echo successResponse([],'changed status successfully'); 
     
    }
     catch(\Exception $e)
    {
      echo errorResponse('error occurred'); 
     
    }

}
public function deleteShare(Request $request){

    $id=isset($request->id)?$request->id:'' ;
  try{
    DB::table('post_share')->where('id',$id)->delete();
          
        return $this->successResponse([],'This share has been deleted successfully'); 
  }
   catch(\Exception $e){
       return $this->errorResponse('error occurred'); 
   }
}


public function post_file_datatable(Request $request){

    $data['title']=siteTitle();
    $postId=$request->postId ;
    $type=$request->type ;
    
    $postImg = config('constants.post_image').$postId.'/';     
   $carQry="select id,case when image is null then '' else concat('".$postImg."',image) end as image,case when file_type=1 then 'Image' when file_type=2 then 'Video' when file_type=3 then 'Audio' else '' end as fileType,
   case when status=1 then 'Active' else 'Inactive' end as status_,createdOn,status,file_type from post_images where postId=".$postId ;   //.
      
    $carData = DB::select($carQry); 
    $tableData = Datatables::of($carData)->make(true);  
    return $tableData; 
}

public function postFileStatus(Request $request)
{

    $id=$request->id ;

    $qry="update post_images set status=(case when status=1 then 0 else 1 end) where id=".$id;

    try{

       DB::select($qry);    
        echo successResponse([],'changed status successfully'); 
     
    }
     catch(\Exception $e)
    {
      echo errorResponse('error occurred'); 
     
    }

}

public function deletePostFile(Request $request){

    $id=isset($request->id)?$request->id:'' ;
  try{
    DB::table('post_images')->where('id',$id)->delete();
          
        return $this->successResponse([],'Deleted successfully'); 
  }
   catch(\Exception $e){
       return $this->errorResponse('error occurred'); 
   }
}

public function delete_post(Request $request){
    
    $id=isset($request->id)?$request->id:'' ;

    try{

      DB::table('posts')->where('id',$id)->delete();
      DB::table('post_comments')->where('postId',$id);
      DB::table('post_likes')->where('post_id',$id);
      DB::table('post_share')->where('post_id',$id);  
      DB::table('post_images')->where('postId',$id);  
            
          return $this->successResponse([],'Deleted successfully'); 
    }
     catch(\Exception $e){
         return $this->errorResponse('error occurred'); 
     }
}

}

?>