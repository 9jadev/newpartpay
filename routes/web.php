<?php

use Illuminate\Support\Facades\Route;

// lines below is to test notification
// use Illuminate\Support\Facades\Notification;
// use App\Notifications\RegistedSuccessful;

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

// lines below is to test notification
// Route::get('/test-mail', function (){
//     Notification::route('mail', 'ahambasolomon800@gmail.com')->notify(new RegistedSuccessful());
//     return 'Sent';
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
