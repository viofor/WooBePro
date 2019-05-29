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

Auth::routes(['verify' => true]);

Route::get('/welcome', function () {
    return view('auth.newuser');
});

Route::get('profile/accst', 'DetailController@accSettings');

Route::get('profile/dayoff', 'DetailController@daysoff');

Route::get('profile/userprofile/{userlink}', 'DetailController@userprofile');

Route::put('profile/accstup', 'DetailController@accSettingsUpdate');

Route::post('profile/video', 'DetailController@uploadVideo');

Route::resource('profile', 'DetailController');

Route::resource('image', 'FileUploadController');

Route::get('/home', 'HomeController@index')->name('home');
