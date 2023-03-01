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
     $appId='1231815401047899';     
     $redirectUri=urlencode('https://dev.walkofweb.net/insta/callback');      
     return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media,instagram_basic,instagram_content_publish,instagram_manage_insights,instagram_manage_comments,pages_show_list,ads_management,business_management,pages_read_engagement&response_type=code");
// $permissions = array( // permissions to request from the user
//             'instagram_basic',
//             'instagram_content_publish', 
//             'instagram_manage_insights', 
//             'instagram_manage_comments',
//             'pages_show_list', 
//             'ads_management', 
//             'business_management', 
//             'pages_read_engagement'
//         );
     }

    public function instagramProviderCallback(Request $request){
        $code = $request->code ;
        $client_id='1231815401047899';
     
        $redirect_uri='https://dev.walkofweb.net/insta/callback' ;
        $client_secret='082dba286f3993354bb5d120dd4df84f' ;
       
       $ch=curl_init();
           curl_setopt($ch,CURLOPT_URL,"https://api.instagram.com/oauth/access_token");
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
          print_r($data);
         $accessToken = json_decode($data)->access_token;
         $userId = json_decode($data)->user_id;
          echo "https://graph.instagram.com/v15.0/{$userId}?fields=account_type,id,username,media{caption,id,is_shared_to_feed,media_type,media_url,permalink,thumbnail_url,timestamp,username}&access_token={$accessToken}" ; exit ;
        $chs = curl_init();
          curl_setopt($chs,CURLOPT_URL,"https://graph.instagram.com/v15.0/{$userId}?fields=account_type,id,username,media{caption,id,is_shared_to_feed,media_type,media_url,permalink,thumbnail_url,timestamp,username}&access_token={$accessToken}");
        //curl_setopt($chs,CURLOPT_URL,"https://graph.instagram.com/v15.0/me?fields=id,account_type,username,media_count&access_token={$accessToken}");
                
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);

        $response = curl_exec($chs);

        $oAuth = json_decode($response);
               dd($oAuth);

        $username = $oAuth->username ;
        $user = ['email'=>$username,'token'=>$userId,'name'=>$username,'social_id'=> $userId,'social_type'=> 'instagram','password' => encrypt('my-facebook')];
        $user = (object)$user ;
        $data = User::where('email',$user->email)->first();
        if(is_null($data)){        
        $users['name']=$user->name ;
        $users['email']=$user->email ;      
        $users['social_id']=$user->social_id ;  
        $users['social_type']=$user->social_type ;
        $users['password']=$user->password ;  
        $data = User::create($users);
        }
        Auth::login($data);
        return redirect('/');
}
     
     public function getDataFromFb($url){
         $chs = curl_init();          
       curl_setopt($chs,CURLOPT_URL,$url);
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($chs);
       
        return $response ;
     }
     public function bussinessDiscovery($accessToken='',$userId=''){     
        // curl_setopt($chs,CURLOPT_URL,"https://graph.facebook.com/v15.0/me?fields=id,name,businesses{instagram_business_accounts{followers_count,username,follows_count,profile_picture_url,media{caption,comments_count,like_count,media_type,media_url,thumbnail_url,username,comments{like_count,username,text,user}}}}&access_token={$accessToken}");
      

      
        $outhUrl = "https://graph.facebook.com/v15.0/me?fields=accounts{followers_count,fan_count,name,instagram_business_account}&access_token={$accessToken}" ;

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
                  $instaInfoUrl[]="https://graph.facebook.com/v15.0/".$instagramId."?fields=biography,name,website,followers_count,follows_count,ig_id,media_count,username&access_token={$accessToken}";
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
                  'biography'=>$instaData->biography ,
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
                  'biography'=>$instaData->biography ,
                  'ig_id'=>$instaData->ig_id ,
                  'media_count'=>$instaData->media_count ,
                  'username'=>$instaData->username
                );  
                 DB::table('user_instagram_info')->insert($insta_insertData);
                 
                 }
                
              }
              
            }
            
           }
           
          
          redirect()->to('/fbSuccess')->send();
           
        }else{
          redirect()->to('/fbError')->send();
          
        }
     }

     public function fb_error(){
         echo "Something went wrong" ;
      }


      public function fbSuccessResp(){
         echo "Facebook page and instagram bussiness account details successfully have been added" ;
      }
     public function fbLogin(){
        $config = array( // instantiation config params
        'app_id' => '2972423753060577', // facebook app id
        'app_secret' => '6fa847c834a094543daa98dfc283e0bb', // facebook app secret
        );

        // uri facebook will send the user to after they login
        $redirectUri = 'https://dev.walkofweb.net/fbCallback';

        $permissions = array( // permissions to request from the user
            'instagram_basic',
            'instagram_content_publish', 
            'instagram_manage_insights', 
            'instagram_manage_comments',
            'pages_show_list', 
            'ads_management', 
            'business_management', 
            'pages_read_engagement'
        );

        // instantiate new facebook login
        $facebookLogin = new FacebookLogin( $config );
        $fbLoginUrl=$facebookLogin->getLoginDialogUrl( $redirectUri, $permissions );

        //fb profile data
         $config_ = array( // instantiation config params
        'app_id' => '2510330525940547', // facebook app id
        'app_secret' => 'fe4ed5c133365c2ea11808dc81b6074b', // facebook app secret
        );


        $permissions_ = array( // permissions to request from the user
            'user_birthday',
            'user_hometown', 
            'user_location', 
            'user_likes',
            'user_events', 
            'user_photos', 
            'user_videos', 
            'user_friends',
            'user_posts',
            'user_gender',
            'user_link',
            'user_age_range',
            'email',
            'manage_fundraisers',
            'user_managed_groups',
            'public_profile'
        );


        // instantiate new facebook login
        $facebookLogin_ = new FacebookLogin($config_);
        $redirectUri_ = 'https://dev.walkofweb.net/fbBasicInfo';
        $fbLoginUrl_=$facebookLogin_->getLoginDialogUrl( $redirectUri_, $permissions_ );
       $instaLoginUrl ="https://dev.walkofweb.net/insta/login";
       $tiktokLoginUrl="https://www.walkofweb.net/auth";
      
       return view('fbLogin',["fbLoginUrl"=>$fbLoginUrl,"fbLoginUrl_"=>$fbLoginUrl_,"instaLoginUrl"=>$instaLoginUrl,"tiktokLoginUrl"=>$tiktokLoginUrl]);
     }

     public function fb_connect($usreId='6c20bc57a46267086688d5e0f0241175'){
      $config = array( // instantiation config params
        'app_id' => '2972423753060577', // facebook app id
        'app_secret' => '6fa847c834a094543daa98dfc283e0bb', // facebook app secret
        );

        // uri facebook will send the user to after they login
        $redirectUri = 'https://dev.walkofweb.net/fbCallback';

        $permissions = array( // permissions to request from the user
            'instagram_basic',
            'instagram_content_publish', 
            'instagram_manage_insights', 
            'instagram_manage_comments',
            'pages_show_list', 
            'ads_management', 
            'business_management', 
            'pages_read_engagement'
        );

        // instantiate new facebook login
        $facebookLogin = new FacebookLogin( $config );
        $fbLoginUrl=$facebookLogin->getLoginDialogUrl( $redirectUri, $permissions ); 
        return Redirect::to($fbLoginUrl."&state=".$usreId);
        
     }

      public function fbResponse(Request $request){
            $userId=$request->state ;
            $checkUsr = DB::table('users')->select('id')->where('encryption',$userId)->first();
            
            if(!empty($checkUsr)){
              $userId=$checkUsr->id ;
            }else{
              $userId=0 ; 
              echo "Invalid Request" ; exit ;
            }

            $config = array( // instantiation config params
            'app_id' => '2972423753060577', // facebook app id
            'app_secret' => '6fa847c834a094543daa98dfc283e0bb', // facebook app secret
            );
            
            $code = $request->code ;
            // we also need to specify the redirect uri in order to exchange our code for a token
            $redirectUri = 'https://dev.walkofweb.net/fbCallback';

            // instantiate our access token class
            $accessToken = new AccessToken( $config );

            // exchange our code for an access token
            $newToken = $accessToken->getAccessTokenFromCode( $_GET['code'], $redirectUri );
                    
            if ( !$accessToken->isLongLived() ) { // check if our access token is short lived (expires in hours)
                // exchange the short lived token for a long lived token which last about 60 days
                $newToken = $accessToken->getLongLivedAccessToken( $newToken['access_token'] );
            }

            
            $this->bussinessDiscovery($newToken['access_token'],$userId);
      }




      public function fbProfileDataResponse(Request $request){
            
            $config = array( // instantiation config params
            'app_id' => '2510330525940547', // facebook app id
            'app_secret' => 'fe4ed5c133365c2ea11808dc81b6074b', // facebook app secret
            );

            $code = $request->code ;
            // we also need to specify the redirect uri in order to exchange our code for a token
            $redirectUri = 'https://dev.walkofweb.net/fbBasicInfo';

            // instantiate our access token class
            $accessToken = new AccessToken( $config );

            // exchange our code for an access token
            $newToken = $accessToken->getAccessTokenFromCode( $_GET['code'], $redirectUri );
                    
            if ( !$accessToken->isLongLived() ) { // check if our access token is short lived (expires in hours)
                // exchange the short lived token for a long lived token which last about 60 days
                $newToken = $accessToken->getLongLivedAccessToken( $newToken['access_token'] );
            }

            
            $this->fbProfileInfo($newToken['access_token']);
      }

       public function fbProfileInfo($accessToken=''){ 

       $chs = curl_init();
          curl_setopt($chs,CURLOPT_URL,"https://graph.facebook.com/v15.0/me?fields=id,name,birthday,gender,email,friends,age_range,hometown,location,feed{comments{comment_count,like_count,message}}&access_token={$accessToken}");
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($chs);
        echo "<pre>";
         $oAuth = json_decode($response);
        print_r($oAuth);

      exit;
     }

}
