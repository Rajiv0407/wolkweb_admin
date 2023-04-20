<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookSocialiteController;
use App\Http\Controllers\admin\AdministratorController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\RatingController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\admin\NotificationController;
use App\Http\Controllers\admin\CmsController;
use App\Http\Controllers\admin\MasterController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\AdsController;
use App\Http\Controllers\admin\SocialController; 
/*FacebookSocialiteController
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'Language'],function(){
    Route::get('/message',[DashboardController::class,'index']);
	Route::get('/change-language/{lang}',[DashboardController::class,'changeLang']);    
});


Route::get('exportExcel',[MasterController::class,'exportUsers'])->name('exportUsers');
Route::post('importExcel',[MasterController::class,'import'])->name('import');
Route::get('import',[MasterController::class,'importView']);
Route::get('generate-pdf', [MasterController::class, 'generatePDF']);

Route::get('/', function () {
   return '<h3>Coming Soon.............</h3>';
});


//Soical Media
Route::get('insta/login/{userId}',[FacebookSocialiteController::class,'redirectToInstagramProvider'])->name('insta.login');
Route::get('insta/callback',[FacebookSocialiteController::class,'instagramProviderCallback'])->name('insta.login.callback');

Route::get('/facebookLogin',[FacebookSocialiteController::class,'fbLogin']);
Route::get('/fbBasicInfo',[FacebookSocialiteController::class,'fbProfileDataResponse']);
Route::get('fbSuccess',[FacebookSocialiteController::class,'fbSuccessResp'])->name('fbSuccess');
Route::get('fbProfileSuccess',[FacebookSocialiteController::class,'fbProfileSuccessResp'])->name('fbProfileSuccess');
Route::get('fbError',[FacebookSocialiteController::class,'fb_error'])->name('fbError');

Route::get('/fbConnect/{userId}',[FacebookSocialiteController::class,'fb_connect']);
Route::get('/fbCallback',[FacebookSocialiteController::class,'fbResponse']);

Route::get('/fbProfileConnect/{userId}',[FacebookSocialiteController::class,'fb_Profile_Data']);
Route::get('/userList/{encryption}',[FacebookSocialiteController::class,'user_list']);

Route::post('/userPoints',[FacebookSocialiteController::class,'user_points']);
Route::get('/userList',[FacebookSocialiteController::class,'user_list']);

// Route::get('swagger', function () {
	
//     return view('swagger');
// });



Route::get('/administrator',[AdministratorController::class,'login']);
Route::post('/administrator/do_login',[AdministratorController::class,'do_login']);
Route::get('/administrator/logout',[AdministratorController::class,'logout']);

Route::group(['middleware'=>'PreventBackHistory','middleware'=>'Language'],function(){

/* Car dashboard */
 Route::get('/administrator/dashboard',[DashboardController::class,'index']);
 Route::post('/dashboard',[DashboardController::class,'admin_dashboard']);
 Route::post('/bookingYearlyChart',[DashboardController::class,'bookingYearlyChart']);

// 	/* Customer management */
Route::post('/customerManagement',[CustomerController::class,'index']);
Route::get('customer_datatable',[CustomerController::class,'customerlist']);
Route::post('userManagement/changeStatus',[CustomerController::class,'changeStatus']);
// Route::post('/customerDetail',[CustomerController::class,'detail']);
Route::post('/delete_customer',[CustomerController::class,'delete_customer']);
Route::post('/changePassword',[CustomerController::class,'changePassword']);
Route::post('/changeAdminPassword',[CustomerController::class,'changeAdminPassword']);
Route::post('/userDetail',[CustomerController::class,'userDetail']);
Route::post('/userHost',[CustomerController::class,'userHost']);
Route::get('/userHost_datatable/{userId}/{type}',[CustomerController::class,'userHost_datatable']);
// Route::post('/masterStatus',[CustomerController::class,'masterStatus']);
Route::post('/userHostStatus',[CustomerController::class,'userHostStatus']);
Route::post('/deleteHost',[CustomerController::class,'deleteHost']);
Route::get('/userAdv_datatable/{userId}/{type}',[CustomerController::class,'userAdv_datatable']);
Route::post('/deleteUserAdv',[CustomerController::class,'deleteUserAdv']);
Route::post('/userAdvStatus',[CustomerController::class,'userAdvStatus']);
Route::post('/editUserAds',[CustomerController::class,'editUserAds']);
Route::get('/userFollower_datatable/{userId}/{type}',[CustomerController::class,'userFollower_datatable']);
Route::get('/userFollows_datatable/{userId}/{type}',[CustomerController::class,'userFollows_datatable']);

