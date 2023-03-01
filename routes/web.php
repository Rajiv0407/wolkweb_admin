<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookSocialiteController;
use App\Http\Controllers\admin\AdministratorController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\RatingController;
use App\Http\Middleware\PreventBackHistory;
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

Route::get('/', function () {
    return view('welcome');
});



// Route::get('auth/facebook', [FacebookSocialiteController::class,'redirectToFB']);
// Route::get('callback/facebook', [FacebookSocialiteController::class,'handleCallback']);

Route::get('insta/login',[FacebookSocialiteController::class,'redirectToInstagramProvider'])->name('insta.login');
Route::get('insta/callback',[FacebookSocialiteController::class,'instagramProviderCallback'])->name('insta.login.callback');


Route::get('/facebookLogin',[FacebookSocialiteController::class,'fbLogin']);
Route::get('/fbCallback',[FacebookSocialiteController::class,'fbResponse']);
Route::get('/fbBasicInfo',[FacebookSocialiteController::class,'fbProfileDataResponse']);

//facebook page account and intagram bussiness account 
Route::get('/fbConnect',[FacebookSocialiteController::class,'fb_connect']);
Route::get('fbSuccess',[FacebookSocialiteController::class,'fbSuccessResp'])->name('fbSuccess');;
Route::get('fbError',[FacebookSocialiteController::class,'fb_error'])->name('fbError');;


Route::get('swagger', function () {
	
    return view('swagger');
});



Route::get('/administrator',[AdministratorController::class,'login']);
Route::post('/administrator/do_login',[AdministratorController::class,'do_login']);
Route::get('/administrator/logout',[AdministratorController::class,'logout']);

Route::group(['middleware'=>'PreventBackHistory'],function(){

/* Car dashboard */
 Route::get('/administrator/dashboard',[DashboardController::class,'index']);
 Route::post('/dashboard',[DashboardController::class,'admin_dashboard']);
 Route::post('/bookingYearlyChart',[DashboardController::class,'bookingYearlyChart']);

// 	/* Customer management */
Route::post('/customerManagement',[CustomerController::class,'index']);
Route::get('customer_datatable',[CustomerController::class,'customerlist']);
Route::post('userManagement/changeStatus',[CustomerController::class,'changeStatus']);
Route::post('/customerDetail',[CustomerController::class,'detail']);
Route::post('/delete_customer',[CustomerController::class,'delete_customer']);
Route::post('/changePassword',[CustomerController::class,'changePassword']);
Route::post('/changeAdminPassword',[CustomerController::class,'changeAdminPassword']);

/* Contact Support */
Route::post('/contactSupport',[RatingController::class,'contactSupport']);
Route::get('/contactUs_datatable',[RatingController::class,'contactUs_datatable']);
Route::post('/delete_contactus',[RatingController::class,'delete_contactus']);

Auth::routes();

});

