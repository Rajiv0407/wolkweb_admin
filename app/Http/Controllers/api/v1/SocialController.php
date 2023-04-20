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

class SocialController extends Controller
{
    
    public function social_point_calculation(Request $request){

        $userId = isset($request->userId)?$request->userId:0 ;
        $type = isset($request->type)?$request->type:0 ; //type 1 > tiktok , 2 > facebook , 3 > instagram
       
        if($type==1){
            $this->tiktokPointActivity($userId);            
        }else if($type==2){
           $this->fbPointActivity($userId); 
        }else if($type==3){
            $this->instaPointActivity($userId); 
        }else{
            
            return true ;
        }  

    }

    public function fbPointActivity($userId){
        $sPWT = $this->getSocialMediaPoint();
        $checkSocialUser = DB::table('fb_user_info')->where('userId',$userId)->first();
        $fbTotalPoint=0 ;

        if(!empty($checkSocialUser)){   
            // fb activity
            $fbTotalFriends = $checkSocialUser->total_friends_count ;
            $fbPageFollowers = $checkSocialUser->fb_page_followers_count ;
            $fbPageLikesCount = $checkSocialUser->fb_page_likes_count ;
            $fbPostComments = $checkSocialUser->fb_post_comments ;
            $fbPostLikes = $checkSocialUser->fb_post_likes ;
            $fbPostCount = $checkSocialUser->fb_post_count ;
         

            //fb weightage
            $fbFriendsWT=$sPWT['fb_friends_count'] ;
            $fbPageFollowersWT=$sPWT['fb_page_followers_count'] ;
            $fbPageLikesCountWT=$sPWT['fb_page_likes_count'] ;
            $fbPostCommentsWT=$sPWT['fb_post_comments'] ;
            $fbPostLikesWT=$sPWT['fb_post_likes'] ;
            $fbPostCountWT=$sPWT['fb_post_count'] ;
           
            
            // fb point calculation
            $fbTotalFriendsPoint = $fbTotalFriends * $fbFriendsWT ;
            $fbPageFollowersPoint = $fbPageFollowers * $fbPageFollowersWT ;
            $fbPageLikesCountPoint = $fbPageLikesCount * $fbPageLikesCountWT ;
            $fbPostCommentsPoint = $fbPostComments * $fbPostCommentsWT ;
            $fbPostLikesPoint = $fbPostLikes * $fbPostLikesWT ;
            $fbPostCountPoint = $fbPostCount * $fbPostCountWT ;

           
            $fbTotalPoint = $fbTotalFriendsPoint + $fbPageFollowersPoint + $fbPageLikesCountPoint
             + $fbPostCommentsPoint + $fbPostLikesPoint + $fbPostCountPoint  ;
            

          $checkSocialPoint = $this->checkSocialPoint($userId);
            $updateData=array(
                'fb_friends_count'=>$fbTotalFriendsPoint ,
                'fb_page_followers_count'=>$fbPageFollowersPoint ,
                'fb_page_likes_count'=>$fbPageLikesCountPoint ,
                'fb_post_comment'=>$fbPostCommentsPoint ,
                'fb_post_likes'=>$fbPostLikesPoint ,
                'fb_post_count'=>$fbPostCountPoint 
            );
          
            if($checkSocialPoint==0){
                $updateData['user_id']=$userId ;
                $avgPoint = $fbTotalPoint/100 ;
                $updateData['total_point']=$fbTotalPoint ;
                $updateData['avg_point']=$avgPoint ;
                DB::table('user_social_point')->insert($updateData);
                $this->updateUserPoint($userId,$fbTotalPoint);
            }else{        
                $currentTotalPoint =  $checkSocialPoint + $fbTotalPoint ;
                $avgPoint =  $currentTotalPoint / 100 ;   
                $updateData['total_point']=$currentTotalPoint ;
                $updateData['avg_point']=$avgPoint ;              
                DB::table('user_social_point')->where('user_id',$userId)->update($updateData);
                $this->updateTotalPoint($userId);
                 
            }

        }        
    }

