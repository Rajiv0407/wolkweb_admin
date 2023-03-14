<?php 

 // return [
 //          'user_image' => env('USER_IMAGE', url('/').'/public/storage/profile_image/'),
 //          'advertisement_image'=> env('ADVERTISEMENT_IMAGE', url('/').'/public/storage/sponser_image/'),
 //          'post_image' => env('POST_IMAGE',url('/').'/public/storage/post_image/'),
 //          'sponser_image' => env('POST_IMAGE',url('/').'/public/storage/sponser_img/'),
 //          'star_image' => env('POST_IMAGE',url('/').'/public/storage/star_type_img/'),
 //          'user_qrimage' => env('POST_IMAGE',url('/').'/public/storage/user_qrcode/'),
 //          'imagick'=> env('IMAGICK',0),
 //          'profile_video' => env('POST_IMAGE',url('/').'/public/storage/profile_video/'),
 //          'cover_image' => env('POST_IMAGE',url('/').'/public/storage/cover_image/'),
 //     ];


 return [
          'site_title' => env('SITE_TITLE', url('/').'/storage/app/public/profile_image/'),
          'user_image' => env('USER_IMAGE', url('/').'/storage/app/public/profile_image/'),
          'advertisement_image'=> env('ADVERTISEMENT_IMAGE', url('/').'/storage/app/public/sponser_image/'),
          'post_image' => env('POST_IMAGE',url('/').'/storage/app/public/post_image/'),
          'sponser_image' => env('SPONSER_IMAGE',url('/').'/storage/app/public/sponser_img/'),
          'star_image' => env('STAR_IMAGE',url('/').'/storage/app/public/star_type_img/'),
          'user_qrimage' => env('USER_QRIMAGE',url('/').'/storage/app/public/user_qrcode/'),
          'imagick'=> env('IMAGICK',0),
          'profile_video' => env('PROFILE_VIDEO',url('/').'/storage/app/public/profile_video/'),
          'cover_image' => env('COVER_IMAGE',url('/').'/storage/app/public/cover_image/')
     ];








 ?>