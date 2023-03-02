<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Post;
use App\Models\Post_comment;
use App\Models\Post_image;
use App\Models\Post_like;
use App\Models\User_interest;
use App\Models\Advertisement;
use App\Models\Notifications ;
use App\Models\Cms ;
use Hash;
use DB ;
use Image ;
use File ;


class UserController extends Controller
{
     public function testData(){
      test();
        echo "Hello Walkofweb" ;

    }

     public function register(Request $request){
     	  
        //deviceType 1 android 2 ios
         try
        {        	
            
            $rules=[            
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'phoneNumber' => 'required|numeric|unique:users',
            'password' => 'required|confirmed',
            'countryId' => 'required',
            'deviceType' => 'required|numeric'            
           ] ;

            $validatedData = Validator::make($request->all(),$rules);
      
 
        if($validatedData->fails()){       
            return $this->errorResponse($validatedData->errors()->first(), 401);
          }

          $name=$request->name ;
          $usrName = substr($name,0,2);
                
          // new

          $country_code = DB::table('pe_countries')->select('api_code')->where('i_id', $request->countryId)->first();
          $request['country_code'] = (!empty($country_code))?$country_code->api_code:'' ;
          $request['name'] = $request->name;
          $request['registration_from'] = $request->deviceType ;
          $request['rank_type'] = rand(1,5);
          $request['rank_'] = rand(1,30);
          $request['username'] ='' ; //$userName;
    			$request['password']=Hash::make($request['password']);
    			$request['remember_token'] = Str::random(10);
    			$user = User::create($request->toArray());

    			$token = $user->createToken('walkofweb token')->accessToken;
          $message = "Successfull signup" ;
          $insertId=$user->id;
          $encryptionKey = md5('wow_intigate_23'.$insertId);
          $userName = $this->UsernameGenerate($usrName,$insertId);   
          DB::table('users')->where('id',$insertId)->update(['encryption'=>$encryptionKey,'username'=>$userName]);
          $imagick=config('constants.imagick');
          if($imagick==1){
             $this->qrCode($insertId);
          }
			   
          $data['token'] = $token  ;
          return $this->successResponse($data,$message,200);    

        }
        catch(\Exception $e)
        {
           return $this->errorResponse('This user is already exist.'.$e, 422);
        }


    }

    public function UsernameGenerate($usrName,$id){
      $number = mt_rand(10000,99999);
      $username = "WOW".strtoupper($usrName).$id ;
      if($this->UsernameExist($username)){
        return $this->UsernameGenerate($usrName);
      }
      return $username ; 
    }

    public function UsernameExist($usrName){
      return User::where(['username'=>$usrName])->exists();
    }



