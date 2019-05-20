<?php
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
Route::prefix('auth')->group(function(){
    Route::post('login','AuthController@login');
    Route::post('logout','AuthController@logout');
});

Route::post('register','CommerceController@register');
Route::post('confirmation/{token}','UserController@checkToken2User');
Route::post('verify-token/{token}','UserController@verify_token');
Route::post('resend-email-confirm','UserController@resendEmailConfirm');
//RESCUE PASSWORD
Route::post('password-reset/{token}','UserController@rescuePassNoLog');
Route::post('password-reset','UserController@initRecuePassNologin');
//RESCUE PASSWORD-END

Route::get('tasa','AvgController@lastAvg')->middleware('jwt');
Route::get('avg-week','AvgController@avgWeek')->middleware('jwt');
Route::post('user_wallet','UserController@associateWallet');
Route::get('get-better-rate','CommerceController@betterRate')->middleware('jwt');
Route::post('user_wallet','UserController@associateWallet')->middleware('jwt');
Route::delete('dis-user-wallet','UserController@disassociate')->middleware('jwt');
Route::post('bank-commerce','CommerceController@bank2commerce')->middleware('jwt');
Route::delete('dis-bank-commerce/{bank_id}','CommerceController@disassociate')->middleware('jwt');
Route::get('dashboard','TransactionController@dashboard')->middleware('jwt');

Route::prefix('basic-data')->group(function(){
    Route::get('currencies','BasicData@getCurrencies');
    Route::get('countries','BasicData@getCountries');
    Route::get('payment-methods','BasicData@getPaymentMethods');
});

Route::prefix('sell')->group(function(){
    Route::get('get-ads-by-bank-sell/{bank}','PublicMarketDataSell@getBuyByBankSell');
    Route::get('get-ads-group-bank-sell','PublicMarketDataSell@getAdsGroupBankSell');
    Route::get('get-ads-by-bands','PublicMarketDataSell@getAdsByBands');
    Route::get('get-ads-all-pages','PublicMarketDataSell@getAdsAll');

});

Route::prefix('buy')->group(function(){
    Route::get('get-ads-by-bank-buy/{bank}','PublicMarketDataBuy@getBuyByBankBuy');
    Route::get('getAdsGroupBankBuy','PublicMarketDataBuy@getAdsGroupBankBuy');
});

Route::prefix('user')->group(function(){
    Route::post('store','UserController@store')->middleware('jwt');
    Route::put('update/{user_id}','UserController@update');
    Route::delete('destroy/{id}','UserController@destroy');
    Route::get('index','UserController@index');
    Route::get('show','UserController@show');
    Route::get('user-commerce-no-wallet','UserController@getUserCommerceNoWallet')->middleware('jwt');
    Route::put('change-pass','UserController@changePass');
    Route::put('change-email','UserController@changeMail');
});

Route::prefix('commerce')->group(function(){
    Route::post('store','CommerceController@store')->middleware('jwt');
    Route::put('update','CommerceController@update');
    Route::delete('destroy','CommerceController@destroy');
    Route::get('index','CommerceController@index')->middleware('jwt');
    Route::get('show','CommerceController@show');
});

Route::prefix('transaction')->group(function(){
    Route::post('store','TransactionController@store')->middleware('jwt');
    Route::get('index','TransactionController@index')->middleware('jwt');
    Route::get('index-no-validate','TransactionController@indexNoValidate')->middleware('jwt');
    Route::get('show/{transaction_id}','TransactionController@show');
    Route::put('update/{transaction_id}','TransactionController@update')->middleware('jwt');
    Route::delete('delete/{transaction_id}','TransactionController@delete');
    Route::get('get-transaction-filter/{params}','TransactionController@getDataFilter')->middleware('jwt');
});

Route::prefix('band')->group(function(){
    Route::post('store','BandController@store');
    Route::put('update','BandController@update');
    Route::delete('destroy','BandController@destroy');
    Route::get('index','BandController@index');
    Route::get('show','BandController@show');
});

Route::prefix('bank')->group(function(){
    Route::post('store','BankController@store');
    Route::put('update','BankController@update');
    Route::delete('destroy/{id}','BankController@destroy');
    Route::get('index','BankController@index')->middleware('jwt');
    Route::get('show','BankController@show');
});

Route::prefix('wallet')->group(function(){
    Route::post('store','WalletController@store')->middleware('jwt');
    Route::put('update','WalletController@update');
    Route::delete('destroy/{id}','WalletController@destroy');
    Route::get('index','WalletController@index')->middleware('jwt');
    Route::get('show','WalletController@show');
    Route::get('wallet-no-user','WalletController@walletNoUser')->middleware('jwt');
});

Route::prefix('crypto')->group(function(){
    Route::post('store','CryptoController@store');
    Route::put('update','CryptoController@update');
    Route::delete('destroy','CryptoController@destroy');
    Route::get('index','CryptoController@index');
    Route::get('show','CryptoController@show');
});

Route::prefix('blockchain')->group(function(){
    Route::get('validate/{amount_crypto}','Blockchain\BlockchainController@validateTransaction')->middleware('jwt');
});

Route::get('tbcw/{amount_crypto?}','Testnet\TestnetController@testnetValidTrans');