<?php

use Illuminate\Support\Facades\Route;

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

Route::post('login', 'AdminController@login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('details', 'AdminController@details');
    Route::post('update', 'AdminController@edit');
    Route::post('change/password', 'AdminController@changePassword');
    Route::post('logout', 'AdminController@logout');

    Route::post('pay', 'AdminController@pay');

    Route::get('transactions/my', 'API\TransactionController@myTransactions');
    Route::get('transactions/cc', 'API\TransactionController@ccTransactions');
    Route::get('transactions/cm', 'API\TransactionController@cmTransactions');

});
/**********************************************************************************************/


Route::group(['middleware'=>'admin_login'], function(){
    Route::get('/admin', 'ADMIN\HomeController@index')->name('home');
    Route::group(['namespace' => 'ADMIN','prefix'=>'admin'], function()
    {
        Route::resources([
            'agents' => 'AgentController',
            'types' => 'TypeController',
            'friends' => 'FriendController',
            'wallets' => 'WalletController',
            'requests' => 'RequestController',
            'countries' => 'CountryController'
        ]);
        Route::get('transaction-cc','TransactionController@index_cc_history')->name('show_cc_history_transaction');
        Route::get('transaction-cm','TransactionController@index_cm_history')->name('show_cm_history_transaction');
        Route::get('show-transaction/{id}','TransactionController@show')->name('show_transaction');
        Route::get('send/money','SendMoneyController@index')->name('send_money');
        Route::post('admin-send-moneys','SendMoneyController@sendMoneyTransaction')->name('send_money_transaction');
        Route::get('get_total','API\AnalyticController@total');
        Route::get('get_transactions_types_count','API\AnalyticController@TransactionsTypesCount');
    });
});

Route::get('/','ADMIN\HomeController@welcome_page')->name('welcome_page');
Route::post('login_admin','ADMIN\HomeController@login_admin')->name('login_admin');
Route::post('logout_admin','ADMIN\HomeController@logout_admin')->name('logout_admin');
