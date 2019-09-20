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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/address', 'AddressController');
Route::post('/loginCommit', 'UserController@commit');
Route::post('/loginVerify', 'UserController@verify');
Route::post('/loginWechat', 'UserController@wechat');

Route::resource('/user', 'UserController');
