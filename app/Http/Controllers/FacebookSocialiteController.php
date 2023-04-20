<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Socialite;
use Auth;
use Exception;
//use App\Models\User;
use Instagram\FacebookLogin\FacebookLogin;
use Instagram\AccessToken\AccessToken;
use Instagram\User\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use DB ;
class FacebookSocialiteController extends Controller
{
    public function index(){
        return "hello";
    }

     public function redirectToFB()
    {   
       return Socialite::driver('facebook')->redirect();
    }

    public function handleCallback()
    {
        try {
     
            $user = Socialite::driver('facebook')->user();
      
            $finduser = User::where('social_id', $user->id)->first();
      
            if($finduser){
      
                Auth::login($finduser);
     
                return redirect('/');
      
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=>"facebook",
                    'password' => encrypt('my-facebook')
                ]);
     
                Auth::login($newUser);
      
                return redirect('/');
            }
     
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToInstagramProvider(){
     $appId=env('INSTA_APP_ID');     
     $redirectUri=urlencode(env('INSTA_REDIRECT_URI'));    

     return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media,instagram_basic,instagram_content_publish,instagram_manage_insights,instagram_manage_comments,pages_show_list,ads_management,business_management,pages_read_engagement&response_type=code");

     }

    public function instagramProviderCallback(Request $request){
        $code = $request->code ;
        $client_id=env('INSTA_APP_ID');
     
        $redirect_uri=env('INSTA_REDIRECT_URI') ;
        $client_secret=env('INSTA_CLIENT_SECRET') ;
       
       $ch=curl_init();
           curl_setopt($ch,CURLOPT_URL,env('INSTA_ACCESS_TOKEN_URI'));
           curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
           curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
           curl_setopt($ch,CURLOPT_POSTFIELDS,array(
           'code'=>$code,
           'client_id'=>$client_id,
           'client_secret'=>$client_secret,
           'redirect_uri'=>$redirect_uri,
           'grant_type'=>'authorization_code'
           ));

         $data = curl_exec($ch);         
         $accessToken = json_decode($data)->access_token;
         $userId = json_decode($data)->user_id;          
        $chs = curl_init();
          curl_setopt($chs,CURLOPT_URL,"https://graph.instagram.com/v15.0/{$userId}?fields=account_type,id,username,media{caption,id,comments_count,like_count}&access_token={$accessToken}");   
                
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);

        $response = curl_exec($chs);

        $oAuth = json_decode($response);
              echo "<pre>";
               print_r($oAuth); exit ;