    public function instaPointActivity($userId){
        $sPWT = $this->getSocialMediaPoint();
        $checkSocialUser = DB::table('insta_user_info')->where('userId',$userId)->first();
        $instaTotalPoint=0 ;

        if(!empty($checkSocialUser)){   
            // insta activity
            $instaFollowers = $checkSocialUser->followers_count ;
            $instaFollows = $checkSocialUser->follows_count ;
            $instaToalPostCount = $checkSocialUser->total_post_count ;
            $instaTotalPostComment = $checkSocialUser->total_post_comment_count ;
            $instaTotalPostLikes = $checkSocialUser->total_post_likes_count ;
          

            //insta weightage
            $instaFollowersWT=$sPWT['insta_followers_count'] ;
            $instaFollowsWT=$sPWT['insta_follows_count'] ;
            $instaToalPostCountWT=$sPWT['insta_total_post_counts'] ;
            $instaTotalPostCommentWT=$sPWT['insta_total_post_comment_counts'] ;
            $instaTotalPostLikesWT=$sPWT['insta_total_post_likes_count'] ;                     

            // insta point calculation
            $instaFollowersPoint = $instaFollowers * $instaFollowersWT ;
            $instaFollowsPoint = $instaFollows * $instaFollowsWT ;
            $instaToalPostCountPoint = $instaToalPostCount * $instaToalPostCountWT ;
            $instaTotalPostCommentPoint = $instaTotalPostComment * $instaTotalPostCommentWT ;
            $instaTotalPostLikesPoint = $instaTotalPostLikes * $instaTotalPostLikesWT ;
          

           
            $instaTotalPoint = $instaFollowersPoint + $instaFollowsPoint + $instaToalPostCountPoint
             + $instaTotalPostCommentPoint + $instaTotalPostLikesPoint  ;
            

            $checkSocialPoint = $this->checkSocialPoint($userId);
            $updateData=array(
                'insta_followers_count'=>$instaFollowersPoint ,
                'insta_follows_count'=>$instaFollowsPoint ,
                'insta_total_post_count'=>$instaToalPostCountPoint ,
                'insta_post_comment_count'=>$instaTotalPostCommentPoint ,
                'insta_post_likes_count'=>$instaTotalPostLikesPoint 
            );
           
            if($checkSocialPoint==0){
                $updateData['user_id']=$userId ;
                $avgPoint = $instaTotalPoint/100 ;
                $updateData['total_point']=$instaTotalPoint ;
                $updateData['avg_point']=$avgPoint ;
                DB::table('user_social_point')->insert($updateData);
                $this->updateUserPoint($userId,$instaTotalPoint);
            }else{   
                $currentTotalPoint =  $checkSocialPoint + $instaTotalPoint ;
                $avgPoint =  $currentTotalPoint / 100 ;   
                $updateData['total_point']=$currentTotalPoint ;
                $updateData['avg_point']=$avgPoint ;            
                DB::table('user_social_point')->where('user_id',$userId)->update($updateData);
                $this->updateTotalPoint($userId);
                 
            }

        }        
    }

    

    public function tiktokPointActivity($userId){
        $sPWT = $this->getSocialMediaPoint();
        $checkSocialUser = DB::table('tiktok_user_info')->where('userId',$userId)->first();
        $tiktokTotalPoint=0 ;

        if(!empty($checkSocialUser)){   
            // tiktok activity
            $followersCount = $checkSocialUser->followers_count ;
            $followsCount = $checkSocialUser->follows_count ;
            $likesCount = $checkSocialUser->likes_count ;
            $videoLikeCount = $checkSocialUser->video_likes_count ;
            $videoShareCount = $checkSocialUser->video_shares_count ;
            $videoCommentCount = $checkSocialUser->video_comment_count ;
            $videoViewCount = $checkSocialUser->video_view_count ;

            //titok weightage
            $tiktokFollowerWT=$sPWT['tiktok_followers_count'] ;
            $tiktokFollowsWT=$sPWT['tiktok_follows_count'] ;
            $tiktokLikesWT=$sPWT['tiktok_likes_count'] ;
            $tiktokVideoLikeWT=$sPWT['tiktok_video_likes_count'] ;
            $tiktokVideoCommentWT=$sPWT['tiktok_video_comments_count'] ;
            $tiktokVideoShareWT=$sPWT['tiktok_video_shares_count'] ;
            $tiktokVedioViewWT=$sPWT['tiktok_video_views_count'] ;

            // tiktok point calculation
            $followerPoint = $followersCount * $tiktokFollowerWT ;
            $followsPoint = $followsCount * $tiktokFollowsWT ;
            $likesPoint = $likesCount * $tiktokLikesWT ;
            $videoLikePoint = $videoLikeCount * $tiktokVideoLikeWT  ;
            $videoSharePoint = $videoShareCount * $tiktokVideoShareWT ;
            $videoCommentPoint = $videoCommentCount * $tiktokVideoCommentWT;
            $videoViewPoint = $videoViewCount *  $tiktokVedioViewWT;

            $tiktokTotalPoint = $followerPoint + $followsPoint + $likesPoint + $videoLikePoint + $videoSharePoint + $videoCommentPoint + $videoViewPoint ;
            

            $checkSocialPoint = $this->checkSocialPoint($userId);
            $updateData=array(
                'tiktok_followers_count'=>$followerPoint ,
                'tiktok_follows_count'=>$followsPoint ,
                'tiktok_likes_count'=>$likesPoint ,
                'tiktok_video_likes_count'=>$videoLikePoint ,
                'tiktok_video_shares_count'=>$videoSharePoint ,
                'tiktok_video_comments_count'=>$videoCommentPoint ,
                'tiktok_video_view_count'=>$videoViewPoint 
            );
           
            if($checkSocialPoint==0){
                $updateData['user_id']=$userId ;
                $avgPoint = $tiktokTotalPoint/100 ;
                $updateData['total_point']=$tiktokTotalPoint ;
                $updateData['avg_point']=$avgPoint ;
                DB::table('user_social_point')->insert($updateData);
                $this->updateUserPoint($userId,$tiktokTotalPoint);
            }else{ 
                $currentTotalPoint =  $checkSocialPoint + $tiktokTotalPoint ;
                $avgPoint =  $currentTotalPoint / 100 ;   
                $updateData['total_point']=$currentTotalPoint ;
                $updateData['avg_point']=$avgPoint ;   
                DB::table('user_social_point')->where('user_id',$userId)->update($updateData);
                $this->updateTotalPoint($userId);
                 
            }

        }        
    }

