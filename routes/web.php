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

use App\Models\Category;
use App\Models\Course;
use App\Models\Plan;
use App\Models\Tutor;
use App\Models\User;

Route::get('/', function () {

    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/staff/register', 'UserController@staff')->name('staffSignup');
Route::post('register-staff', 'UserController@registerStaff')->name('staffRegistration');

// 'middleware' => ['auth', 'admin', 'ban']
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('_management/{any}', 'ManagementController@index')->where('any', '.*');
});

Route::group(['middleware' => ['auth', 'student']], function () {
    Route::get('_student/{any}', 'StudentController@index')->where('any', '.*');
});

Route::group(['middleware' => ['auth', 'staff']], function () {
    Route::get('_staff/{any}', 'StaffController@index')->where('any', '.*');
});
