<?php

use Illuminate\Http\Request;

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
Route::post('/loginCommit', 'UserController@commit');
Route::post('/loginVerify', 'UserController@verify');
Route::post('/loginWechat', 'UserController@wechat');
Route::post('/secret', 'UserController@secret');

# image
Route::post('/image/avatar', 'ImageController@avatar');

# user
Route::post('/user/makeVip', 'UserController@makeVip');
Route::put('/user', 'UserController@update');
Route::get('/user', 'UserController@index');


#banner
Route::get('/banner', 'BannerController@index');

#commodity
Route::get('/commodity/home', 'CommodityController@home');
Route::post('/commodity/commodities', 'CommodityController@commodities');
Route::apiResource('/commodity', 'CommodityController', ['only' => ['index', 'show']]);

#category
Route::get('/category', 'CategoryController@index');

#Cart
Route::delete('/cart/destroyAll', 'CartController@destroyAll');
Route::apiResource('/cart', 'CartController');

#Address
Route::get('/address/default', 'AddressController@default');
Route::apiResource('/address', 'AddressController');

#Order
Route::get('/order/count', 'OrderController@count');
Route::post('/order/pay', 'OrderController@pay');
Route::post('/order/cancel', 'OrderController@cancel');
Route::post('/order/confirm', 'OrderController@confirm');
Route::apiResource('/order', 'OrderController');

#Transaction
Route::apiResource('/transaction', 'TransactionController');

#Coupon

Route::apiResource('/coupon','CouponController');

#Record
Route::get('/record', 'RecordController@index');