    public function updateTotalPoint($userId){

        $checkSocialPoint = DB::table('user_social_point')->where('user_id',$userId)->first();    
        $fb_friends_count=$checkSocialPoint->fb_friends_count ;
        $fb_page_followers_count=$checkSocialPoint->fb_page_followers_count ;
        $fb_page_likes_count=$checkSocialPoint->fb_page_likes_count ;
        $fb_post_comment=$checkSocialPoint->fb_post_comment ;
        $fb_post_likes=$checkSocialPoint->fb_post_likes ;
        $fb_post_count=$checkSocialPoint->fb_post_count ;

        $insta_followers_count=$checkSocialPoint->insta_followers_count ;
        $insta_follows_count=$checkSocialPoint->insta_follows_count ;
        $insta_total_post_count=$checkSocialPoint->insta_total_post_count ;
        $insta_post_comment_count=$checkSocialPoint->insta_post_comment_count ;
        $insta_post_likes_count=$checkSocialPoint->insta_post_likes_count ;

        $tiktok_followers_count=$checkSocialPoint->tiktok_followers_count ;
        $tiktok_follows_count=$checkSocialPoint->tiktok_follows_count ;
        $tiktok_likes_count=$checkSocialPoint->tiktok_likes_count ;
        $tiktok_video_likes_count=$checkSocialPoint->tiktok_video_likes_count ;
        $tiktok_video_shares_count=$checkSocialPoint->tiktok_video_shares_count ;
        $tiktok_video_comments_count=$checkSocialPoint->tiktok_video_comments_count ;
        $tiktok_video_view_count=$checkSocialPoint->tiktok_video_view_count ;        

        $fbTotalPoint = ($fb_friends_count+$fb_page_followers_count+$fb_page_likes_count+$fb_post_comment+$fb_post_likes+$fb_post_count);	
        $instaTotalPoint = ($insta_followers_count+$insta_follows_count+$insta_total_post_count+$insta_post_comment_count+$insta_post_likes_count)	;
        $tiktokTotalPoint = ($tiktok_followers_count+$tiktok_follows_count+$tiktok_likes_count+$tiktok_video_likes_count+$tiktok_video_shares_count+$tiktok_video_comments_count+$tiktok_video_view_count);
        
        $totalPoint = $fbTotalPoint+$instaTotalPoint+$tiktokTotalPoint ;
        $avgPoint = ($totalPoint / 100) ;

        DB::table('user_social_point')->where('user_id',$userId)->update(["total_point"=>$totalPoint ,"avg_point"=>$avgPoint ]);
        $this->updateUserPoint($userId,$totalPoint);
    }



    public function getSocialMediaPoint(){
        $socialPoint = DB::table('social_media_weightage')->get();        
        $socialWT = [] ;
        foreach($socialPoint as $key=>$val){
            $socialWT[$val->slug]=$val->weightage;
        }
        return $socialWT ;
    }

    public function checkSocialPoint($userId){
        $checkSocialPoint = DB::table('user_social_point')->where('user_id',$userId)->first();
        if(!empty($checkSocialPoint)){
            return $checkSocialPoint->total_point ;
        }else{
            return 0 ;
        }

    }

    public function updateUserPoint($userId,$point){
        $rankType = $this->getRankType($point);
        DB::table('users')->where('id',$userId)->update(['rank_'=>$point,'rank_type'=>$rankType]);
        updateUserFollowers($userId);
    }

    public function getRankType($point){
        $rankType=DB::table('rank_types')->where('status',1)->get();
        if(!empty($rankType)){
           foreach($rankType as $key=>$val){
                if($point >=$val->range_from && $point <=$val->range_to){
                    return $val->id ;
                }
           }  
        }
    }

    public function getSocialDataByCron(Request $request){
      $log=DB::table('users')->where('id',8)->get();
      print_r($log);
    }
}