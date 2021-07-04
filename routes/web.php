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

Route::get('/home', 'LotteryController@index')->name('home');
Route::resource('home/lotteries','LotteryController');
Route::resource('home/profiles','ProfileController');
Route::resource('home/stockrequests', 'StockRequestController')->except(['create']);
Route::get('home/stockrequests/{id}/{type}/create','StockRequestController@create')->name('stockrequests.create');
Route::post('home/stockrequests/{id}/answer/','StockRequestController@answerStockRequest')->name('stock.request.answer');
Route::post('home/{id}/stockrequestchange','StockRequestController@changeStockOwner')->name('stocks.change.owner');

Route::resource('home/installments','InstallmentController');
Route::get('home/{lotId}/manageinstallments','InstallmentController@manageInstallments')->name('installments.manage');
Route::post('home/choosewinnerbymanager', 'LotteryController@chooseWinnerByManager')->name('lots.choose.winner');
Route::post('home/{stockId}/addStockforLotteryManager', 'StockRequestController@addStockforLotteryManager')->name('add.stocks.for.manager');
Route::get('home/lottery/{lottery}/like','LotteryController@like')->name('lotteries.like');

Route::resource('home/orders','OrderController');
Route::resource('home/payments','PaymentController');
Route::get('home/checkoutrequest','PaymentController@checkoutRequest' )->name('checkout.request');
Route::put('home/checkoutrequest','PaymentController@checkout' )->name('checkout');

Route::get('home/showactivecodeform','ActivationCodeController@showForm')->name('show.activation.code');

Route::post('login2','Login2Controller@login')->name('login2');

Route::get('home/showactivecodeform2','ActivationCode2Controller@showForm')->name('show.activation.code2');
Route::post('register2','Register2Controller@register')->name('register2');

Route::resource('home/tickets','TicketController');