Route::post('/deleteFollower',[CustomerController::class,'deleteFollower']);
Route::post('/deleteFollows',[CustomerController::class,'deleteFollows']);

/* Contact Support */
Route::post('/contactSupport',[RatingController::class,'contactSupport']);
Route::get('/contactUs_datatable',[RatingController::class,'contactUs_datatable']);
Route::post('/delete_contactus',[RatingController::class,'delete_contactus']);

/* Notification Controller */
Route::post('/notification',[NotificationController::class,'index']);
Route::get('notify_datatable',[NotificationController::class,'notify_datatable']);

Route::post('addNotify',[NotificationController::class,'addNotify']);
Route::post('saveNotify',[NotificationController::class,'saveNotify']);
Route::post('editNotify',[NotificationController::class,'editNotify']);
Route::post('updateNotify',[NotificationController::class,'updateNotify']);
Route::post('delete_announced_list',[NotificationController::class,'delete_aNList']);
Route::post('announce_Status',[NotificationController::class,'announce_Status']);
Route::post('announce_detail',[NotificationController::class,'announce_detail']);
Route::post('/create_notification',[NotificationController::class,'detail']);
// Notification Type
Route::post('/notificationFor',[NotificationController::class,'notifyFor']);
Route::get('masterController/notificationFor_datatable',[MasterController::class,'notificationFor_datatable']);
Route::post('saveNotifyFor',[NotificationController::class,'saveNotifyFor']);
Route::post('editNFor',[NotificationController::class,'editNFor']);
Route::post('updateNFor',[NotificationController::class,'updateNFor']);
Route::post('deleteNFor',[NotificationController::class,'deleteNFor']);
Route::post('nforStatus',[NotificationController::class,'nforStatus']);

// Rank Type
Route::post('/rankType',[NotificationController::class,'rankType']);
Route::get('rankType_datatable',[MasterController::class,'rankType_datatable']);
Route::post('saveRankType',[NotificationController::class,'save_rankType']);
Route::post('editRankType',[NotificationController::class,'edit_rankType']);
Route::post('updateRank',[NotificationController::class,'updateRank']);
Route::post('deleteRank',[NotificationController::class,'delete_rank']);
Route::post('rankStatus',[NotificationController::class,'rankStatus']);

/* CMS Controller */
Route::post('/termCondition',[CmsController::class,'termCondition']);
Route::post('/saveTermCondition',[CmsController::class,'saveTermCondition']);

Route::post('/privacyPolicy',[CmsController::class,'privacyPolicy']);
Route::post('/savePrivacyPolicy',[CmsController::class,'savePrivacyPolicy']);

/* country , state and city */
Route::post('/countryList',[MasterController::class,'countryList']);
Route::get('country_datatable',[MasterController::class,'country_datatable']);
Route::post('/saveCountry',[MasterController::class,'saveCountry']);
Route::post('/deleteCountry',[MasterController::class,'deleteCountry']);
Route::post('/editCountry',[MasterController::class,'editCountry']);
Route::post('/updateCountry',[MasterController::class,'updateCountry']);
Route::post('/countryStatus',[MasterController::class,'countryStatus']);

/* interestList */
Route::post('/interestList',[MasterController::class,'interestList']);
Route::get('interest_datatable',[MasterController::class,'interest_datatable']);
Route::post('/saveInterest',[MasterController::class,'saveInterest']);
Route::post('/deleteInterest',[MasterController::class,'deleteInterest']);
Route::post('/editInterest',[MasterController::class,'editInterest']);
Route::post('/updateInterest',[MasterController::class,'updateInterest']);
Route::post('/interestStatus',[MasterController::class,'interestStatus']);

/* sponser */
Route::post('/sponserList',[MasterController::class,'sponserList']);
Route::get('sponser_datatable',[MasterController::class,'sponser_datatable']);
Route::post('/saveSponser',[MasterController::class,'save_sponser']);
Route::post('/sponserDelete',[MasterController::class,'sponserDelete']);
Route::post('/editSponser',[MasterController::class,'editSponser']);
Route::post('/updateSponser',[MasterController::class,'updateSponser']);
Route::post('/sponserStatus',[MasterController::class,'sponserStatus']);