    public function doLogin(Request $request){

        $validator = Validator::make($request->all(), [
        'email' => 'required',
        'password' => 'required',
        ]);

        if($validator->fails())
        {
        return response(['errors'=>$validator->errors()->all()], 422);
        }

         if(is_numeric($request->get('email'))){
           $param = ['phoneNumber'=>$request->get('email'),'isTrash'=>0];
          }
          else if(filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $param = ["email"=>$request->get('email'),'isTrash'=>0] ;
          }else{
             $param = ["email"=>$request->get('email'),'isTrash'=>0] ;
          }

      
        $user = User::where($param)->where('user_type', '!=' , 1)->first();

         if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('walkofweb token')->accessToken;    
                $data['id'] = $user->id  ;           
                $data['token'] = $token  ;
                $message = "Successfull login" ;
                return $this->successResponse($data,$message,200);
               
            } else {
                $message = "Password mismatch" ;
                return $this->errorResponse($message,401);               
            }
        } else {
            $message = "User does not exist" ;
            return $this->errorResponse($message,401);              
        }
       
    }

    public function updateSocialInfo(Request $request){

    	try{

       $validator = Validator::make($request->all(), [        
        'insta_username' => 'required|string',
        'fb_username' => 'required|string',
        'tiktok_username' => 'required|string'
        ]);

        if($validator->fails())
        {
        return response(['errors'=>$validator->errors()->all()], 422);
        }
           
          $userId = authguard()->id ;
          User::where('id', $userId)->update(['instagram_username'=>$request->insta_username,'facebook_username'=>$request->fb_username,'tiktok_username'=>$request->tiktok_username]);
          $message='Successfull updated';
          return $this->successResponse([],$message,200);   

    	} catch(\Exception $e) {
           return $this->errorResponse('Something went wrong'.$e, 422);
        }    	

    }

    public function user_interest(Request $request){
      $data=User_interest::all()->toArray();
      return $this->successResponse($data,"User interest list",200);
    }

    public function logout(Request $request) {
      $id=Auth::guard('api')->user()->id;      
      DB::table('oauth_access_tokens')
            ->where('user_id',$id)
            ->update(['revoked' =>1]);
      return $this->successResponse([],"Successfull logout user",200);   
   }

   public function save_sponser(Request $request){       

         $rules=[
            'title' => 'required|string',
            'image' => 'required',
            'description'=> 'required'         
           ] ;

       try{

      if($request->hasFile('image')) {
        
       
       $imgPath='app/public/sponser_img/' ;
       
     
        $filenamewithextension = $request->file('image')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('image')->getClientOriginalExtension();
  
        $filename=str_replace(' ', '_', $filename);
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
        //Upload File
        $request->file('image')->storeAs('public/sponser_img', $filenametostore);
        $request->file('image')->storeAs('public/sponser_img/thumb', $smallthumbnail);
       
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/sponser_img/thumb/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
           
           $insert=array(
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$filenametostore
           );
        
        DB::table('sponser')->insert($insert);

        $file_path = url('/').'/public/storage/sponser_img/'.$filenametostore;
        return $this->successResponse($file_path,'successfull save data',200);

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

    public function advertisement_listing(Request $request){
      $data=Advertisement::all()->where('status',1) ;
      return $this->successResponse($data,'Sponser list',200);
    }

    public function notificationsList(Request $request){
        $data=Notifications::all();
        return $this->successResponse($data,'Notifications list',200);
    }

    public function udpateNotifications(Request $request){

     
       $validator = Validator::make($request->all(), [        
        'notificationId' => 'required|numeric',
        'isAccept' => 'required|numeric'        
        ]);

        if($validator->fails())
        {
        return response(['errors'=>$validator->errors()->all()], 422);
        }

        Notifications::where('id',$request->notificationId)->update(['isAccept'=>$request->isAccept]);
        return $this->successResponse([],'Successfull update',200);
    }

    public function deActivateUserAccount(Request $request){
      $userId=authguard()->id;
      User::where('id',$userId)->update(['isTrash'=>1]);
      return $this->successResponse([],'Successfull deactivate account',200);
    }

    public function updateUserProfile(Request $request){

      $userId=authguard()->id ;

      $validator = Validator::make($request->all(), [        
          'type' => 'required'
          ]);

      if($validator->fails())
        {
        return response(['errors'=>$validator->errors()->all()], 422);
        }

      $type=$request->type ;

      if($type==1){
         $validator = Validator::make($request->all(), [        
          'name' => 'required'
          ]);
      }else if($type==2){
         $validator = Validator::make($request->all(), [        
          'countryId' => 'required|numeric'
          ]);
      }else if($type==3){
         $validator = Validator::make($request->all(), [        
          'phoneNumber' => 'required|numeric'
          ]);
      }else if($type==4){
        $validator = Validator::make($request->all(), [        
          'email' => 'required|email|unique:users'
          ]);
      }else if($type==5){
         $validator = Validator::make($request->all(), [        
          'name' => 'required',
          'bio' => 'required' ,
          'location' => 'required',
          'dob' => 'required|date_format:Y-m-d'
          ]);
      }





      if($validator->fails())
        {
        return response(['errors'=>$validator->errors()->first()], 422);
        }

      if($type==1){
         User::where('id',$userId)->update(['name'=>$request->name]);
      }else if($type==2){
         User::where('id',$userId)->update(['countryId'=>$request->countryId]);
      }else if($type==3){
         User::where('id',$userId)->update(['phoneNumber'=>$request->phoneNumber]);
      }else if($type==4){
        User::where('id',$userId)->update(['email'=>$request->email]);
      }else if($type==5){
        User::where('id',$userId)->update(['name'=>$request->name ,'bio'=>$request->bio ,'location'=>$request->location ,'dob'=>$request->dob ]);
      }
        
       return $this->successResponse([],'Successfull updated user account',200);

    }

    public function updateProfileImage(Request $request){

         $rules=[            
            'image' => 'required'            
           ] ;

       try{

      if($request->hasFile('image')) {
        
       
        $imgPath='app/public/profile_image/' ;
       
     
        $filenamewithextension = $request->file('image')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('image')->getClientOriginalExtension();
  
        $filename=str_replace(' ', '_', $filename);
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
        //Upload File
        $request->file('image')->storeAs('public/profile_image', $filenametostore);
        $request->file('image')->storeAs('public/profile_image/thumb', $smallthumbnail);
       
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/profile_image/thumb/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
        $userId = authguard()->id ;
           $update=array(           
            'image'=>$filenametostore
           );
        User::where('id',$userId)->update($update);

        $file_path = url('/').'/public/storage/profile_image/'.$filenametostore;
        return $this->successResponse(['image_url'=>$file_path],'successfull update user profile image',200);

        }else{
            return $this->errorResponse('Invalid request.', 422);
        }

      }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
    

    }

    public function termCondition(Request $request){
          $termCondition = Cms::where('slug','term_condition')->first() ;
          
          return $this->successResponse(['termCondition'=>$termCondition->description],'term condition',200);
    } 

    public function privacyPolicy(Request $request){
       $termCondition = Cms::where('slug','privacy_policy')->first() ;
        return $this->successResponse(['privacyPolicy'=>$termCondition->description],'privacy policy',200);
    }

    public function changePassword(Request $request){
       $rules=[
        "currentPassword"=>"required",
        "password"=>"required|confirmed"
       ];

      $validator=Validator::make($request->all(),$rules);
      
      if($validator->fails())
      {
         return response(['errors'=>$validator->errors()->first()], 422);
      }
      
      $user=authguard();

       if(Hash::check($request->currentPassword, $user->password)) {
        User::where('id',$user->id)->update(['password'=>$request->password]);
        return $this->successResponse([],'Successfull changed your password',200);
       }else{
        return $this->errorResponse('Your current password is Invalid.', 422);
       }


    }

     public function forgotPassword(Request $request)
    {       
            $validator=Validator::make($request->all(),['email'=>'required|email']);

            if($validator->fails())
            {
            return response(['errors'=>$validator->errors()->first()], 422);
            }

            $otp = "123456" ; //str_random(60) ;
            /* user update password */
            $password ="123456" ;
          $user = User::where('email', $request->email)->first();
          if(!$user){
               return $this->errorResponse('User does not exist', 401);
          }

          // $user->password = \Hash::make($password);
          // $user->update();


            /* end update password */
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $otp,
                'created_at' => Carbon::now()
            ]); 

            $this->sendPwdEmail($request->email,$password,3);
         
            $message='Your otp has been sent to your email.' ;
            return $this->successResponse([],$message,200);

    }




    public function sendPwdEmail($email,$otp=123456,$type=0){

        if($type==1){
            $subject='Account Registration' ;
        }else if($type==2){
            $subject='Account Login' ;
        }else {
            $subject='Forgot Password' ;
        }
       $data=array(
        'email' => $email,
        'subject' => $subject,
        'message' => $otp
       );
        
        $data=sendPasswordToEmail($data);
    }

    public function verifyOTP(Request $request){

        $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'otp' => 'required'
        ]);

        if($validator->fails()){       
          return $this->errorResponse($validator->errors()->first(), 401);
        }else{
         $checkOTP = DB::table('password_resets')->where(array('token'=>$request->otp,'email'=>$request->email))->first();
         if(empty($checkOTP)){
           return $this->errorResponse('Invalid OTP', 401);
         }else{
            return $this->successResponse([],'OTP matched successfully.',200);

         }

        }

    }    


