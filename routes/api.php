<?php

use Illuminate\Http\Request;
use App\Http\Middleware\EnsureTokenIsValid;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });





Route::group(['prefix' => 'v1', 'namespace' => 'API\v1'], function () {

 Route::post('/test','authController@testData');
 Route::post('/login','authController@login');
 Route::post('/signup','authController@register');

 Route::post('/forgotPassword','authController@forgotPassword');
 Route::post('/verifyOTP','authController@verifyOTP');
 Route::post('/resetPassword','authController@resetPassword');
 Route::post('/contactUs','contactUs@contactUs');



 Route::middleware('EnsureTokenIsValid')->group(function () {

     /* user api */
     Route::post('/updateProfile','authController@editProfile');
     Route::post('/updateProfileImage','authController@updateProfileImage');
     Route::post('/userInfo','authController@userInfo');
     Route::post('/changePassword','authController@changePassword');

     /* vehicle api */
     Route::post('/saveVehicle','vehicleRegistration@saveVehicle');
     Route::post('/addVehicle','vehicleRegistration@addVehicle');
     Route::post('/addVehicleImage','vehicleRegistration@addVehicleImage');
     Route::post('/vehicleReview','vehicleRegistration@vehicleReview');
     Route::post('/vehicleReviewSave','vehicleRegistration@vehicleReviewSave');
     
     /* favourite vehicle*/
     Route::post('/addFavouriteVehicle','vehicleRegistration@addFavouriteVehicle');
     Route::post('/favouriteVehicleList','vehicleRegistration@favouriteVehicleList');

     /* messages api*/
     Route::post('/getConversationId','messageController@getConversation');
     Route::post('/sendMessage','messageController@sendMessage');
     Route::post('/messageList','messageController@messageList');
     Route::post('/messageDetail','messageController@messageDetail');
     
     /* notification*/
     Route::post('/updateDeviceToken','notificationController@updateDeviceToken');
     Route::post('/notificationList','notificationController@notificationList');
     Route::post('/notifySetting','notificationController@notifySetting');
     //my trips
     Route::post('/myTrips','vehicleRegistration@myTrips');
     Route::post('/bookingImg','bookingController@bookingImg');

     //profile info
    Route::post('/userProfile','bookingController@userProfile');

    Route::post('/unLockVehcile','bookingController@unLockVehcile');

       Route::post('/vehicleList','vehicleRegistration@vehicleList');
   Route::post('/vehicleFilter','vehicleRegistration@vehicleFilter');
   Route::post('/vehicleDetail','vehicleRegistration@vehicleDetail');
    
      //booking vehicle
      Route::post('/checkBookingAvailability','bookingController@bookingAvailability');
      Route::post('/vehicleBooking','bookingController@bookingVehicle');
      Route::post('/updatePayment','bookingController@updatePaymentStatus');
    /*pending API */
       /* update user current location */
       Route::post('/updateCurrentLocation','bookingController@updateCurrentLocation');
       
    Route::post('/sendEmailPwd','authController@sendPwdEmail');
      Route::post('/state_list','authController@state_list');
      Route::post('/city_list','authController@city_list');
      // Route::post('/city_listing','authController@state_listing');
            Route::post('/getUserId','authController@getUserId');
       // Route::post('/booking','authController@getUserId');
      Route::get('/privacyPolicy','authController@privacyPolicy');
      Route::get('/termCondition','authController@termCondition');
      Route::get('/help','authController@help_');
      Route::post('/social_login','authController@social_login');
      Route::post('/vehicleAwaykm','bookingController@vehicleAwaykm');  
 }); 


      Route::post('/carListConfirmationMail','vehicleRegistration@listCarMailConfirmation');  
    
 });