        $username = $oAuth->username ;
        $user = ['email'=>$username,'token'=>$userId,'name'=>$username,'social_id'=> $userId,'social_type'=> 'instagram','password' => encrypt('my-facebook')];
        $user = (object)$user ;
        //$data = User::where('email',$user->email)->first();
        // if(is_null($data)){        
        // $users['name']=$user->name ;
        // $users['email']=$user->email ;      
        // $users['social_id']=$user->social_id ;  
        // $users['social_type']=$user->social_type ;
        // $users['password']=$user->password ;  
        // $data = User::create($users);
        // }
        Auth::login($data);
        return redirect('/');
}
    
     
     public function fb_error(){
         echo "Something went wrong" ;
      }


      public function fbSuccessResp(){
         echo "Facebook page and instagram bussiness account details successfully has been added" ;
      }

      public function fbProfileSuccessResp(){
        echo "Facebook profile details successfully has been added" ;
     }
      
     public function fbLogin(){
        $config = array( // instantiation config params
        'app_id' => '2972423753060577', // facebook app id
        'app_secret' => '6fa847c834a094543daa98dfc283e0bb', // facebook app secret
        );

        // uri facebook will send the user to after they login
        $redirectUri = 'https://dev.walkofweb.net/fbCallback';

        $permissions = array( 
            'instagram_basic',
            'pages_show_list',
            'pages_read_engagement'          
        );

        // 'instagram_content_publish', 
        //     'instagram_manage_insights', 
        //     'instagram_manage_comments',
        //     'pages_show_list', 
        //     'ads_management', 
        //     'business_management', 
        //     'pages_read_engagement'
        // instantiate new facebook login
        $facebookLogin = new FacebookLogin( $config );
        $fbLoginUrl=$facebookLogin->getLoginDialogUrl( $redirectUri, $permissions );

        //fb profile data
         $config_ = array( // instantiation config params
        'app_id' => '2510330525940547', // facebook app id
        'app_secret' => 'fe4ed5c133365c2ea11808dc81b6074b', // facebook app secret
        );


        $permissions_ = array(            
            'user_friends',
            'user_posts'           
        );

       

        // instantiate new facebook login
        $facebookLogin_ = new FacebookLogin($config_);
        $redirectUri_ = 'https://dev.walkofweb.net/fbBasicInfo';
        $fbLoginUrl_=$facebookLogin_->getLoginDialogUrl( $redirectUri_, $permissions_ );
       $instaLoginUrl ="https://dev.walkofweb.net/insta/login";
       $tiktokLoginUrl="https://www.walkofweb.net/auth";
      
       return view('fbLogin',["fbLoginUrl"=>$fbLoginUrl,"fbLoginUrl_"=>$fbLoginUrl_,"instaLoginUrl"=>$instaLoginUrl,"tiktokLoginUrl"=>$tiktokLoginUrl]);
     }

     
     public function fb_connect($userId){
      
       $config = array( 
        'app_id' => env('FB_BUSINESS_APP_ID'), 
        'app_secret' => env('FB_BUSINESS_APP_SECRET') 
        );       
      
        $redirectUri = env('FB_BUSINESS_REDIRECT_URI') ; 
        $permissions = array(
            'instagram_basic' ,
            'pages_show_list'  
        );
           
        $facebookLogin = new FacebookLogin($config);
        $fbLoginUrl=$facebookLogin->getLoginDialogUrl($redirectUri,$permissions); 
        return Redirect::to($fbLoginUrl."&state=".$userId);
        
     }

     public function checkUser($state){
           
            $checkUsr = DB::table('users')->select('id')->where('encryption',$state)->first();
            
            if(!empty($checkUsr)){
             return $userId=$checkUsr->id ;
            }else{
              $userId=0 ; 
              echo "Invalid Request" ; exit ;
            }
     }

      public function fbResponse(Request $request){
        
           $state=isset($request->state)?$request->state:'' ;
           $userId=$this->checkUser($state);

         $config = array( 
          'app_id' => env('FB_BUSINESS_APP_ID'), 
          'app_secret' => env('FB_BUSINESS_APP_SECRET') 
          );

            $code = $request->code ;          
         
            $redirectUri = env('FB_BUSINESS_REDIRECT_URI') ; 
          
            $accessToken = new AccessToken($config);

          
            $newToken = $accessToken->getAccessTokenFromCode( $_GET['code'], $redirectUri );
                 
            if(!$accessToken->isLongLived()){
                $newToken = $accessToken->getLongLivedAccessToken( $newToken['access_token'] );
            }

            $this->saveFbLoginToken($userId,2,$newToken['access_token'],'');
            $this->bussinessDiscovery($newToken['access_token'],$userId);
      }

      public function bussinessDiscovery($accessToken='',$userId){     
              
       $outhUrl = "https://graph.facebook.com/v15.0/me?fields=id,name,accounts{followers_count,fan_count,name,instagram_business_account}&access_token={$accessToken}" ;
         
        $response=$this->getDataFromFb($outhUrl);
        $oAuth = json_decode($response);
       
        $instaInfoUrl=[] ;
        //id  user_id        
         $insertData=array();
        if(isset($oAuth->accounts->data) && !empty($oAuth->accounts->data)){

           foreach ($oAuth->accounts->data as $key => $value) {
                $page_followerCount = $value->followers_count ;
                $page_fanCount = $value->fan_count ;
                $page_name = $value->name ;
                $page_id = $value->id ;
                if(isset($value->instagram_business_account)){
                  $instagramId = $value->instagram_business_account->id ;
                  $instaInfoUrl[]="https://graph.facebook.com/v15.0/".$instagramId."?fields=name,ig_id,username,followers_count,follows_count,media_count,media&access_token={$accessToken}";
                }else{
                  $instagramId = '' ;
                }

                $checkExistPage = DB::table('user_fb_page_info')->select('id')->where('page_id',$page_id)->first();
                if(!empty($checkExistPage)){
                  $existPageId = $checkExistPage->id; 
                  $udpateData=array(
                     'page_followers'=>$page_followerCount ,
                     'page_fan_count'=>$page_fanCount ,
                     'instagram_bussiness_acount'=>$instagramId ,
                     'page_name'=>$page_name 
                  );
                  DB::table('user_fb_page_info')->where('id',$existPageId)->update($udpateData);
                }else{
                  $insertData=array(
                  'user_id'=>$userId ,
                  'page_followers'=>$page_followerCount ,
                  'page_fan_count'=>$page_fanCount ,
                  'instagram_bussiness_acount'=>$instagramId ,
                  'page_name'=>$page_name ,
                  'page_id'=>$page_id
                  );
                   DB::table('user_fb_page_info')->insert($insertData);
                }

                
           }

           //get instagram information
          $this->getInstagramInfo($instaInfoUrl,$userId,$accessToken); 

          redirect()->to('/userList')->send();
           
        }else{
          redirect()->to('/fbError')->send();
          
        }
     }

    public function getInstagramInfo($instaInfoUrl,$userId,$accessToken){
        if(!empty($instaInfoUrl)){
            foreach ($instaInfoUrl as $key => $value) {
              $response_=$this->getDataFromFb($value);
              $instaData = json_decode($response_);
              
              if(!empty($instaData)){

                $checkInstaInfo=DB::table('user_instagram_info')->select('id')->where('bussiness_accountId',$instaData->id)->first();

                 if(!empty($checkInstaInfo)){
                  $updateId=$checkInstaInfo->id ;  
                  $insta_updateData=array(
                  'followers_count'=>$instaData->followers_count ,
                  'follows_count'=>$instaData->follows_count ,
                  'name'=>$instaData->name ,
                  'biography'=>'' ,
                  'ig_id'=>$instaData->ig_id ,
                  'media_count'=>$instaData->media_count ,
                  'username'=>$instaData->username
                   );  
                 DB::table('user_instagram_info')->where('id',$updateId)->update($insta_updateData);
                 
                 }else{
                  $insta_insertData=array(
                  'bussiness_accountId'=>$instaData->id ,
                  'userId'=>$userId  ,
                  'followers_count'=>$instaData->followers_count ,
                  'follows_count'=>$instaData->follows_count ,
                  'name'=>$instaData->name ,
                  'biography'=>'' ,
                  'ig_id'=>$instaData->ig_id ,
                  'media_count'=>$instaData->media_count ,
                  'username'=>$instaData->username
                );  
                 DB::table('user_instagram_info')->insert($insta_insertData);                 
                 }
                 //Get Instagram Media Data
                  $instaMediaData=isset($instaData->media->data)?$instaData->media->data:[];                  
                  if(!empty($instaMediaData)){
                    $mediaInfo=$this->getInstaMediaInfo($instaData->media->data,$accessToken,$userId);
                  }                
              }
            }
            	 $this->updateUserInstaData($userId);
            	 $this->updateUserInstaRankPoints($userId,3);
           }
     }

     public function getInstaMediaInfo($mediaData,$accessToken,$userId){
      
      $insertData=[];     
       if(!empty($mediaData)){
         foreach ($mediaData as $key => $value) {
           $mediaId = isset($value->id)?$value->id:0 ;
           if($mediaId!=0){
             $mediaUrl="https://graph.facebook.com/v15.0/".$mediaId."?fields=id,like_count,comments_count&access_token={$accessToken}";
             $mediaData = $this->getDataFromFb($mediaUrl) ;
             $mediaData =json_decode($mediaData);            
             $mediaId = isset($mediaData->id)?$mediaData->id:0;
             $mediaLikeCount=isset($mediaData->like_count)?$mediaData->like_count:0;
             $mediaCommentCount=isset($mediaData->comments_count)?$mediaData->comments_count:0;
             $insertData[]=array("userId"=>$userId,"media_id"=>$mediaId,"like_count"=>$mediaLikeCount ,"comment_count"=>$mediaCommentCount );
           }
         
         }
       }
       
       if(!empty($insertData)){
         DB::table("insta_media_info")->where('userId',$userId)->delete();
         DB::table("insta_media_info")->insert($insertData);
       }
       
     }

      public function getDataFromFb($url){
         $chs = curl_init();          
       curl_setopt($chs,CURLOPT_URL,$url);
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($chs);
       
        return $response ;
     }

     public function updateUserInstaData($userId){

       $checkData=DB::table('insta_user_info')->select('id')->where('userId',$userId)->first();
       
       $instaData=DB::table('user_instagram_info')->select(DB::raw('sum(followers_count) as followers_count'),DB::raw('sum(follows_count) as follows_count'),DB::raw('sum(media_count) as media_count'))->where('userId',$userId)->first();       
       
       $instaMediaData = DB::table('insta_media_info')->select(DB::raw('sum(like_count) as like_count'),DB::raw('sum(comment_count) as comment_count'))->where('userId',$userId)->first();       

       	$iFollowersC = isset($instaData->followers_count)?$instaData->followers_count:0 ;
       	$iFollowsC = isset($instaData->follows_count)?$instaData->follows_count:0 ;
       	$iMediaCount = isset($instaData->media_count)?$instaData->media_count:0 ;
       	$iLikeCount = isset($instaMediaData->like_count)?$instaMediaData->like_count:0 ;
       	$iCommentCount = isset($instaMediaData->comment_count)?$instaMediaData->comment_count:0 ;

            $insertData=array(       			
       			'followers_count'=>$iFollowersC ,
       			'follows_count'=>$iFollowsC ,
       			'total_post_count'=>$iMediaCount ,
       			'total_post_comment_count'=>$iLikeCount ,
       			'total_post_likes_count'=>$iCommentCount 
       		);

       if(!empty($checkData)){
       		$updateId = $checkData->id ;
       		DB::table('insta_user_info')->where('id',$updateId)->update($insertData);
       }else{  		
 			$insertData['userId']=$userId ;
       		DB::table('insta_user_info')->insert($insertData);
       }

     }

     public function updateUserInstaRankPoints($userId,$type){
     	
     		$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => env('SOCIAL_POINT_UPDATE_API'),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array('userId' =>$userId,'type' =>$type),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			//echo $response;
     }
    
    //Fb profile data
     public function fb_Profile_Data($userId){
        
         $config = array( 
        'app_id' => env('FB_APP_ID'), 
        'app_secret' => env('FB_APP_SECRET')
        );

        $permissions = array(            
            'user_friends',
            'user_posts'           
        );

        $facebookLogin = new FacebookLogin($config);
        $redirectUri = env('FB_REDIRECT_URI');
        $fbLoginUrl=$facebookLogin->getLoginDialogUrl($redirectUri,$permissions );
        
        return Redirect::to($fbLoginUrl."&state=".$userId);       
     }


    public function fbProfileDataResponse(Request $request){
            
            $state=isset($request->state)?$request->state:'' ;
            $userId=$this->checkUser($state);

            $rules=[            
            'code' => 'required'
           ] ;

            $validatedData = Validator::make($request->all(),$rules);
      
 
        if($validatedData->fails()){         
            return $this->errorResponse($validatedData->errors()->first(), 200);
          }

            $config = array( 
            'app_id' => env('FB_APP_ID'), 
            'app_secret' =>env('FB_APP_SECRET') 
            );

            $code = $request->code ;
           
            $redirectUri = env('FB_REDIRECT_URI');

            // instantiate our access token class
            $accessToken = new AccessToken($config);

            // exchange our code for an access token
            $newToken = $accessToken->getAccessTokenFromCode( $_GET['code'], $redirectUri );
                    
            if ( !$accessToken->isLongLived() ) { 
                $newToken = $accessToken->getLongLivedAccessToken( $newToken['access_token'] );
            }

            $accessToken=$newToken['access_token'] ;
            $this->saveFbLoginToken($userId,1,$newToken['access_token'],$refreshToken='');
            $this->getFBProfileData($accessToken,$userId);
            	//echo "success" ;
          if($accessToken!=''){
            redirect()->to('/userList')->send();
          }else{
            redirect()->to('/fbError')->send();  
          }
          
      }

      public function getFBProfileData($accessToken,$userId){
           
       $url="https://graph.facebook.com/v15.0/me?fields=id,name,posts{message,comments.summary(true){comments.summary(true).limit(0)},reactions.summary(true)},friends&access_token={$accessToken}";            
           
        $fbData_=$this->getDataFromFb($url);
        $fbData =json_decode($fbData_,true);
          
           $fbUserId=isset($fbData['id'])?$fbData['id']:0 ;
           $fbUserName=isset($fbData['name'])?$fbData['name']:'' ;
           $fbUserFriends=isset($fbData['friends']['summary']['total_count'])?$fbData['friends']['summary']['total_count']:0 ;
           $fbUserPost=isset($fbData['posts']['data'])?$fbData['posts']['data']:[] ;
           
           $totalComments=0;
           $totalLikes=0 ;
           $totalPost=count($fbUserPost);
           $insertCommentData=[];
            if(!empty($fbUserPost)){
              foreach ($fbUserPost as $key => $value) {
              	$message=isset($value['message'])?$value['message']:'';
                $replyComment=isset($value['comments']['data'])?$value['comments']['data']:[];
                $getReplyComment=$this->getReplyCommentCount($replyComment);
                $total_comments=isset($value['comments']['summary']['total_count'])?$value['comments']['summary']['total_count']:0 ;

                $total_likes=isset($value['reactions']['summary']['total_count'])?$value['reactions']['summary']['total_count']:0 ; 

                $totalComments=$totalComments+$total_comments+$getReplyComment ;
                $totalLikes=$totalLikes+$total_likes ;

                $insertCommentData[]=array('userId'=>$userId,'message'=>$message,'total_comment'=>($total_comments+$getReplyComment),'total_like'=>$total_likes);
                             
              }
            }

          if(!empty($insertCommentData)){
          	DB::table('fb_post_comment')->where('userId',$userId)->delete();
          	DB::table('fb_post_comment')->insert($insertCommentData);
          }

         $fbPageData = DB::table('user_fb_page_info')->select(DB::raw('sum(page_followers) as totalFollowers'),DB::raw('sum(page_fan_count) as totalLikes'))->where('user_id',$userId)->first();
         $followers = isset($fbPageData->totalFollowers)?$fbPageData->totalFollowers:0 ;
         $likes = isset($fbPageData->totalLikes)?$fbPageData->totalLikes:0 ;

         $insertData = array(
            'total_friends_count'=>$fbUserFriends ,
            'fb_page_followers_count'=>$followers ,
            'fb_page_likes_count'=>$likes ,
            'fb_post_comments'=>$totalComments ,
            'fb_post_likes'=>$totalLikes ,
            'fb_post_count'=>$totalPost 
         );

         $checkFbData = DB::table('fb_user_info')->select('id')->where('userId',$userId)->first();
         if(!empty($checkFbData)){
          DB::table('fb_user_info')->where('userId',$userId)->update($insertData);
         }else{
          $insertData['userId'] = $userId ;
          DB::table('fb_user_info')->insert($insertData);
         }
        
         $this->updateUserInstaRankPoints($userId,2);
      }

     public function getReplyCommentCount($replyComment){

        $totalComment=0 ;
       
        if(!empty($replyComment)){
          foreach ($replyComment as $key => $value){
            $replyComment = isset($value['comments']['summary']['total_count'])?$value['comments']['summary']['total_count']:0 ;
            $totalComment=$totalComment+$replyComment ;
          }
        }
         
        return $totalComment ;
     }

      public function saveFbLoginToken($userId,$type,$accessToken,$refreshToken=''){
      		
      		$checkToken=DB::table('fb_login_info')->select('id')->where('usreId',$userId)
      		            ->where('type',$type)->first();

      		if(!empty($checkToken)){
      			$updateId = isset($checkToken->id)?$checkToken->id:0 ;
      			$updateData=array(	      			
	      			"access_token"=>$accessToken ,
	      			"refresh_token"=>$refreshToken 	      			
      		     );
      			DB::table('fb_login_info')->where('id',$updateId)->update($updateData);
      		}else{
      			$insertData=array(
	      			"usreId"=>$userId ,
	      			"access_token"=>$accessToken ,
	      			"refresh_token"=>$refreshToken ,
	      			"type"=>$type 
      		     );
      			DB::table('fb_login_info')->insert($insertData);
      		}
      }

      public function user_list(Request $request){
       $userList=DB::table('users')->where('user_type','!=',1)->where('isTrash',0)->orderBy('id', 'DESC')->get();
       return view('fb_review.index',["userList"=>$userList]);
     }

     public function user_points(Request $request){
      $userId=$request->id ;
      $name=$request->name ;
      $socialWeightage = DB::table('social_media_weightage')->where('status',1)->get();
      $fbData=DB::table('fb_user_info')->where('userId',$userId)->first();
      $instaData=DB::table('insta_user_info')->where('userId',$userId)->first();
      $tiktokData=DB::table('tiktok_user_info')->where('userId',$userId)->first();
      $userPoint=DB::table('user_social_point')->where('user_id',$userId)->first();
      $sw=[];
      if(!empty($socialWeightage)){
        foreach ($socialWeightage as $key => $value) {
          $sw[$value->slug]=$value->weightage ;
        }
      }
      
      return view('fb_review.ajax_points',['socialW'=>$sw,'fbData'=>$fbData,'instaData'=>$instaData,'tiktokData'=>$tiktokData,'userPoint'=>$userPoint,'name'=>$name]);
     }
     
}
