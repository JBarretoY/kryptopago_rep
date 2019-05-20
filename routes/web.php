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

Route::get('/', function () {
    return view('welcome');
});
###ROUTES PRUEBAS
Route::get('email','UserController@genToken2ValidUser');
Route::get('avg','Cron\CronApp@fillAvgCron');
###ROUTES PRUEBAS
Route::get('vb','Cron\CronApp@updateDataVB');
Route::get('order','Cron\CronApp@getOrderBook');
Route::get('value-band','Cron\CronApp@updateDataVB');
Route::get('ads','Cron\CronApp@updateAds');
Route::get('upband','Cron\CronApp@cronUpdateBands');
Route::get('bc','Blockchain\BlockchainController@validateTransaction');
Route::get('bcw/{wallet?}','Blockchain\BlockchainController@getInfWallet');
Route::get('tbcw/{amount_crypto?}','Testnet\TestnetController@testnetValidTrans');