/* post management */
Route::post('/postList',[PostController::class,'postList']);
Route::get('postDatatable',[PostController::class,'post_datatable']);
Route::post('/postStatus',[PostController::class,'postStatus']);
Route::post('/postDetail',[PostController::class,'postDetail']);
Route::post('/postComment',[PostController::class,'postCommentListing']);
Route::get('/postComments_datatable/{postId}/{type}',[PostController::class,'postComments_datatable']);
Route::post('/commentStatus',[PostController::class,'commentStatus']);
Route::post('/deleteComment',[PostController::class,'deleteComment']);
Route::get('/like_datatable/{postId}/{type}',[PostController::class,'like_datatable']);
Route::post('/likeStatus',[PostController::class,'likeStatus']);
Route::post('/deletelike',[PostController::class,'deletelike']);
Route::get('/share_datatable/{postId}/{type}',[PostController::class,'share_datatable']);
Route::post('/shareStatus',[PostController::class,'shareStatus']);
Route::post('/deleteShare',[PostController::class,'deleteShare']);
Route::get('/post_file_datatable/{postId}/{type}',[PostController::class,'post_file_datatable']);
Route::post('/postFileStatus',[PostController::class,'postFileStatus']);
Route::post('/deletePostFile',[PostController::class,'deletePostFile']);
Route::post('/delete_post',[PostController::class,'delete_post']);

/* Ads management f*/    
Route::post('/adsList',[AdsController::class,'adsList']);
Route::get('adsDatatable',[AdsController::class,'ads_datatable']);
Route::post('/adsStatus',[AdsController::class,'adsStatus']);
Route::post('/adsDelete',[AdsController::class,'adsDelete']);
Route::post('/editAds',[AdsController::class,'editAds']);
Route::post('/updateAds',[AdsController::class,'updateAds']);
Route::post('/SaveAdvertisement',[AdsController::class,'SaveAdvertisement']);

Route::post('/advertisementDetail',[AdsController::class,'advertisementDetail']); 

/* Social Point managenent */

Route::post('/socialList',[SocialController::class,'socialList']);  
Route::get('socialDatatable',[SocialController::class,'socialDatatable']); 
Route::post('/socialStatus',[SocialController::class,'socialStatus']);
Route::post('/editsocial',[SocialController::class,'editsocial']);  
Route::post('/updatesocial',[SocialController::class,'updatesocial']); 
Route::post('/SaveSocial',[SocialController::class,'SaveSocial']); 
Route::post('/socialDelete',[SocialController::class,'socialDelete']);     


/* User Social Point */
Route::post('/userPointList',[SocialController::class,'userPointList']); 
Route::get('userPointDatatable',[SocialController::class,'userPointDatatable']); 
Route::post('/userPointStatus',[SocialController::class,'userPointStatus']);  
Route::post('/userPointDetail',[SocialController::class,'userPoint_detail']); 

// User Subscriptions List
Route::post('/subscriptionList',[SocialController::class,'subscriptionList']); 
Route::get('subscriberDatatable',[SocialController::class,'subscriber_datatable']); 
Route::post('/subscriberStatus',[SocialController::class,'subscriberStatus']);
Route::post('/subscriptionDelete',[SocialController::class,'subscriptionDelete']);    

//Dashboard
Route::post('/trafficByPlateForm',[DashboardController::class,'trafficByPlateForm']);   
Route::post('/trafficByLocation',[DashboardController::class,'trafficByLocation']);   
Route::post('/advertisementChart',[DashboardController::class,'advertisementChart']); 
Route::post('/currentWeekReport',[DashboardController::class,'currentWeekReport']); 

//Subscribers
Route::post('/sendSubscribersEmail',[AdsController::class,'sendSubscribersEmail']);
Route::post('/sendSubscriberMail',[AdsController::class,'sendSubscriberMail']);


Auth::routes();

});


//webView
Route::get('/termCondition',[CustomerController::class, 'term_condition']);
Route::get('/privacyPolicy',[CustomerController::class, 'privacy_policy']);
Route::get('/followersGraph/{userId}',[CustomerController::class, 'followers_graph']);
Route::post('/socialMediaFollower',[CustomerController::class, 'social_media_follower']);

