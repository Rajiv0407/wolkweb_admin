<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\PostController;
use App\Http\Controllers\api\v1\SocialController;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Middleware\Cors;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/apiDetail',function(Request $request){
    return View('service_info');
 }); 
 

Route::group(['prefix' => 'v1'], function () {

 Route::post('/socialPointCalculation',[SocialController::class, 'social_point_calculation']);

 Route::get('/test',[UserController::class, 'testData']);
 Route::post('/signup',[UserController::class, 'register']);
 Route::post('/do_login',[UserController::class, 'doLogin']);
 Route::get('/termCondition',[UserController::class, 'termCondition']);
 Route::get('/privacyPolicy',[UserController::class, 'privacyPolicy']);
Route::post('/forgotPassword',[UserController::class, 'forgotPassword']);
Route::post('/verifyOTP',[UserController::class, 'verifyOTP']); 
Route::post('/resetPassword',[UserController::class, 'resetPassword']); 

Route::get('/updateEncryptionKey',[UserController::class, 'update_encryption']); 
Route::post('/saveContactus',[PostController::class, 'save_contactus']);  

Route::post('/sendContactUsEmail',[UserController::class,'sendContactUsEmail']);

Route::middleware([Cors::class,EnsureTokenIsValid::class])->group(function () {    
    
    Route::post('/updateSocialInfo',[UserController::class, 'updateSocialInfo']);
    Route::post('/user_interest',[UserController::class, 'user_interest']);
    Route::post('/logout',[UserController::class, 'logout']);
    Route::post('/save_sponser',[UserController::class, 'save_sponser']);    
    Route::post('/notificationsList',[UserController::class, 'notificationsList']);
    Route::post('/udpateNotifications',[UserController::class, 'udpateNotifications']);
    Route::post('/deActivateUserAccount',[UserController::class, 'deActivateUserAccount']);
    Route::post('/updateUserProfile',[UserController::class, 'updateUserProfile']);
    Route::post('/updateProfileImage',[UserController::class, 'updateProfileImage']);
    Route::post('/changePassword',[UserController::class, 'changePassword']);

    
    Route::post('/userList',[UserController::class, 'user_list']);
    Route::get('/user_filter',[UserController::class, 'user_filter']);
    Route::post('/userDetail',[UserController::class, 'user_detail']);
    Route::post('/userProfileDetail',[UserController::class, 'profile_detail']);
    Route::get('/countryList',[UserController::class, 'country_list']);
    
    //post
    Route::post('/savePost',[PostController::class, 'save_post']);  
	Route::post('/saveComment',[PostController::class, 'save_comment']); 
	Route::post('/postList',[PostController::class, 'post_list']); 
    Route::post('/addLike',[PostController::class, 'add_like']); 
    Route::get('/sendPwdEmail',[PostController::class, 'sendPwdEmail']); 
    Route::post('/postDetail',[PostController::class, 'post_detail']); 
    
    Route::post('/fileList',[PostController::class, 'file_list']);

    //user follow following
    Route::post('/followingRequest',[UserController::class, 'following_request']);    
    Route::post('/acceptFollowing',[UserController::class, 'accept_following']); 
    Route::post('/followingList',[UserController::class, 'following_list']); 
    Route::post('/followerList',[UserController::class, 'follower_list']); 
    Route::post('/followingRequestList',[UserController::class, 'following_request_list']); 
    Route::post('/userFollowerList',[UserController::class, 'user_follower_list']); 
    Route::post('/userQrCodeDetail',[UserController::class, 'user_qrCodeDetail']); 

    

    //Social Connect
    Route::post('/socialConnect',[UserController::class, 'social_connect']); 

    //user host
    Route::post('/addHost',[UserController::class,'add_user_host']); 
    Route::post('/removeHost',[UserController::class, 'remove_user_host']);
    Route::post('/acceptRequestHost',[UserController::class, 'accept_request_host']); 

    //user profile video
    Route::post('/addProfileVideo',[UserController::class,'profile_video']); 
    Route::post('/hostUser',[UserController::class,'host_user']);  
    Route::post('/userHostList',[UserController::class,'user_host_list']);  

    //user dashboard api
    Route::post('/dashboard',[UserController::class, 'user_dashboard']); 
    Route::post('/coverImage',[UserController::class, 'cover_image']); 

    // Advertisement and sponser     
    Route::post('/sponserList',[PostController::class, 'sponser_list']);
    Route::post('/saveAdvertisement',[PostController::class, 'save_advertisement']); 
    Route::post('/advertisement_listing',[UserController::class, 'advertisement_listing']);
    Route::post('/advertisementDetail',[UserController::class, 'sponser_detail']); 
    Route::post('/adsSponserList',[PostController::class, 'ads_sponser_list']);
    
    //user 05-April-2023
    Route::post('/removeProfileImage',[UserController::class, 'removeProfileImage']);
    Route::post('/updateCoverImage',[UserController::class, 'updateCoverImage']);
    Route::post('/removeCoverImage',[UserController::class, 'removeCoverImage']);
    
    // Advertisement Delete and Edit API
    Route::post('/advsDelete',[UserController::class, 'advertisement_delete']);
    Route::post('/advertisementEdit',[UserController::class, 'advertisement_edit']);
    Route::post('/isPrivateAccount',[UserController::class, 'is_private_account']);

    //Check Private User Or Not
    Route::post('/checkPrivateAccount',[UserController::class, 'check_private_account']);
    
});

Route::get('/clear', function() {
     \Artisan::call('route:cache');
     \Artisan::call('config:cache');
     \Artisan::call('cache:clear');
     \Artisan::call('view:clear');
     \Artisan::call('optimize:clear');
 });

});