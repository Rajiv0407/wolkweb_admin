<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Models\Post_comment;
use App\Models\Post_image;
use App\Models\Post_like;
use App\Models\Post;
use DB ;
use Carbon\Carbon;

class postController extends Controller
{
    
    public function checkFileType($fileName){
      
        $imageExtensions = ['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd'];

        $videoExtensions = ['flv','mp4','m3u8','ts','3gp','mov','avi','wmv'];

        $audioExtensions = ['mp3'] ;

        $explodeImage = explode('.', $fileName);
        $extension = end($explodeImage);

        if(in_array($extension, $imageExtensions))
        {
        // Is image
          return 1 ;
        }else if(in_array($extension, $videoExtensions))
        {
        // Is video
          return 2 ;
        }else if(in_array($extension, $audioExtensions)){
          // is audio 
          return 3 ;
        }else{
          return 4 ;
        }
    }
    public function save_post(Request $request){

		   $userId = authguard()->id;
		$validatedData = Validator::make($request->all(),[
		'message'=>'required'    		
	    ]);

		 if($validatedData->fails()){       
	        return $this->errorResponse($validatedData->errors()->first(), 401);
	      }

	      try{


	     $file_path=array();
	     $insert=array();
	     $post=Post::create(['userId'=>$userId,'message'=>$request->message]);
	      
			// if(!$request->hasFile('image')) {
			// return response()->json(['upload_file_not_found'], 400);
			// }

			

    if($request->hasfile('image')){
   
    $allowedfileExtension=['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','flv','mp4','m3u8','ts','3gp','mov','avi','wmv','mp3'];

		$files = $request->file('image'); 
		$errors = [];


			foreach($files as $file)
			{
        $fileType=0 ;

        $mimeType=$file->getMimeType() ;
        
       
         
				 $filenamewithextension = $file->getClientOriginalName(); 
				 $extension = $file->getClientOriginalExtension();  
			   $check = in_array($extension,$allowedfileExtension);
         $fileType = $this->checkFileType($filenamewithextension);

			     if($check){

			     	$filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
			        $filename=str_replace(' ', '_', $filename);
			        $filenametostore = $filename.'_'.time().'.'.$extension;       
			        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
			       
			        
			        $file->storeAs('public/post_image/'.$post->id.'/', $filenametostore);

       				$insert[]=array(
                    'user_id'=>$userId,
				            'postId'=>$post->id,
				            'image'=>$filenametostore,
                    'file_type'=>$fileType
				           );

                   $file_path[]= url('/').'/public/storage/post_image/'.$post->id.'/'.$filenametostore;
       
			     }
       		}

       		 if(!empty($insert)){       		 
       		 	Post_image::insert($insert);
       		 }

            }	    
	        return $this->successResponse([],'Successfull saved post',200);   
	     } catch(Exception $e){
	      	 return $this->errorResponse('something went wrong', 401);	
	      }
    }

    public function save_comment(Request $request){

    	$validatedData = Validator::make($request->all(),[
    		'postId'=>'required|numeric',
    		'comment' => 'required'
    	]);

    	 if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }
          
          $userId = authguard()->id ;
          $request['userId'] = $userId ;
             
