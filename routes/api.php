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
Route::get('/verified-only', function (Request $request) {
    // dd('your are succesfully verified '.auth()->user()->firstname);
    return response(['message' => 'your are succesfully verified', 'status' => true]);
})->middleware('auth:api', 'verified');

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::post('/logout', 'Api\AuthController@logout')->middleware('auth:api');

Route::post('/EditUserNames', 'Api\AuthController@update_name')->middleware('auth:api', 'verified');
Route::post('/EditUserEmail', 'Api\AuthController@update_email')->middleware('auth:api', 'verified');
Route::post('/EditUserPhone', 'Api\AuthController@update_phone')->middleware('auth:api', 'verified');
Route::post('/EditUserPassword', 'Api\AuthController@update_password')->middleware('auth:api', 'verified');

Route::post('/confirm-password', 'Api\ConfirmPasswordController@confirm');


Route::post('/password/email', 'Api\ForgotPasswordController@sendResetLinkEmail');
Route::post('/password/reset', 'Api\ResetPasswordController@reset');
Route::get('/email/resend', 'Api\VerificationController@resend')->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', 'Api\VerificationController@verify')->name('verification.verify');


Route::apiResource('/businesses', 'Api\BusinessesController')->middleware('auth:api', 'verified');




