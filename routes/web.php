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

Auth::routes();

# Logout

Route::post("/customer-signup","customerController@websiteStore");
Route::get("/customer-signup","customerController@websiteCreate");

Route::get('/logout',function(){

   Auth::logout();

   return Redirect::to('login');

});


# Group admin panel routes under protective layer of middleware "isAdmin" which enables the access of admin panel by all the admins only

Route::group(['middleware'=>'isAdmin'],function(){

	Route::get('/', function () {
	    return Redirect::to('/dashboard');
	});

	/*Route::get('/dashboard',function(){

	    return View::make('adminpanel.dashboard');

	});*/

	Route::resource('/restaurants','restaurantController');

	Route::resource('/branches','branchController');

	Route::resource('/menus','menuController');

	Route::resource('/customers','customerController');

	Route::resource('/orders','orderController');

	Route::resource('/partners','partnerController');

	Route::get('/settings','settingController@showSettings');

	Route::post('/updateSettings','settingController@updateSettings');

	Route::post('/restaurantApproval','restaurantController@restaurantApproval');

	Route::get('/change-password/{id}','customerController@updatePassword');

	Route::put('/reset-password/{id}','customerController@resetPassword');

	Route::resource('/admins','adminController');

	Route::get('/notifications/{id}','generalController@notificationForm'); # New

	Route::post('/notifications/','generalController@customNotifications'); # New

	Route::get('/dashboard','generalController@DetailsOnMap');
	
	Route::get("/set-infomap",'generalController@setInfoMap');

	Route::get("/bulk-notifications","generalController@bulkNotifications");
	
	Route::post("/bulk-notifications","generalController@sendBulkNotifications");

	Route::resource('/coupon','CouponController');//vijay
});

Route::get('/home', 'HomeController@index');
# IOS Device Api Routes

Route::group(['prefix' => 'api'],function(){

	Route::post('/register','CustomAuth@register');

	Route::post('/login','CustomAuth@login');

	Route::post('/password/email', 'CustomAuth@forgotPassword');

	Route::post('/password/reset', 'CustomAuth@resetPassword');

	Route::get('/logout','CustomAuth@logout');

# Authenticated API Routes

	//Route::group(['middleware' => 'tokenCheck'],function(){

		Route::post('/updateCustomer','customerController@updateUser');

		Route::post('/getOrder','apiRestaurantController@getOrder'); //vijay

		Route::post('/setOrder','apiRestaurantController@setOrder'); //vijay

		Route::post('/setOrderNew','apiRestaurantController@setOrderNew'); //vijay

		Route::get('/restaurants','apiRestaurantController@getRestaurants');

		Route::get('/menus','apiRestaurantController@getMenus');

		Route::post('/getAllOrders','apiRestaurantController@getAllOrder');

		Route::post('/update-coordinates','customerController@userCoordsUpdate');

		Route::get('/getCoordinates','customerController@getUserCoordinates');

		Route::get('/customerDetails','customerController@customerDetails');

		Route::get('/verify-email/{token}','customerController@verifyEmail');

		Route::post('/partnerResponse','apiRestaurantController@partnerApprovalResponse');

		Route::get('/getnearestorder','apiRestaurantController@nearestOrder');

		Route::post('/payment','apiRestaurantController@orderPayment');
		
		Route::post('/order-cancel','apiRestaurantController@cancelOrder');
		
		Route::post('/update-devicetoken','customerController@updateDeviceToken');
		
		Route::get('/test-push','apiRestaurantController@testPushOld');
		
		Route::post('/getPartnerOrder','apiRestaurantController@getPartnerOrder');

		Route::post('/updatePartnerStatus','customerController@updatePartnerStatus');
		Route::post('/updateNotifications','generalController@updateNotificationCounter');

                Route::get('/partnerDenyResponse','apiCronController@partnerDenyResponse');


#Authencticated Routes ends

	//});

	

});

# Api Routes ends

# Route to execute Artisan command "config:cache"

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Cache Cleared Successfully'; 
});

Route::get('/send-mail', function() {
    $exitCode = Artisan::call('custom:command');
    return 'Mail Sent Successfully'; 
});
// ./ngrok http 8000

