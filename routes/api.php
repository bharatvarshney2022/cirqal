<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'apiController@userLogin');
Route::post('registeration', 'apiController@userRegister');
Route::post('verify', 'apiController@userVerify');
Route::post('forgot-password', 'apiController@userForgotPassword');
Route::post('change-password', 'apiController@userChangePassword');

Route::get('category', 'apiController@getCategory');
Route::get('post', 'apiController@getPost');

Route::post('send-sms', 'apiController@sendSMS');