          if(Post_comment::create($request->all())){
          	return $this->successResponse([],'Successfull saved comment',200);   
          }else{
          	 return $this->errorResponse('something went wrong.'.$e, 422);
          }
    }

   
    public function post_list(Request $request){

       $star_imgPath=config('constants.star_image') ;
      $filePath = config('constants.user_image') ;
      $image = DB::raw('case when concat("'.$filePath.'",users.image) is null then "" else concat("'.$filePath.'",users.image) end as image') ;
      $strImg=DB::raw('concat("'.$star_imgPath.'",star_img) as starImg');

     
    	$userId=authguard()->id ;
      $comment=Post::select('posts.id','posts.message','users.name',DB::raw('concat("@",username) as username'),'users.rank_type',$image,$strImg,'posts.createdOn')->join('users','users.id','=','posts.userId')->join('rank_types','rank_types.id','=','users.rank_type')
      ->where('posts.status',1)->where('users.isTrash',0)->get() ;

      $response=array();
      $postLike = new Post_like();
      $postImage = new Post_image();

      foreach ($comment as $key => $value) {
        $postId=$value->id ;
        $totalComment = Post_comment::all()->where('postId',$postId)->count();
        $value->totalComment = $totalComment ;        
        $post_image = $postImage->getPostImage($postId);
        $value->postImage = $post_image ;
        $value->totalLike = $postLike->getTotalLike($postId);
        $date = Carbon::parse($value->createdOn); // now date is a carbon instance
        $elapsed = $date->diffForHumans(Carbon::now());
        $elapsed=createdAt($elapsed) ;

        $value->createdOn =$elapsed ;
        $response[]=$value ;
      }

      return $this->successResponse($response,'Post List',200);   
    }

   public function add_like(Request $request){
   	  $validatedData = Validator::make($request->all(),[
   	  	"postId"=>'required'
   	  ]);

  	 if($validatedData->fails()){       
      return $this->errorResponse($validatedData->errors()->first(), 401);
    }

    $userId = authguard()->id ;

    $data=Post_like::all()->where('post_id',$request->postId)->first();
    if(!empty($data)){
      $isLike = ($data->isLike==1)?0:1 ;
      Post_like::where('post_id',$request->postId)->update(['isLike'=>$isLike]);
    }else{
      Post_like::create(['post_id'=>$request->postId,'user_id'=>$userId,'isLike'=>1]);
    }

    return $this->successResponse([],'Successfull updated like',200);   

   }

   public function post_detail(Request $request){
      $validatedData = Validator::make($request->all(),[
        "postId"=>'required'
      ]); 

     if($validatedData->fails()){       
      return $this->errorResponse($validatedData->errors()->first(), 401);
    }

     $postId = $request->postId ;
     $postImgPath = config('constants.post_image').$postId.'/';
     $userImg = config('constants.user_image');
     
     $post = Post::all()->where('id',)->first();
     $image = DB::table('post_images')->select(DB::raw('concat("'.$postImgPath.'",image) as image'))->where('postId',$postId)->get();
     $post->image=$image ;
     $postLikes = DB::table('post_likes')->select(DB::raw('count(*) as total_Like'))->where('post_id',$postId)->where('isLike',1)->first();
     $usrImage = DB::raw('case when concat("'.$userImg.'",users.image) is null then "" else concat("'.$userImg.'",users.image) end as image');
     $postComment = DB::table('post_comments')->select('users.name','users.username','users.rank_type',$usrImage,'post_comments.id','comment','post_comments.createdOn')
        ->where('postId',$postId)
        ->where('status',1)
        ->join('users', 'users.id', '=', 'post_comments.userId')        
        ->get();
     $response_post = array() ;
     if(!empty($postComment)){
        foreach ($postComment as $key => $value) {
          $commentLike = DB::table('post_likes')->select(DB::raw('count(*) as total_likes'))->where('comment_id',$value->id)->first();
          if(is_null($commentLike)){
            $commentLike->total_likes=0 ;
          }
          ///$value->createdOn="2023-02-03 17:10:52";
          $date = Carbon::parse($value->createdOn); // now date is a carbon instance
          $elapsed = $date->diffForHumans(Carbon::now());
          $elapsed=createdAt($elapsed) ;

          $value->createdOn=$elapsed ;
          $value->total_likes=isset($commentLike->total_likes)?$commentLike->total_likes:0;
          $response_post[]=$value ;
        }
     }


     
     $post->comment = [];
     if(!empty($response_post)){
        $post->comment = $response_post ;
     }

     $postShare = DB::table('post_share')->select(DB::raw('count(*) as total_share'))->where('status',1)->where('post_id',$postId)->first();

     if(!is_null($postShare)){
      $post->total_share = $postShare->total_share ;
     }else{
      $post->total_share = 0 ;
     }

     $post_comment = DB::table('post_comments')->select(DB::raw('count(*) as total_comment'))->where('status',1)->where('postId',$postId)->first();
     
     if(!is_null($post_comment)){
      $post->total_comment = $post_comment->total_comment ;
     }else{
      $post->total_comment = 0 ;
     }

     if(!is_null($postLikes)){
      $post->like= $postLikes->total_Like ;
     }else{
      $post->like=0 ;
     }

     return $this->successResponse($post,'Post Detail',200);   

   }

   public function sponser_list(Request $request){
    
    $userId = authguard()->id ;
    $imagePath = config('constants.sponser_image');    
     //$list=DB::select('CALL GetAllSponsers("'.$imagePath.'")');
     $sponserList=DB::table('sponser')->select('id','name',DB::raw('concat("'.$imagePath.'",image) as image'),'description')->where('status',1)->whereIn('createdBy',array('0',$userId))->get();
     return $this->successResponse($sponserList,'Sponser list',200);   
   }

   public function file_list(Request $request){
    $validatedData = Validator::make($request->all(),["fileType"=>'required']); 

     if($validatedData->fails()){       
      return $this->errorResponse($validatedData->errors()->first(), 401);
     }
     $userId = authguard()->id ;
       $postImgPath = config('constants.post_image');
       //1>> image,2>>video,3>>audio
       if($request->fileType==1){
          $imageFile = DB::table('post_images')->select('id',DB::raw('concat("'.$postImgPath.'",postId,"/",image) as image'))->where('user_id',$userId)->where('file_type',1)->get();
          
       }else if($request->fileType==2){
          $imageFile = DB::table('post_images')->select('id',DB::raw('concat("'.$postImgPath.'",postId,"/",image) as image'))->where('user_id',$userId)->where('file_type',2)->get();
          
       }else if($request->fileType==3){
          $imageFile = DB::table('post_images')->select('id',DB::raw('concat("'.$postImgPath.'",postId,"/",image) as image'))->where('user_id',$userId)->where('file_type',3)->get();
          
       }else {
           $imageFile = array() ;
       }
       return $this->successResponse($imageFile,'File list',200);   
       //$videoList=Post_image::where('user_id',$userId)->where('file_type',1);
   }

   
   public function save_contactus(Request $request){
      $validatedData = Validator::make($request->all(),
        [
        "name"=>'required',       
        "phoneNumber"=>'required',
        "email"=>'required',
        "subject"=>'required',
        "message"=>'required'
      ]); 
 
     if($validatedData->fails()){       
      return $this->errorResponse($validatedData->errors()->first(), 401);
     }

     $insertData = array(
      "name"=>$request->name,       
      "phone_number"=>$request->phoneNumber,
      "email"=>$request->email,
      "subject"=>$request->subject,
      "message"=>$request->message
     );
     
     $last_id = DB::table('contactus')->insertGetId($insertData);
     
    

     if($request->hasfile('image')){

     $insert=[];
    $allowedfileExtension=['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','flv','mp4','m3u8','ts','3gp','mov','avi','wmv','mp3'];

    $files = $request->file('image'); 
    $errors = [];

      foreach($files as $file)
      {
       
        $fileType=0 ;

      $mimeType=$file->getMimeType() ;
        
       
        
         $filenamewithextension = $file->getClientOriginalName(); 
         $extension = $file->getClientOriginalExtension();  
       
         $check = in_array($extension,$allowedfileExtension);
         //$fileType = $this->checkFileType($filenamewithextension);
         
           if($check){
         
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
              $filename=str_replace(' ', '_', $filename);
              $filenametostore = $filename.'_'.time().'.'.$extension;       
              $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
             
              
              $file->storeAs('public/contactus_image/', $filenametostore);

              $insert[]=array(
                    'contact_id'=>$last_id,
                    'image'=>$filenametostore                   
                   );

                   $file_path[]= url('/').'/public/storage/contactus_image/'.$filenametostore;
              
           }
          }

           if(!empty($insert)){     
            DB::table('contactus_files')->insert($insert) ;
           }

            }  
     return $this->successResponse([],'Successfull Save Data',200);   
   }

   public function save_advertisement(Request $request){
       
    
    $validatedData = Validator::make($request->all(),
        [
        "sponserId"=>'required',   
        "adv_title"=>'required',
        "start_date"=>'required',
        "adv_image"=>'required',
        "end_date"=>'required',
        "description"=>'required'
      ]); 

   
        if($validatedData->fails()){       
          return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        if($request->sponserId==0){
          $validatedData = Validator::make($request->all(),[ 
            "sponser_title"=>'required|unique:sponser,name',
            "sponser_icon"=>'required'
          ]); 
        }

        if($validatedData->fails()){       
          return $this->errorResponse($validatedData->errors()->first(), 401);
        }

        $userId=authguard()->id;
        if($request->sponserId==0){
          $sponserIcon=$this->uploadImage('sponser_icon','sponser_image',$request);         
          $sp_img=isset($sponserIcon['fileName'])?$sponserIcon['fileName']:'' ;
          $insertSponser=array(
            "name"=>$request->sponser_title,
            "image"=>$sp_img,
            'createdBy'=>$userId
          );
          $sponserId=DB::table('sponser')->insertGetId($insertSponser);
          $sponserId = $sponserId ;
        }else{
          $sponserId = $request->sponserId ;
        }

        $advData=array(
          'sponser_id'=>$sponserId ,
          'title'=>$request->adv_title ,         
          'start_date'=>$request->start_date ,
          'end_date'=>$request->end_date ,
          'introduction'=>$request->description,
          'createdBy'=>$userId
        );
               
        // Start
            $advImage=$this->uploadImage('adv_image','sponser_image',$request);            
            $advData['ad_type']=isset($sponserIcon['fileType'])?$sponserIcon['fileType']:'' ;
            $advData['image']=isset($advImage['fileName'])?$advImage['fileName']:'' ;
        // End
        DB::table('advertisements')->insert($advData);
        return $this->successResponse([],'Successfully Submited your advertisement request',200);   
   }

   public function uploadImage($image_key,$path,$request){
   //print_r($request->$image_key); exit ;
    if($request->hasfile($image_key)){
     $imgPath='app/public/'.$path.'/' ;  
     $allowedfileExtension=['jpg', 'jpeg', 'gif', 'png', 'bmp', 'svg', 'svgz', 'cgm', 'djv', 'djvu', 'ico', 'ief','jpe', 'pbm', 'pgm', 'pnm', 'ppm', 'ras', 'rgb', 'tif', 'tiff', 'wbmp', 'xbm', 'xpm', 'xwd','flv','mp4','m3u8','ts','3gp','mov','avi','wmv','mp3'];
 
     $files = $request->file($image_key); 
     $fileType=0 ;    
     $mimeType=$files->getMimeType() ; 
     $filenamewithextension = $files->getClientOriginalName(); 
     $extension = $files->getClientOriginalExtension();  
        
          $check = in_array($extension,$allowedfileExtension);
          $fileType = $this->checkFileType($filenamewithextension);
          
            if($check){
          
             $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
             $filename=str_replace(' ', '_', $filename);
             $filenametostore = $filename.'_'.time().'.'.$extension;       
             $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
              
               
               $files->storeAs('public/'.$path.'/', $filenametostore);
               $file_path= url('/').'/public/storage/'.$path.'/'.$filenametostore;              
              return $response=array('fileType'=>$fileType,"fileName"=>$filenametostore);
            }else{
              return array(); 
            }
          }else{
            return array(); 
          }
   }

}
