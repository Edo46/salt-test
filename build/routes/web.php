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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', function () {
    Auth::logout();
    return response()->redirectTo('/login');
});

Route::get('/home', 'DashboardController@index')->name('home')->middleware('auth');

Route::middleware(['admin'])->prefix('manage-products')->group(function () {
    Route::get('/', 'ProductsController@index')->name('manage-products.index');
    Route::get('/data', 'ProductsController@ajaxTable')->name('manage-products.data');
    Route::post('/input', 'ProductsController@input')->name('manage-products.input');
    Route::post('/edit/{id}', 'ProductsController@edit')->name('manage-products.edit');
    Route::post('/delete/{id}', 'ProductsController@delete')->name('manage-products.delete');
});

Route::middleware(['admin'])->prefix('manage-users')->group(function () {
    Route::get('/', 'UserController@index')->name('manage-users.index');
    Route::get('/data', 'UserController@ajaxTable')->name('manage-users.data');
    Route::post('/input', 'UserController@input')->name('manage-users.input');
    Route::post('/edit/{id}', 'UserController@edit')->name('manage-users.edit');
    Route::post('/delete/{id}', 'UserController@delete')->name('manage-users.delete');
});

Route::middleware(['users'])->prefix('topup')->group(function () {
    Route::get('/', 'TopUpController@index')->name('topup.index');
    Route::get('/data', 'TopUpController@ajaxTable')->name('topup.data');
    Route::get('/checkout/{id}', 'TopUpController@checkoutPage')->name('topup.checkout');
    Route::post('/buy/{id}', 'TopUpController@buy')->name('topup.buy');
    Route::post('/checkout-process/{id}', 'TopUpController@checkoutProcess')->name('topup.checkout-process');
    Route::post('/cancel/{id}', 'TopUpController@delete')->name('topup.cancel');
});

Route::middleware(['users'])->prefix('transaction-history')->group(function () {
    Route::get('/', 'TransactionHistoryController@index')->name('transaction-history.index');
    Route::get('/data', 'TransactionHistoryController@ajaxTable')->name('transaction-history.data');
});
