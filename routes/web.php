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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// 'middleware' => ['auth', 'admin', 'ban']
Route::group([], function () {
    Route::get('_dmgt/{any}', 'ManagementController@index')->where('any', '.*');
});

Route::group([], function () {
    Route::get('_ds/{any}', 'StudentController@index')->where('any', '.*');
});

Route::group([], function () {
    Route::get('_dt/{any}', 'TutorController@index')->where('any', '.*');
});
