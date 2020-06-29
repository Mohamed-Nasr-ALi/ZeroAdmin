<?php

use Illuminate\Support\Facades\Route;

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

Route::post('login/vendor', 'API\ClientController@loginVendor');
Route::post('login', 'API\ClientController@login');
Route::post('check', 'API\ClientController@registerstep1');
Route::post('register', 'API\ClientController@registerstep2');
Route::post('forget', 'API\ClientController@forgetPassword');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('details', 'API\ClientController@details');
    Route::post('update', 'API\ClientController@edit');
    Route::post('change/password', 'API\ClientController@changePassword');
    Route::post('firebase/update', 'API\ClientController@firebase_update');
    Route::post('logout', 'API\ClientController@logout');
    Route::post('pin', 'API\ClientController@check_pin');
    Route::post('set/profile/picture', 'API\ClientController@updateProfilePicture');
    Route::post('edit/agent', 'API\ClientController@editAgent');
    Route::post('set/business/logo', 'API\ClientController@updateBusinessLogo');

    Route::get('request/in', 'API\RequestController@inRequests');
    Route::get('request/out', 'API\RequestController@outRequests');
    Route::post('request/create', 'API\RequestController@create');
    Route::post('request/accept', 'API\RequestController@accept');
    Route::post('request/denay', 'API\RequestController@denay');
    Route::get('request/{id}', 'API\RequestController@getRequest');

    Route::get('transactions/graph', 'API\TransactionController@graph');
    Route::get('transactions/{id}', 'API\TransactionController@showTransactionItem');
    Route::get('transactions', 'API\TransactionController@transactions');

    Route::get('notification', 'API\NotificationController@getNotification');
    Route::post('notification/delete', 'API\NotificationController@deleteNotification');

    Route::post('payment', 'API\PaymentController@makePayment');

    Route::post('paycode/create', 'API\PaycodeController@create');
    Route::post('paycode/use', 'API\PaycodeController@usePaycode');
    Route::post('paycode/state', 'API\PaycodeController@getPaycodeState');
    Route::post('pay', 'API\PaycodeController@pay');

    Route::post('contact', 'API\ContactController@checkContact');
    Route::post('friend/send/request', 'API\FriendController@sendFiendRequest');
    Route::get('friend/in/request', 'API\FriendController@getInFriendRequests');
    Route::get('friend/out/request', 'API\FriendController@getOutFriendRequests');
    Route::post('friend/accept/request', 'API\FriendController@acceptFriendRequest');
    Route::post('friend/denay/request', 'API\FriendController@denayFriendRequest');
    Route::post('friend/delete', 'API\FriendController@delete');
    Route::get('friend', 'API\FriendController@getFriends');

    Route::get('category', 'API\StoreController@getCategorys');
    Route::get('store/{type_id}', 'API\StoreController@getStores');
    Route::get('agent/transactions', 'API\StoreController@transactions');
});
Route::get('get_all_countries','API\CountryController');