public function resetPassword(Request $request){

        $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
        'password' => 'required', 
        'confirm_password' => 'required|same:password',
        'otp' => 'required' 
       ]);

    //check if payload is valid before moving on
    if($validator->fails()){       
        return $this->errorResponse($validator->errors()->first(), 401);
    }else{

         $password = $request->password;
         $tokenData = DB::table('password_resets')->where(array('token'=>$request->otp,'email'=>$request->email))->first();

         if(empty($tokenData)){
           return $this->errorResponse('Invalid OTP', 401);
         }

        $user = User::where('email', $tokenData->email)->first();
        if(!$user){
             return $this->errorResponse('Email not found', 401);
        }

        $user->password = \Hash::make($password);
        $user->update();

        return $this->successResponse([],'Password change successfully',200);
    
    }
    
    }

    public function user_list(Request $request){

      //filter
      //social presence 2-facebook,3-instagram,4-tiktok,5-walkofweb

       $validator = Validator::make($request->all(), [
        'countryId' => 'array',
        'interest' => 'array', 
        'to_rank' => 'numeric',
        'from_rank' => 'numeric' ,
        'to_followers' => 'numeric',
        'from_follwers' => 'numeric' ,
        'social_presence' => 'array',
        'quick_filter'=>'array'
       ]);

    //quick_filter":[{"type":1,"id":5}]
    if($validator->fails()){       
        return $this->errorResponse($validator->errors()->first(), 401);
    }
      $searchKey=$request->input('search_keyword') ;
      $searchKeyword='';
      if($searchKey!=''){
        $searchKeyword=" and name like '%".$searchKey."%'" ;
      }

      $userId = authguard()->id ;
      $country=$request->countryId ;
      $interest=$request->interest ;
      $to_rank=$request->to_rank ;
      $from_rank=$request->from_rank ;
      $to_followers=$request->to_followers ;
      $from_follwers=$request->from_follwers ;
      $social_presence=$request->social_presence ;

      $filePath = config('constants.user_image') ;
      $advPath = config('constants.advertisement_image') ;
      $sPath = config('constants.sponser_image') ;

     $user_interest=array() ;
     $usr = array();
     $socialInfo = array() ;
     $filter="";
     $follower_filter="" ;

      if(!empty($interest)){
        $user_interest = DB::table("user_interests_map")->select(DB::raw("GROUP_CONCAT(user_id) as userId"))->whereIn('interest_id',$interest)->get()->toArray();
      }
      
      if(!empty($user_interest) and isset($user_interest[0]->userId) and $user_interest[0]->userId > 0){
        $usr=explode(',', $user_interest[0]->userId); 
        $filter=" and id in (".$user_interest[0]->userId.")" ;
      }

      if(!empty($country)){
        $filter=$filter." and countryId in (".implode(',',$country).")";
      }

      if($to_rank!=0 and $from_rank!=0){
        $filter=$filter." and rank_ between ".$to_rank." and ".$from_rank ;
      }else if($to_rank!=0){
        $filter=$filter." and rank_ >=".$to_rank ;
      }else if($from_rank!=0){
        $filter=$filter." and rank_ <=".$from_rank ;
      }
      
      if($to_followers!=0 and $from_follwers!=0){
        $follower_filter=" and total_followersCount between ".$to_followers." and ".$from_follwers ;
      }

      if(!empty($social_presence)){      
        $socialInfo = DB::select("select * from (select GROUP_CONCAT(distinct user_id) as userId,sum(follows_count) as total_followsCount,sum(followers_count) as total_followersCount,status from social_info where status=1 and social_type in (".implode(',',$social_presence).")) as followers where status=1 ".$follower_filter);
      }

      if(empty($social_presence) and $to_followers!=0 and $from_follwers!=0){
        $socialInfo = DB::select("select * from (select GROUP_CONCAT(distinct user_id) as userId,sum(follows_count) as total_followsCount,sum(followers_count) as total_followersCount,status from social_info where status=1) as followers where status=1  ".$follower_filter);
      }

      if(!empty($socialInfo) && isset($socialInfo[0]->userId) && $socialInfo[0]->userId > 0){
        $filter=$filter." and id in (".$socialInfo[0]->userId.")";
        
      }
            
      $countryCode = DB::raw('case when country_code is null then "" else country_code end as country_code');
      $list=DB::select("select id,name,rank_,rank_type,case when image is null then '' else concat('".$filePath."',image) end as image,countryId,$countryCode from users where id!=".$userId." and isTrash=0 and user_type!=1 and isFeatured=0".$filter.$searchKeyword);

      $image = DB::raw('case when concat("'.$filePath.'",image) is null then "" else concat("'.$filePath.'",image) end as image') ;
      $featureUser = DB::table('users')->select('id','name','rank_','rank_type',$image)->Where('isFeatured',1)->where('isTrash',0)->get() ;
     
      $totalFeatureUser=count($featureUser);
      $totalLoginUsrFollowers = User::getFollowersCount($userId);
      $loginUsrRank = User::getUserRank($userId);
      //$fUser = (object)array() ;
       
      // if(!empty($featureUser->toArray())){    
        
      //   $totalFeatureUser = count($featureUser); 
      //   $featureUserId = isset($featureUser[0]->id)?$featureUser[0]->id:0 ;
      //   $fUsr_ = DB::select("select case when s.image is null then '' else concat('".$sPath."',s.image) end as s_image from sponser as s inner join user_sponsers as us on us.sponser_id=s.id where us.user_id=".$featureUserId);
      //   $fUser=$featureUser[0] ;
      //   $fUser->sponser = $fUsr_ ;        
      // }

      $data['featured_user']=array('total_followers'=>$totalLoginUsrFollowers,'rank_'=>$loginUsrRank) ;
      $data['total_feature']=$totalFeatureUser ;
      $advertisement=User::advertisement();
      $rankType = array() ;
      $data['list']=[];
      if(!empty($list)){
          foreach($list as $key => $val) {
           $rankType[$val->rank_type][] = $val ;            
          }
      }
      
      $star_imgPath=config('constants.star_image') ;
      if(!empty($rankType)){

        foreach ($rankType as $key => $value) {
          if($key!=0){

          $rankInfo = DB::table('rank_types')->select('id','rank_title',DB::raw('concat("'.$star_imgPath.'",star_img) as starImg'))->where('id',$key)->first();
         // $value->starImg = 'rankInfostarImg ';
          $value[0]->star_img = $rankInfo->starImg;
          $rankInfo->user_list =  $value ; 
          $data['list'][]= $rankInfo;
        }
          
          
        }
      }

      $data['advertisement']=$advertisement ;     
      //quic filter table
      // rank_types
      // pe_countries
      // user_interests
      // social_media    
      // $quickFilter=DB::select('select id, rank_title as title, "1" as type from rank_types where quick_filter=1 and status=1 union select i_id as id, v_title as title,"2" as type from pe_countries where quick_filter=1 and i_status=1 union select id as id, title as title,"3" as type from social_media where quick_filter=1 and status=1 union select id as id, title as title,"4" as type from user_interests where quick_filter=1 and status=1 ') ;
      // $data['quickFilter']=$quickFilter ;
      return $this->successResponse($data,'User List',200);
      // DB::enableQueryLog();
      //        $query = DB::getQueryLog();
      // print_r($query);
    }

    public function user_filter(Request $request){

      $countries = countryList(); //DB::table('pe_countries')->select('i_id','v_title')->where('i_status',1)->get();
      $interest = DB::table('user_interests')->select('id','title')->where('status',1)->get();
      $rank=DB::table('users')->select(DB::raw('min(rank_) as minRank, max(rank_) as maxRank'))->where('isTrash',0)->first();
      $minRank = $rank->minRank ;
      $maxRank = $rank->maxRank ;
      $followers = DB::select("select min(totalFollowers) as minFollowers, max(totalFollowers) as maxFollowers from (select sum(followers_count) as totalFollows, sum(followers_count) as totalFollowers from `social_info` where `status` = 1 group by `user_id`) as follows"); 

      $minFollowers = (!empty($followers))?$followers[0]->minFollowers:0 ;
      $maxFollowers =(!empty($followers))?$followers[0]->maxFollowers:0;
      $socialPresence = DB::table('social_media')->select('id','title')->where('status',1)->get() ;
      $data['countries']=$countries ;
      $data['interest']=$interest ;
      $data['rank']=array("minRank"=>$minRank,"maxRank"=>$maxRank) ;
      $data['followers']=array("minFollowers"=>$minRank,"maxFollowers"=>$maxRank) ;
      return $this->successResponse($data,'User List',200);
    }

    public function user_detail(Request $request){
       
       $userId = $request->userId ; //authguard()->id ;
       if($userId==0){
        $userId =authguard()->id ;
       }
       $checkUser = DB::table('users')->where('id',$userId)->get()->toArray();
      
       if(empty($checkUser)){
         return $this->errorResponse('This user id is not exist', 401);
       }

      
      $instaUrsername=DB::raw('case when instagram_username is null then "" else instagram_username end as instagram_username');
      $fbUrsername=DB::raw('case when facebook_username is null then "" else facebook_username end as facebook_username');
     
      $tiktokUrsername=DB::raw('case when tiktok_username is null then "" else tiktok_username end as tiktok_username');
      $bio=DB::raw('case when bio is null then "" else bio end as bio');

      $filePath = config('constants.user_image') ;
      $image = DB::raw('case when concat(image) is null then "" else concat("'.$filePath.'",image) end as image') ;

      $profilePath = config('constants.profile_video') ;
      $profileVideo = DB::raw('case when concat(profile_video) is null then "" else concat("'.$profilePath.'",profile_video) end as profile_video') ;
      
      $starImg = config('constants.star_image');
      $coverImg = config('constants.cover_image');
      $cover_image = DB::raw('case when concat(cover_image) is null then "" else concat("'.$coverImg.'",cover_image) end as cover_image') ;
     //DB::enableQueryLog();
      $userInfo = DB::table('users')->select('users.id','name',$image,$cover_image,'username',$instaUrsername,$fbUrsername,$tiktokUrsername,'rank_type','rank_',$bio,'rt.rank_title',DB::raw('concat("'.$starImg.'",rt.star_img) as starImg'),'pv_type',$profileVideo)
        ->join('rank_types as rt','rt.id','=','users.rank_type')
        ->where('users.id',$userId)->where('users.isTrash',0)->first();
        return $this->successResponse($userInfo,'User List',200);
       //print_r(DB::getQueryLog());
      $totalFollowers = userfollowers($userId);
      // print_r($totalFollowers);
      // exit ;
      if(!empty($totalFollowers) && !empty($totalFollowers[0]) && $totalFollowers[0]->totalFollowers!=''){
        $userInfo->followers = (!empty($totalFollowers))?(int)$totalFollowers[0]->totalFollowers:0 ;
      }else{
        $userInfo->followers = 0 ;
      }
     
      
      $about = DB::select("select ui.id,ui.title from user_interests_map as uim inner join user_interests as ui on ui.id=uim.interest_id where uim.user_id=".$userId);
      $userInfo->about['interest'] = $about ;
      $userInfo->increase_rank = 36 ;
      $userAdvertisement = User::advertisement();
      $userInfo->advertisement = $userAdvertisement ;

      
      $totalFollows = DB::table('social_info')->select(DB::raw('sum(follows_count) as totalFollowscount'))->where('user_id',$userId)->first();
      $userInfo->totalFollows = isset($totalFollows->totalFollowscount)?$totalFollows->totalFollowscount:0 ;
      $totalPost = DB::table('posts')->select(DB::raw('count(*) as totalPost'))->where('userId',$userId)->where('status',1)->first() ;
      $totalLike = DB::table('post_likes')->select(DB::raw('count(*) as totalLikes'))->where('status',1)->where('isLike',1)->first() ;
      $totalComment = DB::table('post_comments')->select(DB::raw('count(*) as totalComments'))->where('status',1)->where('userId',$userId)->first() ;
      
      $userInfo->totalComment = isset($totalComment->totalComments)?$totalComment->totalComments:0 ;
      $userInfo->totalPosts = isset($totalPost->totalPost)?$totalPost->totalPost:0 ;
      $userInfo->totlaLikes = isset($totalLike->totalLikes)?$totalLike->totalLikes:0 ;
      $userFollowers = User::getFollowers($userId);
      $userInfo->star_value = $userFollowers ;
      
      $star_imgPath=config('constants.star_image') ;
      $filePath = config('constants.user_image') ;
      $image_ = DB::raw('case when concat("'.$filePath.'",users.image) is null then "" else concat("'.$filePath.'",users.image) end as image') ;
      $strImg=DB::raw('concat("'.$star_imgPath.'",star_img) as starImg');
     
      $postList=Post::select('posts.id','posts.message','users.name',DB::raw('concat("@",username) as username'),'users.rank_type',$image_,$strImg,'posts.createdOn')->join('users','users.id','=','posts.userId')->join('rank_types','rank_types.id','=','users.rank_type')
      ->where('posts.status',1)->where('userId',$userId)->where('users.isTrash',0)->get() ;

    
      $post_list = array();      
      //$post_image = array() ;
       $postLike = new Post_like();
       $postImage = new Post_image();

      if(!empty($postList)){
         foreach ($postList as $key => $value) {
            $postId = $value->id ;
            $postImgPath = config('constants.post_image').$postId.'/';           
            $post_image = $postImage->getPostImage($postId);
            $value->postImage = $post_image ;
            $totalComment = Post_comment::all()->where('postId',$postId)->count();
            $value->totalComment = $totalComment ; 
            $value->totalLike = $postLike->getTotalLike($postId);  
            $date = Carbon::parse($value->createdOn); // now date is a carbon instance
            $elapsed = $date->diffForHumans(Carbon::now());
            $elapsed=createdAt($elapsed) ;

            $value->createdOn =$elapsed ;
            $post_list[]=$value ;
            //$post_image[]=$postImage ;
         }
      }

      //People Host start
      $hostPeople = DB::select("select u.name,u.id,$image,case when u.image is null then '' else u.image end as images,u.username,u.rank_,u.rank_type, case when u.country_code is null then '' else u.country_code end as country_code,u.countryId from users as u inner join user_host as uh on uh.host_user_id=u.id where u.isTrash=0");
      $userInfo->host_people = $hostPeople ;

      // End
      $userInfo->post_list = $post_list ;      
      $userInfo->checkOutMyWalk = array('total_photos'=>1,'total_followers'=>2,'total_videos'=>5,'total_shares'=>9);
      $userInfo->connectWithMe = array('walkofweb_username'=>$userInfo->username,'insta_username'=>$userInfo->instagram_username,'facebook_username'=>$userInfo->facebook_username,'tiktok_username'=>$userInfo->tiktok_username);
      return $this->successResponse($userInfo,'User List',200);
     
    }

   
   public function following_request(Request $request){

      $validator = Validator::make($request->all(), [
      'following_userId' => 'required'
     ]);
    
      if($validator->fails()){       
          return $this->errorResponse($validator->errors()->first(), 401);
      }

      $userId = authguard()->id ;
      $checkFollowing=DB::table('user_follows')->where('followed_user_id',$userId)->where('follower_user_id',$request->following_userId)->first();

      $checkFollowing_=DB::table('user_follows')->where('followed_user_id',$request->following_userId)->where('follower_user_id',$userId)->first();

      if(!empty($checkFollowing) || !empty($checkFollowing_)){
        return $this->errorResponse('This user is already in following list.', 401);
      }

      DB::table('user_follows')->insert(["followed_user_id"=>$userId, "follower_user_id"=>$request->following_userId ,"isAccept"=>0]);

      return $this->successResponse([],'Successfull request has submited',200);

   }

   public function accept_following(Request $request){
      $validator = Validator::make($request->all(), [
      'following_userId' => 'required'
     ]);

    
      if($validator->fails()){       
          return $this->errorResponse($validator->errors()->first(), 401);
      }

      $userId = authguard()->id ;
      $checkFollowing=DB::table('user_follows')->where('followed_user_id',$request->following_userId)->where('follower_user_id',$userId)->update(['isAccept'=>1]);

      return $this->successResponse([],'Successfull accepted following request',200);
   }

   public function following_list(Request $request){

       $userId = authguard()->id ;
       $userImgPath = config('constants.user_image');
       $bio = DB::raw('case when bio is null then "" else bio end as bio');
       $image = DB::raw('case when image is null then "" else concat("'.$userImgPath.'",image) end as image');
       $followingList = DB::table('user_follows')->select('users.id','name','username',$bio,$image,'rank_type','rank_',DB::raw('case when isAccept=1 then 1 else 0 end as isFollowing'))->where('followed_user_id',$userId)      
       ->join('users', 'users.id', '=', 'user_follows.follower_user_id')     
       ->get();
       
        return $this->successResponse($followingList,'Following List',200);
      
   }

   public function follower_list(Request $request){

       $userId = authguard()->id ;
       $userImgPath = config('constants.user_image');
       $bio = DB::raw('case when bio is null then "" else bio end as bio');
       $image = DB::raw('case when image is null then "" else concat("'.$userImgPath.'",image) end as image');
       $followingList = DB::table('user_follows')->select('users.id','name','username',$bio,$image,'rank_type','rank_')->where('follower_user_id',$userId)      
       ->join('users', 'users.id', '=', 'user_follows.follower_user_id') 
       ->where('isAccept',1)    
       ->get();
       //,DB::raw('case when isAccept=1 then 1 else 0 end as isFollowing')
        return $this->successResponse($followingList,'Follower List',200);

   }

   public function following_request_list(Request $request){

       $userId = authguard()->id ;
       $userImgPath = config('constants.user_image');
       $bio = DB::raw('case when bio is null then "" else bio end as bio');
       $image = DB::raw('case when image is null then "" else concat("'.$userImgPath.'",image) end as image');
       $followingList = DB::table('user_follows')->select('users.id','name','username',$bio,$image,'rank_type','rank_','isAccept')->where('follower_user_id',$userId)      
       ->join('users', 'users.id', '=', 'user_follows.follower_user_id')
       ->where('isAccept',0)     
       ->get();
       
        return $this->successResponse($followingList,'Follower Request List',200);
   }

 
    public function check_rank_type(Request $request){
        
        $rank=$request->rank ;
        $rankType=0 ;

        //800 to 999 rank 1
        //600 to  799  rank 2
        //400 to 599 rank 3
        //200 to 399 rank 4
        // 1 to 199 rank 5

        if($rank > 800 && $rank < 1000){
          $rankType=1 ;
        }else if($rank > 600 && $rank < 800){
          $rankType=2 ;
        }else if($rank > 400 && $rank < 600){
          $rankType=3 ;
        }else if($rank > 200 && $rank < 400){
          $rankType=4 ;
        }else if($rank > 1 && $rank < 200){
          $rankType=5 ;
        }else{
          $rankType=0 ;
        }

        return $rankType ;
    }

     
 public function qrCode($userId){
      $png= \QrCode::format('png')->size(300)->generate('https://www.walkofweb.net/'.$userId);
      $fileName='qrcode_'.$userId.'.png' ;
      $output_file = '/user_qrcode/'.$fileName;
      \Storage::disk('public')->put($output_file, $png);  
      DB::table('users')->where('id',$userId)->update(['qr_code'=>$fileName]);    
 }

 public function user_qrCodeDetail(Request $request){

       $userId = authguard()->id ;
       $checkUsr=DB::table('users')->where('id',$userId)->first();
       if(empty($checkUsr)){
        return $this->errorResponse('This user id is not exist.', 401);
       }
       $userImgPath = config('constants.user_image');
       $userQrCode = config('constants.user_qrimage');
       $img=DB::raw('case when image is null then "" else concat("'.$userImgPath.'",image) end as image');
       $qrCode=DB::raw('case when qr_code is null then "" else concat("'.$userQrCode.'",qr_code) end as qr_code');
       $userInfo = DB::table('users')->select('id','name','username','rank_type',$img,'rank_',$qrCode)->where('id',$userId)->first();
       $followers =userfollowers($userId);
       if(!empty($followers) && isset($followers[0]->totalFollowers) && $followers[0]->totalFollowers > 0){
        $userInfo->totalFollowers=(int)$followers[0]->totalFollowers ;
      }else{
        $userInfo->totalFollowers=0 ;
      }
       
       return $this->successResponse($userInfo,'User Profile Detail',200);
 }


 public function user_follower_list(Request $request){

   $validator = Validator::make($request->all(), [
      'userId' => 'required'
     ]);

    
    if($validator->fails()){       
      return $this->errorResponse($validator->errors()->first(), 401);
    }

    $userId=$request->userId ;
    $loginUserId = authguard()->id ;
    $userImgPath = config('constants.user_image');

    $bio = DB::raw('case when bio is null then "" else bio end as bio');
    $image = DB::raw('case when image is null then "" else concat("'.$userImgPath.'",image) end as image');
    $country_code = DB::raw('case when country_code is null then "" else country_code end as country_code');
    $userFollowers=DB::select("select us.id as userId,case when (select followed_user_id from user_follows where follower_user_id=".$loginUserId." and isAccept=1) is null then 0 else 1 end as isAccepts, us.name,us.username,us.image,".$country_code.",".$bio.",".$image.",rank_type,rank_ from user_follows as uf inner join users as us on us.id=uf.followed_user_id where follower_user_id=".$userId);
    
    return $this->successResponse($userFollowers,'Follower List',200);
 }

 public function sponser_detail(Request $request){

   $validator = Validator::make($request->all(), [
      'sponserId' => 'required'
     ]);

    
    if($validator->fails()){       
      return $this->errorResponse($validator->errors()->first(), 401);
    }

    $sponserId = DB::table("advertisements")->select(DB::raw('advertisements.id as advertiserId'),'sponser.name','advertisements.title',DB::raw('concat(Date_Format(advertisements.start_date,"%d %M %Y")," to ",Date_Format(advertisements.end_date,"%d %M %Y")) as duration'),'advertisements.introduction','advertisements.objectives',
      'advertisements.target_audience','advertisements.media_mix','advertisements.conclusion','advertisements.media_sample')->where('sponser_id',$request->sponserId)
   ->join('sponser','sponser.id','=','advertisements.sponser_id')
    ->first();

    return $this->successResponse($sponserId,'Sponser Detail',200);
 }

 public function social_connect(Request $request){
    // $response = 
    //   social connect

    // >> Tiktok , login url
    // >> Facebook,login url
    // >> Instagram,login url
    $soicalInfo = DB::table('social_media')->select('id','title','login_url')->where('social_connect',1)->get();
    return $this->successResponse($soicalInfo,'Social Connect',200);
 }

 public function update_encryption(){
   $user=DB::table('users')->get();

   if(!empty($user)){
     foreach ($user as $key => $value) {
      //print_r($value);
       $encryptionKey = md5('wow_intigate_23'.$value->id);
        DB::table('users')->where('id',$value->id)->update(['encryption'=>$encryptionKey]);
     }
   }
 }

 public function add_user_host(Request $request){

      $validator = Validator::make($request->all(), [
      'hostUserId' => 'required'
     ]);

    
    if($validator->fails()){       
      return $this->errorResponse($validator->errors()->first(), 401);
    }

      $hostUserId = $request->hostUserId ;
      $userId = authguard()->id ;
      $checkUser = DB::table('user_host')->select('id')->where('userId',$userId)->where('host_user_id',$hostUserId)->first();
      if(empty($checkUser)){
        DB::table('user_host')->insert(['userId'=>$userId,'host_user_id'=>$hostUserId]);
        return $this->successResponse([],'Successfull added in host',200);
      }else{       
        return $this->successResponse([],'This user is already added in host',200);
      }
 }

 public function remove_user_host(Request $request){
    $validator = Validator::make($request->all(), [
      'hostUserId' => 'required'
     ]);

    
    if($validator->fails()){       
      return $this->errorResponse($validator->errors()->first(), 401);
    }

      $hostUserId = $request->hostUserId ;
      $userId = authguard()->id ;      
      DB::table('user_host')->where('userId',$userId)->where('host_user_id',$hostUserId)->delete();
      return $this->successResponse([],'Successfull delete host',200);
 }


 public function accept_request_host(Request $request){

      $validator = Validator::make($request->all(), [
      'requestUserId' => 'required'
     ]);

    
    if($validator->fails()){       
      return $this->errorResponse($validator->errors()->first(), 401);
    }

      $requestUserId = $request->requestUserId ;
      $userId = authguard()->id ;
      $checkUser = DB::table('user_host')->where('host_user_id',$userId)->where('userId',$requestUserId)->first();
      if(!empty($checkUser)){
         DB::table('user_host')->where('host_user_id',$userId)->where('userId',$requestUserId)->update(['isAccept'=>1]);
        return $this->successResponse([],'Successfull accepted as host',200);
      }else{       
        return $this->successResponse([],'Invalid Request',200);
      }
 }

 public function country_list(Request $request){
    $countries = countryList();
    return $this->successResponse($countries,'Successfull accepted as host',200);
 }

 public function update_profile_videoLink($url,$type){
        $userId = authguard()->id ;
        DB::table('users')->where('id',$userId)->update(['pv_type'=>1,'profile_video'=>$url]);
         return $this->successResponse([],'successfull update user profile video url',200);
 }


 public function profile_video(Request $request){


         $rules=[            
            'profile_video' => 'required',
            'type'=>'required'            
           ] ;

         if($request->type==1){
 
            if($request->hasFile('profile_video')){
                return $this->errorResponse('Invalid Request',401);
            }

           return $this->update_profile_videoLink($request->profile_video,$request->type); 
         } 

       try{

      if($request->hasFile('profile_video')) {

        
       
        $imgPath='app/public/profile_video/' ;
        $filenamewithextension = $request->file('profile_video')->getClientOriginalName();
    
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('profile_video')->getClientOriginalExtension();
  
        $filename=str_replace(' ', '_', $filename);
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
        //Upload File
        $request->file('profile_video')->storeAs('public/profile_video', $filenametostore);
        $request->file('profile_video')->storeAs('public/profile_video/thumb', $smallthumbnail);
       
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/profile_video/thumb/'.$smallthumbnail);
       // $this->createThumbnail($smallthumbnailpath, 100, 100);
        $userId = authguard()->id ;
       
         $pvPath = config('constants.profile_video');
          $checkPV = DB::table('users')->select(DB::raw('case when profile_video is null then "" else profile_video end as profile_video'))->where('id',$userId)->first();
          
          if(isset($checkPV->profile_video) && $checkPV->profile_video!=''){
              $unlinkPath = storage_path($imgPath.$checkPV->profile_video) ;
              do_upload_unlink(array($unlinkPath));
          }

           $update=array(           
            'profile_video'=>$filenametostore
           );
        User::where('id',$userId)->update($update);

      $file_path = url('/').'/public/storage/profile_video/'.$filenametostore;
        return $this->successResponse(['image_url'=>$file_path],'successfull update user profile video',200);

        
      }else{
            return $this->errorResponse('Invalid request.', 422);
        }

      }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
        
 }     


   public function host_user_list(Request $request){

       $userId = authguard()->id ;
       $userImgPath = config('constants.user_image');      
      
       $query1="select u.id as userId,u.name,u.username,case when bio is null then '' else bio end as bio,case when image is null then '' else concat('".$userImgPath."',image) end as image,rank_type,rank_,case when uf.isAccept=1 then 1 else 0 end as isFollowing,case when uh.isAccept is null then 2 else uh.isAccept end as isUserHost from user_follows as uf inner join users as u on u.id=uf.follower_user_id left join user_host as uh on uh.userId=u.id where u.isTrash=0 and uf.isAccept=0 and followed_user_id=".$userId;

       $query2="select u.id as userId,u.name,u.username,case when bio is null then '' else bio end as bio,case when image is null then '' else concat('".$userImgPath."',image) end as image,rank_type,rank_,case when uf.isAccept=1 then 1 else 0 end as isFollowing,case when uh.isAccept is null then 2 else uh.isAccept end as isUserHost from user_follows as uf inner join users as u on u.id=uf.follower_user_id left join user_host as uh on uh.userId=u.id where u.isTrash=0 and uf.isAccept=1 and follower_user_id=".$userId;

       $query=$query1.' union '.$query2;
        $userHostList = DB::select($query);
        return $this->successResponse($userHostList,'Follower List',200);

   }

   public function user_dashboard(Request $request){

     $userId=authguard()->id ;
     $followersInfo = DB::table('social_info')->select('type',DB::raw('sum(followers_count) as totalCount'))->groupBy('type')->where('user_id',$userId)->get();
     return $this->successResponse($followersInfo,'User Dashboard',200);
     
   }

   public function cover_image(Request $request){


         $rules=[            
            'coverImage' => 'required'            
           ] ;

       try{

      if($request->hasFile('coverImage')) {
        
       
        $imgPath='app/public/cover_image/' ;
       
     
        $filenamewithextension = $request->file('coverImage')->getClientOriginalName();
  
        //get filename without extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
  
        //get file extension
        $extension = $request->file('coverImage')->getClientOriginalExtension();
  
        $filename=str_replace(' ', '_', $filename);
        $filenametostore = $filename.'_'.time().'.'.$extension;       
        $smallthumbnail = $filename.'_100_100_'.time().'.'.$extension;    
       
        //Upload File
        $request->file('coverImage')->storeAs('public/cover_image', $filenametostore);
        $request->file('coverImage')->storeAs('public/cover_image/thumb', $smallthumbnail);
       
         
        //create small thumbnail
        $smallthumbnailpath = public_path('storage/cover_image/thumb/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 100, 100);
        $userId = authguard()->id ;
           $update=array(           
            'cover_image'=>$filenametostore
           );
        User::where('id',$userId)->update($update);

        $file_path = url('/').'/public/storage/cover_image/'.$filenametostore;
        return $this->successResponse(['image_url'=>$file_path],'successfull update user cover image',200);

        }else{
            return $this->errorResponse('Invalid request.', 422);
        }

      }catch(\Exception $e)
        {
           return $this->errorResponse('Error occurred.'.$e, 422);
        }
    

    
   }

}
