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
     return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");

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

         $accessToken = json_decode($data)->access_token;
         $userId = json_decode($data)->user_id;
          
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
     
     public function bussinessDiscovery($accessToken=''){     
        
         // $accessToken='EAAqPZA1XsUOEBAPgqDENmbPhrKm3YPgUTvTbvTEGg9yqprPU1DxZAcZBOIUkZBVkZBSZBjoe0CLSj0NKfIQ7GypCBXEWHUCWu2xkZC5hFT1c8NBDzJEIQTiQXhAdMRSHNgiYLJNMu2rT7sSPhMlExRxNMxCaKTfoYlGFENHjqpKB000OQFiaYD69RkQhQT7wmG1W0AmXlDGGHUakS1l9pEEfigqjBIbhbXjnaW9H4BlsAZDZD' ;

       $chs = curl_init();
          curl_setopt($chs,CURLOPT_URL,"https://graph.facebook.com/v15.0/me?fields=id,name,businesses{instagram_business_accounts{followers_count,username,follows_count,profile_picture_url,media{caption,comments_count,like_count,media_type,media_url,thumbnail_url,username,comments{like_count,username,text,user}}}}&access_token={$accessToken}");
       
                
        curl_setopt($chs,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($chs,CURLOPT_SSL_VERIFYPEER,false);

        $response = curl_exec($chs);
        
        echo "<pre>";
        
         $oAuth = json_decode($response);
        print_r($oAuth);
      exit;
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


      public function fbResponse(Request $request){
            
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

            
            $this->bussinessDiscovery($newToken['access_token']);
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

    public function qrCode()
    {
      return \QrCode::generate('Laravel QR Code Generator!')->png();
    }

}
