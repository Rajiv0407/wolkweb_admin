<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/email','user\EmailController@sendEmail');
Route::get('/phpinfo',function(){
	echo phpinfo();
});

Route::get('/','admin\administratorController@login');
Route::get('/administrator','admin\administratorController@login');
Route::post('/administrator/do_login','admin\administratorController@do_login');
Route::get('/administrator/logout','admin\administratorController@logout');

Route::group(['middleware'=>'PreventBackHistory'],function(){

/* Car dashboard */
Route::get('/administrator/dashboard','admin\dashboardController@index');
// Route::post('/administrator/dashboard','admin\administratorController@dashboard');

Route::post('/dashboard','admin\dashboardController@admin_dashboard');
Route::post('/bookingYearlyChart','admin\dashboardController@bookingYearlyChart');

/* Car management */

Route::post('/carManagement','admin\carManagementController@index');
Route::get('/carManagement/carData','admin\carManagementController@carData');
Route::post('carManagement/changeStatus','admin\carManagementController@changeStatus');
Route::post('carManagement/deleteRecord','admin\carManagementController@deleteRecord');
Route::post('carManagement/detail','admin\carManagementController@detail');
Route::post('carManagement/addCar','admin\carManagementController@addCar');
Route::post('carManagement/saveCar','admin\carManagementController@saveCar');
Route::post('carManagement/editVehicle','admin\carManagementController@editVehicle');
Route::post('carManagement/updateVehicle','admin\carManagementController@updateVehicle');
/* car detail */
Route::post('carManagement/basicDetail','admin\carManagementController@basicDetail');
Route::post('carManagement/carImage','admin\carManagementController@carImage');

Route::get('carManagement/carReviews','admin\carManagementController@carReviews');
Route::get('ajax_carReviews','admin\carManagementController@carManagement_ajaxReview');

Route::post('carManagement/carRentBooking','admin\carManagementController@carRentBooking');
Route::post('carManagement/updateDescription','admin\carManagementController@updateDescription');
Route::post('carManagement/addFeature','admin\carManagementController@addFeature');
Route::post('carManagement/updateVFeature','admin\carManagementController@updateVFeature');
Route::post('carManagement/deleteCarImg','admin\carManagementController@deleteCarImg');
Route::post('carManagement/uploadVImg','admin\carManagementController@uploadVImg');
Route::post('carManagement/addFeaturedImg','admin\carManagementController@addFeaturedImg');
Route::get('carManagement/carBookingData/{vehicleId}/{type}','admin\carManagementController@carBookingData');
Route::post('carManagement/bookingDetail','admin\carManagementController@bookingDetail');
Route::post('carManagement/viewVehicleImage','admin\carManagementController@viewVehicleImage');

/* Customer management */
Route::post('/customerManagement','admin\customerController@index');
Route::get('customer_datatable','admin\customerController@customerlist');
Route::post('userManagement/changeStatus','admin\customerController@changeStatus');
Route::post('/customerDetail','admin\customerController@detail');
Route::post('/delete_customer','admin\customerController@delete_customer');
Route::post('/changePassword','admin\customerController@changePassword');
Route::post('/changeAdminPassword','admin\customerController@changeAdminPassword');

/* Car Booking Controller */
Route::post('/carBooking','admin\carBookingController@index');
Route::post('/carBookingDetail','admin\carBookingController@detail');
Route::get('carBooking_datatable','admin\carBookingController@carBooking_datatable');

/* Mailbox Controller */
Route::get('administrator/mailbox','admin\mailboxController@index');
Route::get('administrator/mailbox/{messageType}','admin\mailboxController@index');
Route::post('/mailboxDetail','admin\mailboxController@detail');
Route::get('/ajax_inboxList','admin\mailboxController@ajax_inboxList');
Route::post('/messageReply','admin\mailboxController@messageReply');
Route::post('/deleteDetailMessage','admin\mailboxController@delDetailMessage');
Route::post('/deleteInboxMessg','admin\mailboxController@deleteInboxMessg');
Route::post('/messageInfo','admin\mailboxController@messageInfo');
Route::post('/getUnreadCount','admin\mailboxController@getUnreadCount');

/* Rating Controller */
Route::get('administrator/rating','admin\ratingController@index');
Route::get('administrator/ajax_rating','admin\ratingController@ajax_ratingReview');
Route::post('approveReview','admin\ratingController@approveReview');
Route::post('rejectReview','admin\ratingController@rejectReview');

/* Contact Support */
Route::post('/contactSupport','admin\ratingController@contactSupport');
Route::get('/contactUs_datatable','admin\ratingController@contactUs_datatable');
Route::post('/delete_contactus','admin\ratingController@delete_contactus');


/* Notification Controller */
Route::post('/notification','admin\notificationController@index');
Route::get('notify_datatable','admin\notificationController@notify_datatable');
Route::post('addNotify','admin\notificationController@addNotify');
Route::post('saveNotify','admin\notificationController@saveNotify');
Route::post('editNotify','admin\notificationController@editNotify');
Route::post('updateNotify','admin\notificationController@updateNotify');
Route::post('delete_announced_list','admin\notificationController@delete_aNList');
Route::post('announce_Status','admin\notificationController@announce_Status');
Route::post('announce_detail','admin\notificationController@announce_detail');
Route::post('/create_notification','admin\notificationController@detail');
Route::post('/notificationFor','admin\notificationController@notifyFor');
Route::get('masterController/notificationFor_datatable','admin\masterController@notificationFor_datatable');
Route::post('saveNotifyFor','admin\notificationController@saveNotifyFor');
Route::post('editNFor','admin\notificationController@editNFor');
Route::post('updateNFor','admin\notificationController@updateNFor');
Route::post('deleteNFor','admin\notificationController@deleteNFor');
Route::post('nforStatus','admin\notificationController@nforStatus');

/* CMS Controller */
Route::post('/termCondition','admin\cmsController@termCondition');
Route::post('/saveTermCondition','admin\cmsController@saveTermCondition');

Route::post('/privacyPolicy','admin\cmsController@privacyPolicy');
Route::post('/savePrivacyPolicy','admin\cmsController@savePrivacyPolicy');

Route::post('/helpSupport','admin\cmsController@helpSupport');
Route::post('/saveHelp','admin\cmsController@saveHelp');

Route::post('termCondition/upload', 'CkeditorController@upload')->name('ckeditor.upload');

/* Master Controller */
Route::post('/bodyType','admin\masterController@bodyType');
Route::get('masterController/bType_datatable','admin\masterController@bType_datatable');
Route::post('/saveBodyType','admin\masterController@saveBodyType');
Route::post('/editBodyType','admin\masterController@editBodyType');
Route::post('/updateBodyType','admin\masterController@updateBodyType');
Route::post('/deleteBodyType','admin\masterController@deleteBodyType');
Route::post('/bodyType/changeStatus','admin\masterController@bodyTypeStatus');
Route::post('/fuleType','admin\masterController@fuleType');
Route::post('/saveFuleType','admin\masterController@saveFuleType');
Route::post('/updateFuelType','admin\masterController@updateFuelType');
Route::post('/fuelType/deleteRecord','admin\masterController@deleteRecord');
Route::post('/fuelType/changeStatus','admin\masterController@fuelStatus');
Route::post('/editFuelType','admin\masterController@editFuelType');
Route::get('masterController/fuel_datatable','admin\masterController@fuel_datatable');
Route::post('/transmissionType','admin\masterController@transmissionType');
Route::get('masterController/transmission_datatable','admin\masterController@transmission_datatable');
Route::post('/transType/changeStatus','admin\masterController@transChangeStatus');
Route::post('/deleteTransType','admin\masterController@deleteTransType');
Route::post('/saveTransmissionType','admin\masterController@saveTransmissionType');
Route::post('/editTransmission','admin\masterController@editTransmission');
Route::post('/updateTransType','admin\masterController@updateTransType');
/* vehicle features */
Route::post('/vehicleFeatures','admin\masterController@vehicleFeatures');
Route::get('masterController/features_datatable','admin\masterController@features_datatable');
Route::post('/featureStatus','admin\masterController@featureStatus');
Route::post('/saveFeature','admin\masterController@saveFeature');
Route::post('/deleteFeature','admin\masterController@deleteFeature');
Route::post('/editFeature','admin\masterController@editFeature');
Route::post('/updateFeature','admin\masterController@updateFeature');
/* country , state and city */
Route::post('/countryList','admin\masterController@countryList');
Route::get('masterController/country_datatable','admin\masterController@country_datatable');
Route::post('/saveCountry','admin\masterController@saveCountry');
Route::post('/deleteCountry','admin\masterController@deleteCountry');
Route::post('/editCountry','admin\masterController@editCountry');
Route::post('/updateCountry','admin\masterController@updateCountry');
Route::post('/countryStatus','admin\masterController@countryStatus');
/* state */
Route::post('/stateList','admin\masterController@stateList');
Route::get('masterController/state_datatable','admin\masterController@state_datatable');
Route::post('/saveState','admin\masterController@saveState');
Route::post('/deleteState','admin\masterController@deleteState');
 Route::post('/editState','admin\masterController@editState');
Route::post('/updateState','admin\masterController@updateState');
 Route::post('/stateStatus','admin\masterController@stateStatus');
/*city*/
Route::post('/cityList','admin\masterController@cityList');
 Route::get('masterController/city_datatable/{stateId}','admin\masterController@city_datatable');

 Route::post('/saveCity','admin\masterController@saveCity');
 Route::post('/deleteCity','admin\masterController@deleteCity');
 Route::post('/editCity','admin\masterController@editCity');
Route::post('/updateCity','admin\masterController@updateCity');
 Route::post('/cityStatus','admin\masterController@cityStatus');
 

Auth::routes();

});

Route::get('/laravel-ajax-pagination','admin\ratingController@productList');

Route::get('/termCondition','admin\masterController@termCondition');
Route::get('/privacyPolicy','admin\masterController@privacyPolicy');




