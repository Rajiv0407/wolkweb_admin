
<?php //echo "<pre>";  print_r($userPoint); 
//$var=1;
?>


<table class="table">
  <thead>
    <tr>
      <th >Sr. No.</th>
      <th >Social Fields</th>
      <th >Social Weightage</th>  
      <th >Social Data</th>
      <th >Points</th>        
    </tr>
  </thead>
  <tbody>
    <tr>
      <td >1</td>
      <td >Facebook Total Friends</td>
      <td ><?php echo isset($socialW['fb_friends_count'])?$socialW['fb_friends_count']:0 ; ?></td>  
      <td ><?php echo isset($fbData->total_friends_count)?$fbData->total_friends_count:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_friends_count)?$userPoint->fb_friends_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >2</td>
      <td >Facebook Page Followers Count</td>
      <td ><?php echo isset($socialW['fb_page_followers_count'])?$socialW['fb_page_followers_count']:0 ; ?></td>  
      <td ><?php echo isset($fbData->fb_page_followers_count)?$fbData->fb_page_followers_count:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_page_followers_count)?$userPoint->fb_page_followers_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >3</td>
      <td >Facebook Page Like Count</td>
      <td ><?php echo isset($socialW['fb_page_likes_count'])?$socialW['fb_page_likes_count']:0 ; ?></td>  
      <td ><?php echo isset($fbData->fb_page_likes_count)?$fbData->fb_page_likes_count:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_page_likes_count)?$userPoint->fb_page_likes_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >4</td>
      <td >Facebook Post comments</td>
      <td ><?php echo isset($socialW['fb_post_comments'])?$socialW['fb_post_comments']:0 ; ?></td>  
      <td ><?php echo isset($fbData->fb_post_comments)?$fbData->fb_post_comments:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_post_comment)?$userPoint->fb_post_comment:0 ; ?></td>        
    </tr>
     <tr>
      <td >5</td>
      <td >Facebook Post likes</td>
      <td ><?php echo isset($socialW['fb_post_likes'])?$socialW['fb_post_likes']:0 ; ?></td>  
      <td ><?php echo isset($fbData->fb_post_likes)?$socialW['fb_post_likes']:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_post_likes)?$userPoint->fb_post_likes:0 ; ?></td>        
    </tr>
     <tr>
      <td >6</td>
      <td >Facebook Post count</td>
      <td ><?php echo isset($socialW['fb_post_count'])?$socialW['fb_post_count']:0 ; ?></td>  
      <td ><?php echo isset($fbData->fb_post_count)?$fbData->fb_post_count:0 ; ?></td>
      <td><?php echo isset($userPoint->fb_post_count)?$userPoint->fb_post_count:0 ; ?></td>        
    </tr> 
     <tr>
      <td >7</td>
      <td >Instagram Follows Count</td>
      <td ><?php echo isset($socialW['insta_follows_count'])?$socialW['insta_follows_count']:0 ; ?></td>  
      <td ><?php echo isset($instaData->follows_count)?$instaData->follows_count:0 ; ?></td>
      <td><?php echo isset($userPoint->insta_follows_count)?$userPoint->insta_follows_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >8</td>
      <td >Instagram Total Post Count</td>
      <td ><?php echo isset($socialW['insta_total_post_counts'])?$socialW['insta_total_post_counts']:0 ; ?></td>  
      <td ><?php echo isset($instaData->total_post_count)?$instaData->total_post_count:0 ; ?></td>
      <td><?php echo isset($userPoint->insta_total_post_count)?$userPoint->insta_total_post_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >9</td>
      <td >Instagram Total Post Comment Count</td>
      <td ><?php echo isset($socialW['insta_total_post_comment_counts'])?$socialW['insta_total_post_comment_counts']:0 ; ?></td>  
      <td ><?php echo isset($instaData->total_post_comment_count)?$instaData->total_post_comment_count:0 ; ?></td>
      <td><?php echo isset($userPoint->insta_post_comment_count)?$userPoint->insta_post_comment_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >10</td>
      <td >Instagram Total Post Like Count</td>
      <td ><?php echo isset($socialW['insta_total_post_likes_count'])?$socialW['insta_total_post_likes_count']:0 ; ?></td>  
      <td ><?php echo isset($instaData->total_post_likes_count)?$instaData->total_post_likes_count:0 ; ?></td>
      <td><?php echo isset($userPoint->insta_post_likes_count)?$userPoint->insta_post_likes_count:0 ; ?></td>        
    </tr> 
      <tr>
      <td >11</td>
      <td >Instagram Total Followers Count</td>
      <td ><?php echo isset($socialW['insta_followers_count'])?$socialW['insta_followers_count']:0 ; ?></td>  
      <td ><?php echo isset($instaData->followers_count)?$instaData->followers_count:0 ; ?></td>
      <td><?php echo isset($userPoint->insta_followers_count)?$userPoint->insta_followers_count:0 ; ?></td>        
    </tr> 
     <tr>
      <td >12</td>
      <td >Tiktok Followers Count</td>
      <td ><?php echo isset($socialW['tiktok_followers_count'])?$socialW['tiktok_followers_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->followers_count)?$tiktokData->followers_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_followers_count)?$userPoint->tiktok_followers_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >13</td>
      <td >Tiktok Follows Count</td>
      <td ><?php echo isset($socialW['tiktok_follows_count'])?$socialW['tiktok_follows_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->follows_count)?$tiktokData->follows_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_follows_count)?$userPoint->tiktok_follows_count:0 ; ?></td>        
    </tr>
    <tr>
      <td >14</td>
      <td >Tiktok Like Count</td>
      <td ><?php echo isset($socialW['tiktok_likes_count'])?$socialW['tiktok_likes_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->likes_count)?$tiktokData->likes_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_likes_count)?$userPoint->tiktok_likes_count:0 ; ?></td>        
    </tr>
    <tr>
      <td >15</td>
      <td >Tiktok video like count</td>
      <td ><?php echo isset($socialW['tiktok_video_likes_count'])?$socialW['tiktok_video_likes_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->video_likes_count)?$tiktokData->video_likes_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_video_likes_count)?$userPoint->tiktok_video_likes_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >16</td>
      <td >Tiktok video share count</td>
      <td ><?php echo isset($socialW['tiktok_video_shares_count'])?$socialW['tiktok_video_shares_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->video_shares_count)?$tiktokData->video_shares_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_video_shares_count)?$userPoint->tiktok_video_shares_count:0 ; ?></td>        
    </tr>
    <tr>
      <td >17</td>
      <td >Tiktok video comment count</td>
      <td ><?php echo isset($socialW['tiktok_video_comments_count'])?$socialW['tiktok_video_comments_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->video_comment_count)?$tiktokData->video_comment_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_video_comments_count)?$userPoint->tiktok_video_comments_count:0 ; ?></td>        
    </tr>
     <tr>
      <td >18</td>
      <td >Tiktok video view count</td>
      <td ><?php echo isset($socialW['tiktok_video_views_count'])?$socialW['tiktok_video_views_count']:0 ; ?></td>  
      <td ><?php echo isset($tiktokData->video_view_count)?$tiktokData->video_view_count:0 ; ?></td>
      <td><?php echo isset($userPoint->tiktok_video_view_count)?$userPoint->tiktok_video_view_count:0 ; ?></td>        
    </tr>
     <tr>
      <th colspan="4" style="text-align:right;" >Total Points</th>      
      <td><?php echo isset($userPoint->total_point)?$userPoint->total_point:0 ; ?></td>        
    </tr>
    <tr>
      <th colspan="4" style="text-align:right;">Average Points</th>      
      <td ><?php echo isset($userPoint->avg_point)?$userPoint->avg_point:0 ; ?></td>        
    </tr>

  </tbody>
</table>